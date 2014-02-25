<?php
include("simple_html_dom.php"); // Load Simpe HTML DOM parser
// Improvements:
// Try calling less queries as possible. Save into changelog function could be rewritten so it processes data from array, instead of being called multiple times.
// Storing SQL connect somewhere off from /www directory. Also, establishing connection only once..
// http://net.tutsplus.com/tutorials/other/top-20-mysql-best-practices/
// Unbuffered queries?
// scores table remove last_changed?
	class Leaderboard {
		
		protected $db, $leaderboard_ids;

        public $topEntryAmount = 20;

		public function __construct() {
			$this->db = new database;
		    $newBoardData = $this->get_data($this->returnCheatedBoardCount());

            $this->save_data($newBoardData);
		}

		protected function get_map_ids() {
			$data = $this->db->query("SELECT steam_id FROM maps ORDER BY id");
			while($fuckingretardedmysqlifunctionthatdoesntreturnfuckingarrayinstantly = $data->fetch_assoc()) {
				$steamids[] = $fuckingretardedmysqlifunctionthatdoesntreturnfuckingarrayinstantly["steam_id"];
			}
			return $steamids;
		}
		public static function get_map_names($mode = 0) {
			$db = new database;
			$data = $db->query("SELECT steam_id, name, chapter_id FROM maps ORDER BY maps.id");
			$maps = array();
			while($haha = $data->fetch_assoc()) {
				$maps[$haha["steam_id"]] = $haha["name"];
			}
			$hoh = microtime(true) - $tt;
			return $maps;
		}
		public static function get_chapter_names($mode = 0) {
			$db = new database;
			$data = $db->query("SELECT id, chapter_name FROM chapters WHERE is_multiplayer = '{$mode}' ORDER BY id");
			$chapters = array();
			while($haha = $data->fetch_assoc()) {
				$chapters[$haha["id"]] = $haha["chapter_name"];
			}
			return $chapters;
		}
		public function get_shitlist() {

			$data = $this->db->query("SELECT profile_number FROM players WHERE banned = 1");
			$shitlist = array();
			while($obj = $data->fetch_row()) {
				$shitlist[] = $obj[0];
			}
			return $shitlist;
		}
        public function getPlayerNicknames() {
            $data = $this->db->query("SELECT profile_number, nickname FROM players WHERE nickname IS NOT NULL");
            while($row = $data->fetch_assoc()) {
                $nicknames[$row["profile_number"]] = $row["nickname"];
            }
            return $nicknames;
        }
		public static function convert_valve_derp_time($time) {
			if(strlen($time) > 2) {
				$reversed = strrev($time);
				$miliseconds = strrev(substr($reversed, 0, 2));
				$rest_of_it = strrev(substr($reversed, 2, 6));
				$minutes = floor($rest_of_it / 60);
				if($minutes > 0) {
					$correct_seconds = $rest_of_it - (60 * $minutes);
					if($correct_seconds < 10) {
						$correct_seconds = "0".$correct_seconds;
					}
					$time = $minutes.":".$correct_seconds.".".$miliseconds;
				}
				else {
					$time = $rest_of_it.".".$miliseconds;
				}
			}
			else {
				if(strlen($time) == 1) {
					$time = "0.0".$time;
				}
				else {
					$time = "0.".$time;
				}
			}
			return $time;
		}

        /**
         * Writes changes into database table `changelog`
         *
         * @param $changes Changelog array
         */
        protected function save_into_changelog($changes) {
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
							        WHERE profile_number IN (SELECT profile_number FROM players WHERE banned = 0)
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
			foreach($changes as $key => $val) {
				$wr = 0;
				if($val[1] == $worldrecord_times[$val[2]]) {
					$wr = 1;
				}
				$query[] = "('".$val[0]."','".$val[1]."','".$val[2]."','".$wr."','".$val[3]."')";
			}
			$values = implode(",", $query);
			$actualquery = "INSERT INTO changelog(profile_number, score, map_id, wr_gain, previous_score) VALUES".$values;
			$this->db->query($actualquery);

			$total_moo_time = microtime(true) - $moo_time;
			echo "Changelogging function: ".$total_moo_time."s\n";
		}

        /**
         * Gets data for specified leaderboards
         *
         * @param $ids Array of Steam leaderboard ids and amount of entries needed to fetch
         * @return array Steam API returned data
         * @throws Exception cURL or SimpleXML errors
         */
        protected function get_data($ids = array()) {
			$moo_time = microtime(true);

			$curl_master = curl_multi_init();
			$curl_handles = array();
			
			foreach($ids as $mapID => $amount) {
				$curl_handles[$mapID] = curl_init();
				curl_setopt($curl_handles[$mapID], CURLOPT_URL, "http://steamcommunity.com/stats/Portal2/leaderboards/".$mapID."?xml=1&start=1&end=".$amount);
				curl_setopt($curl_handles[$mapID], CURLOPT_HEADER, 0);
				curl_setopt($curl_handles[$mapID], CURLOPT_RETURNTRANSFER, true);
				curl_setopt($curl_handles[$mapID], CURLOPT_HTTPHEADER, array(
				    'Connection: Keep-Alive',
				    'Keep-Alive: 300'
				));
				curl_setopt($curl_handles[$mapID], CURLOPT_SSL_VERIFYPEER, FALSE);


				curl_multi_add_handle($curl_master, $curl_handles[$mapID]);
			}
			
			$active = null;
			do {
			    $status = curl_multi_exec($curl_master, $active);
			    $info = curl_multi_info_read($curl_master);
			    if($info["result"] != 0) {
			    	throw new Exception ("<b>cURL request failed to this URL: </b>". curl_getinfo($info['handle'], CURLINFO_EFFECTIVE_URL));
			    }
			} 
			while ($status == CURLM_CALL_MULTI_PERFORM);

			while ($active && $status == CURLM_OK) {
			    if (curl_multi_select($curl_master) == -1) usleep(100); // u w0t?
			    do { $status = curl_multi_exec($curl_master, $active); }
			    while ($status == CURLM_CALL_MULTI_PERFORM);
			}

			$data = array();

			$xml_total = 0;

			foreach($ids as $mapID => $amount) {
				curl_multi_remove_handle($curl_master, $curl_handles[$mapID]);
				$curlgetcontent = curl_multi_getcontent($curl_handles[$mapID]);
				//var_dump($curlgetcontent);
				$xml = microtime(true);
				try { 
					//$leaderboard = new SimpleXMLElement($curlgetcontent); 
					$leaderboard = simplexml_load_string(utf8_encode($curlgetcontent)); 
				}
				catch (Exception $e) {
					throw new Exception("SimpleXML error: ". $e);
				}

				libxml_use_internal_errors(true);
				$sxe = simplexml_load_string($leaderboard);
				if ($sxe === false) {
				    foreach(libxml_get_errors() as $error) {
				    	throw new Exception ("<b>SimpleXML error: </b>". $error->message.'\n');
				    }
				}

				foreach($leaderboard->entries as $key2 => $val2) {
					//echo $val->asXML();
					foreach($val2 as $d => $b) {
						$steamid = $b->steamid;
						$score = $b->score;
						$data[$mapID][(string)$steamid] = (string)$score;
					}
				}
				$tt = microtime(true) - $xml;
				$xml_total = $xml_total + $tt;
			}
			// derp closing.
			curl_multi_close($curl_master);
			
			echo "Leaderboard Fetchnew XML: ".$xml_total."\n";

			$total_moo_time = microtime(true) - $moo_time;
			echo "Leaderboard Fetchnew cURL: ".$total_moo_time."\n";
			//var_dump($data);
			return $data;		
		}

        /**
         * Updates database and prepares changelog array for changelogging
         *
         * @param $data_to_load Data passed from Steam API, not filtered
         */
        protected function save_data($data_to_load) {
			$moo_time = microtime(true);
			
			$db_data = $this->db->query("SELECT profile_number, score, map_id FROM scores");
			$db_data_arr = array();
			while($row = $db_data->fetch_assoc()) {
				$db_data_arr[$row["map_id"]][$row["profile_number"]] = $row["score"];
			}
			$changelog = array();
			foreach($data_to_load as $chamber => $chamber_val) {
				foreach($chamber_val as $player => $score) {
					if(!isset($db_data_arr[$chamber][$player])) {
						$this->db->query("INSERT IGNORE INTO players SET profile_number = '{$player}'");
						$this->db->query("INSERT INTO scores (profile_number, score, map_id) 
									VALUES (
										'{$player}',
										'{$score}',
										'{$chamber}'
									)
						");
						$changelog[] = array($player, $score, $chamber, 0);
					}
					elseif($score != $db_data_arr[$chamber][$player]) {
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
			if(count($changelog) > 0) {
				$this->save_into_changelog($changelog);
			}
			echo "Leaderboard Fetchnew DB: ".$total_moo_time."s\n";
		}

		public function returnCheatedBoardCount() {
			$db = new database;
			$data = $db->query("SELECT score, scores.profile_number, map_id
                                FROM scores
                                INNER JOIN maps ON scores.map_id = maps.steam_id
                                LEFT JOIN players ON scores.profile_number = players.profile_number
                                WHERE legit = '0' OR players.banned = '1'
                                ORDER BY maps.id
						        ");

			$leaderboard = array();
			while ($row = $data->fetch_assoc()) {
				$leaderboard[$row["map_id"]][] = array($row["profile_number"], $row["score"]);
			}
            foreach($leaderboard as $mapID => $scores) {
                $cheatedAmount[$mapID] = count($scores) + $this->topEntryAmount + 2;
            }
            return $cheatedAmount;
		}

		public static function return_leaderboards_new($mode = "0", $amount = "8") {
			$db = new database;
			/* Prepared statement, stage 1: prepare */
			if (!($stmt = $db->prepare("SELECT chap.chapter_name, maps.name, maps.steam_id
											FROM maps 
											INNER JOIN chapters AS chap ON maps.chapter_id = chap.id
											WHERE is_coop = '".$mode."'
											ORDER BY maps.id"))) {
			     echo "Prepare failed: (" . $db->errno . ") " . $db->error;
			}

			if (!$stmt->execute()) {
			    echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
			}
			$stmt->bind_result($chaptername, $mapname, $mapID);

		    /* fetch values */
		    while ($stmt->fetch()) {
		        //printf ("%s - %s - %s\n<br>", $chaptername, $mapname, $mapID);
		        $map_data[$mapID] = array($chaptername, $mapname);
		    }

		    if (!($stmt_scores = $db->prepare("SELECT IFNULL(p.nickname, s.profile_number), s.score 
		    								   FROM scores AS s
		    								   INNER JOIN players AS p on p.profile_number = s.profile_number
		    								   WHERE s.map_id = ? 
		    								   AND s.legit = '1'
		    								   AND p.banned = '0'
		    								   ORDER BY s.score ASC
		    								   LIMIT ".$amount))) {
			     echo "Prepare failed: (" . $db->errno . ") " . $db->error;
			}
			foreach($map_data as $key => $val) {
				if (!$stmt_scores->bind_param("i", $key)) {
				    echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
				}
				if (!$stmt_scores->execute()) {
			        echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
			    }
			    $stmt_scores->bind_result($profileID, $score);

			    $board[$map_data[$key][0]][$map_data[$key][1]][0] = $key;

			    while ($stmt_scores->fetch()) {
		        	//printf ("%s - %s\n<br>", $profileID, self::convert_valve_derp_time($score));
		        	$board[$map_data[$key][0]][$map_data[$key][1]][1][] = array($profileID, self::convert_valve_derp_time($score));
		    	}
			}
			//var_dump($board);
			

		    /* fetch values */
		    while ($stmt_scores->fetch()) {
		        printf ("%s - %s\n<br>", $profileID, $score);
		    }

			/* Prepared statement: repeated execution, only data transferred from client to server */
			// for ($id = 2; $id < 5; $id++) {
			//     if (!$stmt->execute()) {
			//         echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
			//     }
			// }
			return $board;
		}
		public static function return_chamber($id = 45467) {
			$db = new database;
			$id = $db->real_escape_string($id);
			$data = $db->query("SELECT IFNULL(p.nickname, s.profile_number) AS player_name, s.score, maps.name, chapters.chapter_name, s.profile_number AS userid,
								IFNULL(
									(SELECT mapz.steam_id FROM (SELECT steam_id, name, id FROM maps) AS mapz WHERE mapz.id < maps.id ORDER BY id DESC LIMIT 1),
									(SELECT steam_id FROM maps ORDER BY id DESC LIMIT 1)
									) AS previous_map,
								IFNULL(
									(SELECT mapz.steam_id FROM (SELECT steam_id, name, id FROM maps) AS mapz WHERE mapz.id > maps.id ORDER BY id ASC LIMIT 1),
									(SELECT steam_id FROM maps ORDER BY id ASC LIMIT 1)
									) AS next_map
								FROM scores AS s
								LEFT JOIN players AS p ON s.profile_number = p.profile_number
								LEFT JOIN maps ON maps.steam_id = s.map_id 
								LEFT JOIN chapters ON maps.chapter_id = chapters.id
								WHERE s.map_id = '{$id}'
								AND legit = '1'
								AND p.banned = '0'
								ORDER BY s.score ASC, s.profile_number ASC
								LIMIT 20
						        ");

			while ($row = $data->fetch_assoc()) {
				$chamber[0][] = array($row["player_name"], self::convert_valve_derp_time($row["score"]), $row["userid"]);
				$chamber[1] = array($row["chapter_name"], $row["name"]);
				$chamber[2] = $row["previous_map"];
				$chamber[3] = $row["next_map"];
			}
			return $chamber;
		}
		public static function get_latest_changes($parameters) {
			//$moo_time = microtime(true);
			$db = new database;

			$param = array("bychamber_name" => "", "bychapter_name" => "", "byplayernickname" => "", "byplayer_steamid" => "", "bytype" => "", "amount" => "30", "wr" => "");

			foreach($parameters as $key => $val) {
				if(array_key_exists($key, $param)) {
					$result = preg_replace("/[^a-zA-Z0-9]+\s/", "", $parameters[$key]);
					$param[$key] = $db->real_escape_string($result);
				}
			}
			$changelog_data = $db->query("SELECT IFNULL(players.nickname, changelog.profile_number) AS player_name, changelog.score, changelog.map_id, changelog.wr_gain, maps.name, chapters.chapter_name, changelog.time_gained, changelog.previous_score 
												FROM changelog 
												INNER JOIN players ON changelog.profile_number = players.profile_number 
												INNER JOIN maps ON changelog.map_id = maps.steam_id
												INNER JOIN chapters ON maps.chapter_id = chapters.id 
												WHERE maps.name LIKE '%{$param['bychamber_name']}%'
												AND chapters.chapter_name LIKE '%{$param['bychapter_name']}%'
												AND IFNULL(players.nickname, '') LIKE '%{$param['byplayernickname']}%'
												AND changelog.profile_number LIKE '%{$param['byplayer_steamid']}%'
												AND maps.is_coop LIKE '%{$param['bytype']}%'
												AND changelog.wr_gain LIKE '%{$param['wr']}%'
												ORDER BY changelog.time_gained DESC
												LIMIT ".$param['amount']."
												");
			$changelog = array();
			while ($row = $changelog_data->fetch_assoc()) {
				$improvement = null;
				$previous_score = null;
				if($row["previous_score"] > 0) {
					$improvement = self::convert_valve_derp_time($row["previous_score"] - $row["score"]);
					$previous_score = self::convert_valve_derp_time($row["previous_score"]);
				}
				$changelog[] = array($row["player_name"], 
									self::convert_valve_derp_time($row["score"]),
									$row["map_id"],
									$row["wr_gain"],
									$row["name"],
									$row["chapter_name"],
									$row["time_gained"],
									$previous_score,
									$improvement
									);
			}
			//$total_moo_time = microtime(true) - $moo_time;
			//echo "<b>Changelog query:</b> ".$total_moo_time."s</br>";
			return $changelog;
		}
		public static function getBannedScores() {
			$db = new database;
			$data = $db->query("SELECT IFNULL(players.nickname, scores.profile_number) AS player_name, scores.profile_number, scores.score, maps.name, maps.steam_id
								FROM scores 
								INNER JOIN maps ON scores.map_id = maps.steam_id
								LEFT JOIN players ON scores.profile_number = players.profile_number
								WHERE legit = '0'
								");
			while($row = $data->fetch_assoc()) {
				if($row["profile_number"] != "76561198043770492") {
					$cheatedScores[] = array(self::convert_valve_derp_time($row["score"]), $row["name"], $row["player_name"], $row["steam_id"], $row["profile_number"]);
				}
			}
			return $cheatedScores;
		}
		public static function getBannedPlayers() {
			$db = new database;
			$data = $db->query("SELECT players.profile_number, scores.score, maps.name, maps.steam_id
								FROM players 
								INNER JOIN scores ON scores.profile_number = players.profile_number
								INNER JOIN maps ON scores.map_id = maps.steam_id
								WHERE banned = '1'
								");
			while($row = $data->fetch_assoc()) {
				$cheaters[] = array(self::convert_valve_derp_time($row["score"]), $row["name"], $row["steam_id"], $row["profile_number"]);
			}
			return $cheaters;
		}
		/* Parsing the HTML/table takes 0.2s, might want to improve */
		public static function newSingleSegmentData() {
			ini_set('xdebug.var_display_max_depth', -1);
			ini_set('xdebug.var_display_max_children', -1);
			ini_set('xdebug.var_display_max_data', -1);

			$url = "http://cronikeys.com/portal/api.php?format=json&action=parse&page=Leaderboards";
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$leaderboardWikiData = curl_exec($ch);
			curl_close($ch);
			$htmlData = json_decode($leaderboardWikiData)->parse->text->{"*"};
			$html = str_get_html($htmlData);
			/* Remove paragraphs */
			foreach($html->find('p') as $node) {
				$node->outertext = "";
			}
			/* Parsing the tables */
			$tables = array();
			foreach($html->find('table') as $table) {
				if($table->id != "toc") {

					$tableHeaders = NULL;
					foreach($table->find('th') as $th) {
						$tableHeaders[] = trim(preg_replace("/\r|\n/", "", $th->plaintext));
					}
					$entries = NULL;
					foreach($table->find('tr') as $tr) {
						if($tr->find('th') == false) {
							$entry = NULL;
							foreach($tr->find('td') as $key => $value) {
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
			foreach($tables as $table => $tableData) {
				foreach($tableData as $entry => $entryData) {
					unset($tables[$table][$entry]["Comment"], $tables[$table][$entry]["Video"]);
					//unset($tables[$table][$entry]["Comment"]);
				}
			}
			/* Merge Atlas and P-Body as one player, remove team name */
			foreach($tables[4] as $entry => $entryData) {
				$tables[4][$entry]["Player"] = $entryData["Atlas"]. " & " . $entryData["P-Body"];
				unset($tables[4][$entry]["Atlas"], $tables[4][$entry]["P-Body"], $tables[4][$entry]["Team name"]);
			}
			/* Remove team name, change Label for Atlas/P-Body to Player */
			foreach($tables[5] as $entry => $entryData) {
				$tables[5][$entry]["Player"] = $entryData["Atlas/P-Body"];
				unset($tables[5][$entry]["Atlas/P-Body"], $tables[5][$entry]["Team name"]);
			}
			/* Slice tables to TOP15 */
			// foreach($tables as $key => $value) {
			// 	$sliced = array_slice($value, 0, 10);
			// 	$tables[$key] = $sliced;
			// }
			/* Categorize by game */
			$ladder = array("Portal 1" => array(
								"Beat the game, No OOB" => $tables[0], 
								"Beat the game" => $tables[1], 
								"Beat the game, Glitchless" => $tables[2]),
							"Portal 2" => array(
								"Beat the game" => $tables[3], 
								"Beat COOP" => $tables[4], 
								"Beat COOP Solo" => $tables[5]));

			$dtz = new DateTimeZone('Europe/London');
			$time = new DateTime('now', $dtz);
			$offset = $dtz->getOffset($time) / 3600;
			$timeUpdated = date('m/d/Y h:i:s a', time()) . " GMT" . ($offset < 0 ? $offset : "+".$offset);
			$dataTable = serialize($ladder);
			$db = new Database;
			$db->query("REPLACE INTO singlesegment (id, updated, datatable) VALUES (1, '$timeUpdated', '$dataTable')");
		}
		public static function getSinglesegmentData() {
			$db = new Database;
			$data = $db->query("SELECT datatable, updated FROM singlesegment");
			while($row = $data->fetch_assoc()) {
				$tables = $row;
			}
			return array(unserialize($tables["datatable"]), $tables["updated"]);
		}
	}

	class LeastPortals extends Leaderboard {
		protected $db;
		public function __construct() {
			$this->db = new database;
			$this->get_data($this->get_map_ids());
		} 
		protected function get_map_ids() {
			//$start = microtime(true);
			$data = $this->db->query("SELECT lp_id FROM maps ORDER BY id");
			while($fuckingretardedmysqlifunctionthatdoesntreturnfuckingarrayinstantly = $data->fetch_assoc()) {
				$steamids[$fuckingretardedmysqlifunctionthatdoesntreturnfuckingarrayinstantly["lp_id"]] = 20;
			}
			//echo "<b>Get Map IDS: </b>".(microtime(true) - $start)."<br>";
			return $steamids;
		}
		protected function get_leastportal_exceptions() {
			$data = $this->db->query("SELECT map_id, profile_number FROM leastportals_exceptions");
			while($row = $data->fetch_assoc()) {
				$exceptions[] = array($row["map_id"], $row["profile_number"]);
			}
			//echo "<b>Get Map IDS: </b>".(microtime(true) - $start)."<br>";
			return $exceptions;
		}
		protected function return_leastportals_data() {
			$db = new database;
			$data = $db->query("SELECT steam_id, portals FROM leastportals");
			while($row = $data->fetch_assoc()) {
				$board[$row["steam_id"]] = $row["portals"];
			}
			//echo "<b>Get Map IDS: </b>".(microtime(true) - $start)."<br>";
			return $board;
		}
		// remember to change Class permission stuff
		protected function get_data($ids = array()) {
			$parent = parent::get_data($ids);
			//var_dump($parent);
			$cheaters = Leaderboard::get_shitlist();
			$exceptions = self::get_leastportal_exceptions();
			//var_dump($cheaters);
			$start = microtime(true);

			foreach($exceptions as $key => $val) {
				unset($parent[$val[0]][$val[1]]);
			}

			foreach($parent as $key => $chamber) {
				for($i=0;$i<count($cheaters);$i++) {
					unset($parent[$key][$cheaters[$i]]); // no need to check if the values exist in array, unset is safe to use, doesnt throw error
				}
				$parent[$key] = array_slice($parent[$key], 0, 1);
				$parent[$key] = array_values($parent[$key]); // cleanup from steamid => portal amount array
			}

			echo "<b>Filter Array: </b>".(microtime(true) - $start)."<br>";
			$board = $this->return_leastportals_data();
			foreach($board as $board_key => $board_val) {
				if($board_val != $parent[$board_key][0]) {
					// to do: use mysqli prepare statements!
					$this->db->query("UPDATE leastportals SET portals = '{$parent[$board_key][0]}' WHERE steam_id = '{$board_key}'");
				}
			}
		}
		public static function return_leastportals_board() {
			$db = new database;
			$data = $db->query("SELECT lp.steam_id, lp.portals, maps.name, chapters.chapter_name, maps.steam_id AS steam_id_image
								FROM leastportals AS lp
								INNER JOIN maps ON lp.steam_id = maps.lp_id
								INNER JOIN chapters ON maps.chapter_id = chapters.id
								ORDER BY chapters.is_multiplayer ASC, maps.id ASC
								");
			while($row = $data->fetch_assoc()) {
				$board[$row["chapter_name"]][$row["name"]] = array($row["steam_id"], $row["steam_id_image"], $row["portals"]);
			}
			return $board;
		}
	}
?>
