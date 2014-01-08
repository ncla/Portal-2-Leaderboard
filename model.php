<?php

// Improvements:
// Try calling less queries as possible. Save into changelog function could be rewritten so it processes data from array, instead of being called multiple times.
// Storing SQL connect somewhere off from /www directory. Also, establishing connection only once..
// http://net.tutsplus.com/tutorials/other/top-20-mysql-best-practices/
// Unbuffered queries?
// scores table remove last_changed?
	class database extends mysqli {
		public function __construct($host = 'localhost', $user = 'root', $pass = 'Tru!Ed2J', $db = 'leaderboard') {
        	parent::__construct($host, $user, $pass, $db);
        	if ($this->connect_errno) { // ummm, connect_errno vai mysql_errno?
				trigger_error($this->connect_error);
			}
			$this->set_charset('utf8'); 
		}
		public function query($query, $resultmode = MYSQLI_STORE_RESULT) {
			$bob = parent::query($query, $resultmode);
			if(!$bob) {
				trigger_error($this->error);
			}
			return $bob;
		}
	}
	class Leaderboard {
		
		protected $db, $leaderboard_ids;

		public function __construct() {
			$this->db = new database;
			$this->leaderboard_ids = $this->get_map_ids();
			try {
				$thisnotgood = $this->get_data($this->leaderboard_ids);
				$this->save_data($thisnotgood);	
			} catch (Exception $e) {
				echo $e->getMessage();
			}

		}

		protected function get_map_ids() {
			//$start = microtime(true);
			$data = $this->db->query("SELECT steam_id FROM maps ORDER BY id");
			while($fuckingretardedmysqlifunctionthatdoesntreturnfuckingarrayinstantly = $data->fetch_assoc()) {
				$steamids[] = $fuckingretardedmysqlifunctionthatdoesntreturnfuckingarrayinstantly["steam_id"];
			}
			//echo "<b>Get Map IDS: </b>".(microtime(true) - $start)."<br>";
			return $steamids;
		}
		public static function get_map_names($mode = 0) {
			$tt = microtime(true);
			$db = new database;
			$data = $db->query("SELECT steam_id, name, chapter_id FROM maps WHERE maps.is_coop = '{$mode}' ORDER BY maps.id");
			$maps = array();
			while($haha = $data->fetch_assoc()) {
				$maps[$haha["steam_id"]] = $haha["name"];
			}
			$hoh = microtime(true) - $tt;
			//echo "<b>Get map names query: </b>".$hoh;
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
				//array_push($shitlist, $obj[0]);
				$shitlist[] = $obj[0];
			}
			return $shitlist;
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
			echo "<b>Changelogging function:</b> ".$total_moo_time."s</br>";

		}
		protected function get_data($ids) {
			$moo_time = microtime(true);

			$data = $this->db->query("SELECT map_id, curl FROM exceptions");
			$exceptions = array();
			while($row = $data->fetch_assoc()) {
				$exceptions[$row['map_id']] = $row['curl'];
			}


			$curl_master = curl_multi_init();
			
			$curl_handles = array();
			
			foreach($ids as $key => $value) {
				$curl_handles[$key] = curl_init();
				$amount = 18;
				if(isset($exceptions[$value])) {
					$amount = $exceptions[$value];
				}
				curl_setopt($curl_handles[$key], CURLOPT_URL, "http://steamcommunity.com/stats/Portal2/leaderboards/".$value."?xml=1&start=1&end=".$amount);
				curl_setopt($curl_handles[$key], CURLOPT_HEADER, 0);
				curl_setopt($curl_handles[$key], CURLOPT_RETURNTRANSFER, true);
				curl_setopt($curl_handles[$key], CURLOPT_HTTPHEADER, array(
				    'Connection: Keep-Alive',
				    'Keep-Alive: 300'
				));
				curl_setopt($curl_handles[$key], CURLOPT_SSL_VERIFYPEER, FALSE);


				curl_multi_add_handle($curl_master, $curl_handles[$key]);
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

			foreach($ids as $key => $value) {
				curl_multi_remove_handle($curl_master, $curl_handles[$key]);
				$curlgetcontent = curl_multi_getcontent($curl_handles[$key]);
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
						$data[$ids[$key]][(string)$steamid] = (string)$score;
					}
				}
				$tt = microtime(true) - $xml;
				$xml_total = $xml_total + $tt;
			}
			// derp closing.
			curl_multi_close($curl_master);
			
			echo "<b>XML: </b>".$xml_total."<br>";

			$total_moo_time = microtime(true) - $moo_time;
			echo "<b>cURL requests:</b> ".$total_moo_time."s</br>";
			//var_dump($data);
			return $data;		
		}
		
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
			echo "<b>DB queries:</b> ".$total_moo_time."s</br>";
		}
		public static function return_leaderboards($mode = 0, $amount = 8) {
			$moo_time = microtime(true);
			$db = new database;
			$data = $db->query("SELECT IFNULL(p.nickname, s.profile_number) AS player_name, s.score, s.map_id, maps.chapter_id, chapters.chapter_name 
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
												ORDER BY map_id, score
										) AS tmp 
										WHERE tmp.rank <= '{$amount}' 
								) s
								JOIN players p
								ON s.profile_number = p.profile_number
								INNER JOIN maps ON maps.steam_id = s.map_id 
								INNER JOIN chapters ON maps.chapter_id = chapters.id
								WHERE maps.is_coop = '{$mode}'
								ORDER BY maps.id ASC, s.score ASC, s.profile_number ASC
						        ");

			$leaderboard = array();

			while ($row = $data->fetch_assoc()) {
				$leaderboard[$row["chapter_name"]][$row["map_id"]][] = array($row["player_name"], self::convert_valve_derp_time($row["score"]));
			}
			$total_moo_time = microtime(true) - $moo_time;
			//echo "<b>Return Leaderboard query:</b> ".$total_moo_time."s</br>";
			return $leaderboard;
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

			/* Prepared statement, stage 2: bind and execute */
			// $id = 1;
			// if (!$stmt->bind_param("i", $id)) {
			//     echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
			// }

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
								LIMIT 15
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
				$steamids[] = $fuckingretardedmysqlifunctionthatdoesntreturnfuckingarrayinstantly["lp_id"];
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
		protected function get_data($ids) {
			// parent::get_data($ids);
			// echo "is this the end?";
			// var_dump($data);
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
				//$board[$map_data[$key][0]][$map_data[$key][1]][1][] = array($profileID, self::convert_valve_derp_time($score));
				$board[$row["chapter_name"]][$row["name"]] = array($row["steam_id"], $row["steam_id_image"], $row["portals"]);
			}
			return $board;
		}
	}
?>
