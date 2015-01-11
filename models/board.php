<?php
include("simple_html_dom.php");
class Leaderboard
{

    protected $db, $leaderboard_ids;

    public $topEntryAmount = 20;

    public function __construct()
    {
        $this->db = new database;
    }

    public function fetchNewData()
    {
        $newBoardData = $this->get_data($this->returnCheatedBoardCount());

        $this->save_data($newBoardData);
    }

    public function cacheLeaderboard()
    {
        $SPBoard = self::return_leaderboards_new($mode = "0", $amount = "20");
        $COOPBoard = self::return_leaderboards_new($mode = "1", $amount = "20");
        BoardCache::setBoard("SPBoard", $SPBoard);
        BoardCache::setBoard("COOPBoard", $COOPBoard);

        $SPPointBoard = $this->makeScoreBoard($SPBoard);
        $COOPPointBoard = $this->makeScoreBoard($COOPBoard);

        BoardCache::setBoard("SPBoardPoints", $SPPointBoard);
        BoardCache::setBoard("COOPBoardPoints", $COOPPointBoard);

        $SPPointTopBoard = $this->makeTopPointBoard($SPPointBoard);
        $COOPPointTopBoard = $this->makeTopPointBoard($COOPPointBoard);

        BoardCache::setBoard("SPPointTopBoard", $SPPointTopBoard);
        BoardCache::setBoard("COOPPointTopBoard", $COOPPointTopBoard);
        BoardCache::setBoard("GlobalPointTopBoard", $this->makeGlobalPointBoard($SPPointTopBoard, $COOPPointTopBoard));

        BoardCache::setBoard("Nicknames", $this->getAllNicknames());
    }

    public static function getMaps()
    {
        $db = new database;
        $data = $db->query("SELECT steam_id, name, chapter_id, chapters.chapter_name FROM maps
                            INNER JOIN chapters ON maps.chapter_id = chapters.id
                            ORDER BY maps.id");
        while ($row = $data->fetch_assoc()) {
            $maps[$row["chapter_name"]][] = $row["name"];
        }
        return $maps;
    }

    public function get_shitlist()
    {
        $data = $this->db->query("SELECT profile_number FROM usersnew WHERE banned = 1");
        $shitlist = array();
        while ($obj = $data->fetch_row()) {
            $shitlist[] = $obj[0];
        }
        return $shitlist;
    }

    public static function convert_valve_derp_time($time)
    {
        if ($time) {
            $time = abs($time);
        }
        if (strlen($time) > 2) {
            $reversed = strrev($time);
            $miliseconds = strrev(substr($reversed, 0, 2));
            $rest_of_it = strrev(substr($reversed, 2, 6));
            $minutes = floor($rest_of_it / 60);
            if ($minutes > 0) {
                $correct_seconds = $rest_of_it - (60 * $minutes);
                if ($correct_seconds < 10) {
                    $correct_seconds = "0" . $correct_seconds;
                }
                $time = $minutes . ":" . $correct_seconds . "." . $miliseconds;
            } else {
                $time = $rest_of_it . "." . $miliseconds;
            }
        } else {
            if (strlen($time) == 1) {
                $time = "0.0" . $time;
            } else {
                $time = "0." . $time;
            }
        }
        return $time;
    }

    /**
     * Writes changes into database table `changelog`
     *
     * @param $changes Changelog array
     */
    protected function save_into_changelog($changes)
    {
        $moo_time = microtime(true);
        $data = $this->db->query("SELECT score, map_id
						FROM (
						      SELECT profile_number, score, map_id, legit
							      FROM ( 
							        SELECT 
							          profile_number, score, map_id, legit,
							          IF( @prev <> map_id, @rownum := 1, @rownum := @rownum+1 ) AS rank, 
							          @prev := map_id
							        FROM scores 
							        JOIN (SELECT @rownum := NULL, @prev := 0) AS r 
							        WHERE profile_number IN (SELECT profile_number FROM usersnew WHERE banned = 0)
							        AND legit = '1'
							        ORDER BY map_id, score ASC
							      ) AS tmp 
						      WHERE tmp.rank <= 1
						      ) s");
        $worldrecord_times = array();
        while ($row = $data->fetch_assoc()) {
            $worldrecord_times[$row["map_id"]] = $row["score"];
        }
        $query = array();
        foreach ($changes as $key => $val) {
            $wr = 0;
            if ($val[1] == $worldrecord_times[$val[2]]) {
                $wr = 1;
            }
            $query[] = "('" . $val[0] . "','" . $val[1] . "','" . $val[2] . "','" . $wr . "','" . $val[3] . "')";
        }
        $values = implode(",", $query);
        $actualquery = "INSERT INTO changelog(profile_number, score, map_id, wr_gain, previous_score) VALUES" . $values;
        $this->db->query($actualquery);

        $total_moo_time = microtime(true) - $moo_time;
        echo "Changelogging function: " . $total_moo_time . "s\n";
    }

    /**
     * Gets data for specified leaderboards
     *
     * @param $ids Array of Steam leaderboard ids and amount of entries needed to fetch
     * @return array Steam API returned data
     * @throws Exception cURL or SimpleXML errors
     */
    protected function get_data($ids = array())
    {
        $moo_time = microtime(true);

        $curl_master = curl_multi_init();
        $curl_handles = array();

        foreach ($ids as $mapID => $amount) {
            $curl_handles[$mapID] = curl_init();
            curl_setopt($curl_handles[$mapID], CURLOPT_URL, "http://steamcommunity.com/stats/Portal2/leaderboards/" . $mapID . "?xml=1&start=1&end=" . $amount);
            curl_setopt($curl_handles[$mapID], CURLOPT_HEADER, 0);
            curl_setopt($curl_handles[$mapID], CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_handles[$mapID], CURLOPT_HTTPHEADER, array(
                'Connection: Keep-Alive',
                'Keep-Alive: 300'
            ));
            curl_setopt($curl_handles[$mapID], CURLOPT_SSL_VERIFYPEER, FALSE);

            curl_setopt($curl_handles[$mapID], CURLOPT_TIMEOUT, 30);
            curl_setopt($curl_handles[$mapID], CURLOPT_DNS_CACHE_TIMEOUT, 300);

            curl_multi_add_handle($curl_master, $curl_handles[$mapID]);
        }

        $active = null;
        do {
            $status = curl_multi_exec($curl_master, $active);
            $info = curl_multi_info_read($curl_master);
            if ($info["result"] != 0) {
                throw new Exception ("<b>cURL request failed to this URL: </b>" . curl_getinfo($info['handle'], CURLINFO_EFFECTIVE_URL));
            }
        } while ($status == CURLM_CALL_MULTI_PERFORM);

        while ($active && $status == CURLM_OK) {
            if (curl_multi_select($curl_master) == -1) usleep(100); // u w0t?
            do {
                $status = curl_multi_exec($curl_master, $active);
            } while ($status == CURLM_CALL_MULTI_PERFORM);
        }

        $data = array();

        $xml_total = 0;

        foreach ($ids as $mapID => $amount) {
            curl_multi_remove_handle($curl_master, $curl_handles[$mapID]);
            $curlgetcontent = curl_multi_getcontent($curl_handles[$mapID]);
            if($curlgetcontent) {
                $xml = microtime(true);
                try {
                    $leaderboard = simplexml_load_string(utf8_encode($curlgetcontent));
                } catch (Exception $e) {
                    throw new Exception("SimpleXML error: " . $e);
                }

                libxml_use_internal_errors(true);
                $sxe = simplexml_load_string($leaderboard);
                if ($sxe === false) {
                    foreach (libxml_get_errors() as $error) {
                        throw new Exception ("<b>SimpleXML error: </b>" . $error->message . '\n');
                    }
                }

                foreach ($leaderboard->entries as $key2 => $val2) {
                    foreach ($val2 as $d => $b) {
                        $steamid = $b->steamid;
                        $score = $b->score;
                        $data[$mapID][(string)$steamid] = (string)$score;
                    }
                }
                $tt = microtime(true) - $xml;
                $xml_total = $xml_total + $tt;
            }
        }
        curl_multi_close($curl_master);

        echo "Leaderboard Fetchnew XML: " . $xml_total . "\n";

        $total_moo_time = microtime(true) - $moo_time;
        echo "Leaderboard Fetchnew cURL: " . $total_moo_time . "\n";
        return $data;
    }

    /**
     * Updates database and prepares changelog array for changelogging
     *
     * @param $data_to_load Data passed from Steam API, not filtered
     */
    protected function save_data($data_to_load)
    {
        $moo_time = microtime(true);

        $db_data = $this->db->query("SELECT profile_number, score, map_id FROM scores");
        $db_data_arr = array();
        while ($row = $db_data->fetch_assoc()) {
            $db_data_arr[$row["map_id"]][$row["profile_number"]] = $row["score"];
        }
        $changelog = array();
        foreach ($data_to_load as $chamber => $chamber_val) {
            foreach ($chamber_val as $player => $score) {
                if (!isset($db_data_arr[$chamber][$player])) {
                    $this->db->query("INSERT IGNORE INTO usersnew SET profile_number = '{$player}'");
                    $this->db->query("INSERT INTO scores (profile_number, score, map_id)
									VALUES (
										'{$player}',
										'{$score}',
										'{$chamber}'
									)
						");
                    $changelog[] = array($player, $score, $chamber, 0);
                } elseif ($score != $db_data_arr[$chamber][$player]) {
                    $this->db->query("UPDATE scores
									SET score = '{$score}'
									WHERE profile_number = '{$player}'
									AND map_id = '{$chamber}'
						");
                    $changelog[] = array($player, $score, $chamber, $db_data_arr[$chamber][$player]);
                }
            }
        }
        $total_moo_time = microtime(true) - $moo_time;
        if (count($changelog) > 0) {
            $this->save_into_changelog($changelog);
        }
        echo "Leaderboard Fetchnew DB: " . $total_moo_time . "s\n";
    }

    public function returnCheatedBoardCount()
    {
        $db = new database;
        $data = $db->query("SELECT maps.steam_id, COUNT(*) AS cheatedScoreAmount
                            FROM (SELECT maps.steam_id
                                    FROM maps
                                    INNER JOIN scores ON scores.map_id = maps.steam_id
                                    LEFT JOIN usersnew ON scores.profile_number = usersnew.profile_number
                                    WHERE scores.legit = '0' OR usersnew.banned = '1'
                                    ORDER BY maps.id)
                            AS maps
                            GROUP BY steam_id");

        while ($row = $data->fetch_assoc()) {
            $cheatedAmount[$row["steam_id"]] = $row["cheatedScoreAmount"] + $this->topEntryAmount + 2;
        }
        return $cheatedAmount;
    }

    public static function return_leaderboards_new($mode = "0", $amount = "8")
    {
        $db = new database;
        if (!($stmt = $db->prepare("SELECT chap.chapter_name, maps.name, maps.steam_id, maps.is_public
											FROM maps 
											INNER JOIN chapters AS chap ON maps.chapter_id = chap.id
											WHERE is_coop = '" . $mode . "'
											ORDER BY maps.id"))
        ) {
            echo "Prepare failed: (" . $db->errno . ") " . $db->error;
        }

        if (!$stmt->execute()) {
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        $stmt->bind_result($chaptername, $mapname, $mapID, $isPublic);

        while ($stmt->fetch()) {
            $map_data[$mapID] = array($chaptername, $mapname, $isPublic);
        }

        if (!($stmt_scores = $db->prepare("SELECT IFNULL(p.boardname, s.profile_number), s.score, p.profile_number
		    								   FROM scores AS s
		    								   INNER JOIN usersnew AS p on p.profile_number = s.profile_number
		    								   LEFT JOIN changelog ON s.map_id = changelog.map_id AND s.score = changelog.score AND s.profile_number = changelog.profile_number
		    								   WHERE s.map_id = ?
		    								   AND s.legit = '1'
		    								   AND p.banned = '0'
		    								   GROUP BY s.id
		    								   ORDER BY s.score ASC, changelog.time_gained ASC, s.profile_number ASC
		    								   LIMIT " . $amount))
        ) {
            echo "Prepare failed: (" . $db->errno . ") " . $db->error;
        }
        foreach ($map_data as $key => $val) {
            if (!$stmt_scores->bind_param("i", $key)) {
                echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
            }
            if (!$stmt_scores->execute()) {
                echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
            }
            $stmt_scores->bind_result($profileID, $score, $profileNumber);

            $board[$map_data[$key][0]][$map_data[$key][1]][0] = array($key, $map_data[$key][2]);

            while ($stmt_scores->fetch()) {
                $board[$map_data[$key][0]][$map_data[$key][1]][1][] = array($profileID, self::convert_valve_derp_time($score), $profileNumber);
            }
        }
        return $board;
    }

    public static function return_chamber($id = 45467, $limit = 20)
    {
        $db = new database;
        $id = $db->real_escape_string($id);
        $data = $db->query("SELECT IFNULL(p.boardname, s.profile_number) AS player_name, s.score, maps.name, chapters.chapter_name, s.profile_number AS userid, maps.is_public,
								IFNULL(
									(SELECT mapz.steam_id FROM (SELECT steam_id, name, id FROM maps) AS mapz WHERE mapz.id < maps.id ORDER BY id DESC LIMIT 1),
									(SELECT steam_id FROM maps ORDER BY id DESC LIMIT 1)
									) AS previous_map,
								IFNULL(
									(SELECT mapz.steam_id FROM (SELECT steam_id, name, id FROM maps) AS mapz WHERE mapz.id > maps.id ORDER BY id ASC LIMIT 1),
									(SELECT steam_id FROM maps ORDER BY id ASC LIMIT 1)
									) AS next_map
								FROM scores AS s
								LEFT JOIN usersnew AS p ON s.profile_number = p.profile_number
								LEFT JOIN maps ON maps.steam_id = s.map_id 
								LEFT JOIN chapters ON maps.chapter_id = chapters.id
								LEFT JOIN changelog ON s.map_id = changelog.map_id AND s.score = changelog.score AND s.profile_number = changelog.profile_number
								WHERE s.map_id = '{$id}'
								AND legit = '1'
								AND p.banned = '0'
								GROUP BY s.id
								ORDER BY s.score ASC, changelog.time_gained ASC, s.profile_number ASC
								LIMIT ".$limit."
								");

        while ($row = $data->fetch_assoc()) {
            $chamber[0][] = array($row["player_name"], self::convert_valve_derp_time($row["score"]), $row["userid"]);
            $chamber[1] = array($row["chapter_name"], $row["name"]);
            $chamber[2] = $row["previous_map"];
            $chamber[3] = $row["next_map"];
            $chamber[4] = $row["is_public"];
        }
        return $chamber;
    }

    public static function get_latest_changes($parameters)
    {
        $db = new database;

        $param = array("bychamber_name" => "", "bychapter_name" => "", "byplayernickname" => "", "byplayer_steamid" => "", "bytype" => "", "amount" => "30", "wr" => "");

        foreach ($parameters as $key => $val) {
            if (array_key_exists($key, $param)) {
                $result = preg_replace("/[^a-zA-Z0-9]+\s/", "", $parameters[$key]);
                $param[$key] = $db->real_escape_string($result);
            }
        }
        $changelog_data = $db->query("SELECT IFNULL(usersnew.boardname, changelog.profile_number) AS player_name, changelog.score, changelog.map_id, changelog.wr_gain,
                                            maps.name, chapters.chapter_name, changelog.time_gained, changelog.previous_score, usersnew.banned AS banned, changelog.profile_number, maps.steam_id AS mapid
												FROM changelog 
												INNER JOIN usersnew ON changelog.profile_number = usersnew.profile_number
												INNER JOIN maps ON changelog.map_id = maps.steam_id
												INNER JOIN chapters ON maps.chapter_id = chapters.id 
												WHERE maps.name LIKE '%{$param['bychamber_name']}%'
												AND chapters.chapter_name LIKE '%{$param['bychapter_name']}%'
												AND IFNULL(usersnew.boardname, '') LIKE '%{$param['byplayernickname']}%'
												AND changelog.profile_number LIKE '%{$param['byplayer_steamid']}%'
												AND maps.is_coop LIKE '%{$param['bytype']}%'
												AND changelog.wr_gain LIKE '%{$param['wr']}%'
												AND banned = 0
												ORDER BY changelog.time_gained DESC
												LIMIT " . $param['amount'] . "
												");
        $changelog = array();
        while ($row = $changelog_data->fetch_assoc()) {
            $row["improvement"] = null;
            if ($row["previous_score"] > 0) {
                $scoreDifference = ($row["previous_score"] - $row["score"]);
                $row["improvement"] = ($scoreDifference < 0) ? "+" . self::convert_valve_derp_time($scoreDifference) : "-" . self::convert_valve_derp_time($scoreDifference);
                $row["previous_score"] = self::convert_valve_derp_time($row["previous_score"]);
            }
            $row["previous_score"] = ($row["previous_score"] == 0) ? NULL : $row["previous_score"];
            $row["score"] = self::convert_valve_derp_time($row["score"]);
            $changelog[] = $row;
        }
        return $changelog;
    }

    public static function getBannedScores()
    {
        $db = new database;
        $data = $db->query("SELECT IFNULL(usersnew.boardname, scores.profile_number) AS player_name, scores.profile_number, scores.score, maps.name, maps.steam_id
								FROM scores 
								INNER JOIN maps ON scores.map_id = maps.steam_id
								LEFT JOIN usersnew ON scores.profile_number = usersnew.profile_number
								WHERE legit = '0'
								");
        while ($row = $data->fetch_assoc()) {
            if ($row["profile_number"] != "76561198043770492") {
                $cheatedScores[] = array(self::convert_valve_derp_time($row["score"]), $row["name"], $row["player_name"], $row["steam_id"], $row["profile_number"]);
            }
        }
        return $cheatedScores;
    }

    public static function getBannedPlayers()
    {
        $db = new database;
        $data = $db->query("SELECT usersnew.profile_number, scores.score, maps.name, maps.steam_id
								FROM usersnew
								INNER JOIN scores ON scores.profile_number = usersnew.profile_number
								INNER JOIN maps ON scores.map_id = maps.steam_id
								WHERE banned = '1'
								");
        while ($row = $data->fetch_assoc()) {
            $cheaters[] = array(self::convert_valve_derp_time($row["score"]), $row["name"], $row["steam_id"], $row["profile_number"]);
        }
        return $cheaters;
    }

    /* Parsing the HTML/table takes 0.2s, might want to improve */
    public static function newSingleSegmentData()
    {
        $url = "http://cronikeys.com/portal/api.php?format=json&action=parse&page=Leaderboards";
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $leaderboardWikiData = curl_exec($ch);
        curl_close($ch);
        $htmlData = json_decode($leaderboardWikiData)->parse->text->{"*"};
        $html = str_get_html($htmlData);
        /* Remove paragraphs */
        foreach ($html->find('p') as $node) {
            $node->outertext = "";
        }
        /* Parsing the tables */
        $tables = array();
        foreach ($html->find('table') as $table) {
            if ($table->id != "toc") {

                $tableHeaders = NULL;
                foreach ($table->find('th') as $th) {
                    $tableHeaders[] = trim(preg_replace("/\r|\n/", "", $th->plaintext));
                }
                $entries = NULL;
                foreach ($table->find('tr') as $tr) {
                    if ($tr->find('th') == false) {
                        $entry = NULL;
                        foreach ($tr->find('td') as $key => $value) {
                            $entry[$tableHeaders[$key]] = trim(preg_replace("/\r|\n/", "", $value->plaintext));
                            //echo $th->plaintext."<br>";
                        }
                        $entries[] = $entry;
                    }
                }
                array_push($tables, $entries);
            }
        }
        /* Remove Course 6 COOP Table */
        unset($tables[6]);
        foreach ($tables as $table => $tableData) {
            foreach ($tableData as $entry => $entryData) {
                unset($tables[$table][$entry]["Comment"], $tables[$table][$entry]["Video"]);
                //unset($tables[$table][$entry]["Comment"]);
            }
        }
        /* Merge Atlas and P-Body as one player, remove team name */
        foreach ($tables[4] as $entry => $entryData) {
            $tables[4][$entry]["Player"] = $entryData["Atlas"] . " & " . $entryData["P-Body"];
            unset($tables[4][$entry]["Atlas"], $tables[4][$entry]["P-Body"], $tables[4][$entry]["Team name"]);
        }
        /* Remove team name, change Label for Atlas/P-Body to Player */
        foreach ($tables[5] as $entry => $entryData) {
            $tables[5][$entry]["Player"] = $entryData["Atlas/P-Body"];
            unset($tables[5][$entry]["Atlas/P-Body"], $tables[5][$entry]["Team name"]);
        }
        /* Categorize by game */
        $ladder = array("Portal 1" => array(
                "Beat the game" => $tables[1],
                "Beat the game, No OOB" => $tables[0],
                "Beat the game, Glitchless" => $tables[2]),
            "Portal 2" => array(
                "Beat the game" => $tables[3],
                "Beat COOP" => $tables[4],
                "Beat COOP Solo" => $tables[5]));

        $dtz = new DateTimeZone('Europe/London');
        $time = new DateTime('now', $dtz);
        $offset = $dtz->getOffset($time) / 3600;
        $timeUpdated = date('m/d/Y h:i:s a', time()) . " GMT" . ($offset < 0 ? $offset : "+" . $offset);
        $dataTable = serialize($ladder);
        $db = new Database;
        $db->query("REPLACE INTO singlesegment (id, updated, datatable) VALUES (1, '$timeUpdated', '$dataTable')");
    }

    public static function getSinglesegmentData()
    {
        $db = new Database;
        $data = $db->query("SELECT datatable, updated FROM singlesegment");
        while ($row = $data->fetch_assoc()) {
            $tables = $row;
        }
        return array(unserialize($tables["datatable"]), $tables["updated"]);
    }

    public static function makeScoreBoard($board)
    {
        foreach ($board as $chapter => $chapterData) {
            foreach ($chapterData as $map => $mapData) {
                $entriesByPoints = $scoresAsArrayKey = $entriesByScore = NULL;
                foreach ($mapData[1] as $entry => $entryData) {
                    $scoresAsArrayKey[$entryData[1]][] = array($entryData[2], $entryData[0]);
                }
                $points = 20;
                while ($points >= 1) {
                    $pointArray[] = $points;
                    $points--;
                }
                foreach ($scoresAsArrayKey as $scoresPlayerTime => $scoresPlayerData) {
                    $entriesByScore[$scoresPlayerTime] = $scoresPlayerData;
                }
                $place = 0;

                foreach ($entriesByScore as $scoreTime => $scoreTimePlayers) {
                    foreach ($scoreTimePlayers as $scoreTimePlayerProfileNumber) {
                        $entriesByPoints[$scoreTimePlayerProfileNumber[0]] = array($pointArray[$place], $scoreTimePlayerProfileNumber[1]);
                    }
                    $place = $place + count($scoreTimePlayers);
                }
                $board[$chapter][$map][1] = $entriesByPoints;
            }
        }
        return $board;
    }

    public static function makeTopPointBoard($swagBoard)
    {
        foreach ($swagBoard as $chapter => $chapterData) {
            foreach ($chapterData as $map => $mapData) {
                foreach ($mapData[1] as $player => $playerData) {
                    $fuckingpoints[$player] = (isset($fuckingpoints[$player])) ? ($fuckingpoints[$player] + $playerData[0]) : $playerData[0];
                }
            }
        }
        arsort($fuckingpoints, SORT_NUMERIC);
        return $fuckingpoints;
    }

    public static function makeGlobalPointBoard($SPTopPointBoard, $COOPTopPointBoard)
    {
        foreach ($COOPTopPointBoard as $player => $points) {
            if (isset($SPTopPointBoard[$player])) {
                $SPTopPointBoard[$player] = $SPTopPointBoard[$player] + $points;
            } else {
                $SPTopPointBoard[$player] = $points;
            }
        }
        arsort($SPTopPointBoard, SORT_NUMERIC);
        return $SPTopPointBoard;
    }

    public function getAllNicknames()
    {
        $data = $this->db->query("SELECT IFNULL(boardname, profile_number) AS nickname, profile_number FROM usersnew");
        while ($row = $data->fetch_assoc()) {
            $nicknames[$row["profile_number"]] = $row["nickname"];
        }
        return $nicknames;
    }
}

class LeastPortals extends Leaderboard
{
    protected $db;

    protected function get_map_ids()
    {
        $data = $this->db->query("SELECT lp_id FROM maps ORDER BY id");
        while ($fuckingretardedmysqlifunctionthatdoesntreturnfuckingarrayinstantly = $data->fetch_assoc()) {
            $steamids[$fuckingretardedmysqlifunctionthatdoesntreturnfuckingarrayinstantly["lp_id"]] = 20;
        }
        return $steamids;
    }

    protected function get_leastportal_exceptions()
    {
        $data = $this->db->query("SELECT map_id, profile_number FROM leastportals_exceptions");
        while ($row = $data->fetch_assoc()) {
            $exceptions[] = array($row["map_id"], $row["profile_number"]);
        }
        return $exceptions;
    }

    protected function return_leastportals_data()
    {
        $db = new database;
        $data = $db->query("SELECT steam_id, portals FROM leastportals");
        while ($row = $data->fetch_assoc()) {
            $board[$row["steam_id"]] = $row["portals"];
        }
        return $board;
    }

    public static function return_leastportals_board()
    {
        $db = new database;
        $data = $db->query("SELECT lp.steam_id, lp.portals, maps.name, chapters.chapter_name, maps.steam_id AS steam_id_image
								FROM leastportals AS lp
								INNER JOIN maps ON lp.steam_id = maps.lp_id
								INNER JOIN chapters ON maps.chapter_id = chapters.id
								ORDER BY chapters.is_multiplayer ASC, maps.id ASC
								");
        while ($row = $data->fetch_assoc()) {
            $board[$row["chapter_name"]][$row["name"]] = array($row["steam_id"], $row["steam_id_image"], $row["portals"]);
        }
        return $board;
    }
}

class NonCm extends Leaderboard
{
    public function __construct() {
        parent::__construct();
        echo "Non official CM Maps!\n";
    }
    /* Should refactor get maplist */
    public function getMaplist() {
        $data = $this->db->query("SELECT steam_id FROM maps WHERE is_public = '0'");
        while($row = $data->fetch_assoc()) {
            $mapList[$row["steam_id"]] = 10000;
        }
        return $mapList;
    }
    public function fetchNewData()
    {
        $newBoardData = $this->get_data($this->getMaplist());
        $this->save_data($newBoardData);
    }
    public function save_into_changelog() {
        /* Don't want to changelog huge pile of shit */
    }
}
