<?php
class Users {

    public function __construct($profileNumber) {
        $this->profileNumber = $profileNumber;
    }
    public function getProfileData() {
        $this->hasRecords = $this->hasRecords();
        $this->isRegistered = $this->isRegistered();

        if($this->hasRecords() || $this->isRegistered) {
            $this->profileExists = true;
            $this->userData = $this->getUserData();
            $this->profileDisplayName = $this->getProfileDisplayName();
        }

        if($this->hasRecords) {
            $this->cheatedScores = $this->getPlayerCheatedScores();
            $this->getActivity(30);
            $this->calculateAllPoints();
            $this->getRanks();
            $this->getWorldrecordsData();
            $this->getAveragePlace();
            $this->getAllRecords();
        }
    }
    public static function isLoggedIn() {
        return isset($_SESSION["user"]);
    }
    public static function getLoggedInUser() {
        return $_SESSION["user"];
    }
    public function getLoggedInUserData() {
        $db = new database();
        $user_ident = $this->profileNumber;
        $data = $db->query("SELECT profile_number, avatar, steamname as nickname, boardname AS board_nickname
									  FROM usersnew
									  WHERE profile_number = '{$user_ident}' LIMIT 1");
        while ($row = $data->fetch_object()) {
            $this->loggedInUser = $row;
        }
        return $this;
    }
    public static function saveProfile($user, $twitch = "", $youtube = "") {
        $db = new database();
        $db->query("UPDATE usersnew SET twitch = '$twitch', youtube = '$youtube' WHERE profile_number = '$user'");
    }
    public static function getEditProfileData($user) {
        $db = new database();
        return $db->query("SELECT twitch, youtube FROM usersnew WHERE profile_number = '$user'")->fetch_object();
    }
    /*
     * Old code, revise pls.
     */
    public static function processProfile($user) {
        $db = new database;
        $ch = curl_init("http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key={API KEY HERE}&steamids=" . $user);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $content = curl_exec($ch);
        curl_close($ch);

        $userinfo = json_decode($content, true);
        $nickname = htmlspecialchars($db->real_escape_string($userinfo["response"]["players"][0]["personaname"]));
        $avatar_url = $userinfo["response"]["players"][0]["avatarfull"];

        $data = $db->query("SELECT profile_number, boardname FROM usersnew WHERE profile_number = '{$user}' LIMIT 1")->fetch_assoc();

        $ip = $_SERVER['REMOTE_ADDR'];

        // ja lietotaja IP adrese nav musu IP tabula.
        $d = $db->query("SELECT ip_address FROM users_ip WHERE ip_address = '{$ip}' AND profile_number = '{$user}'")->fetch_assoc();
        if (!$d) {
            $db->query("INSERT INTO users_ip(profile_number, ip_address) VALUES ('{$user}', '{$ip}')");
        }
        $_SESSION["user"] = $user;

        if ($data) {
            $db->query("UPDATE usersnew SET avatar = '{$avatar_url}', steamname = '{$nickname}' WHERE profile_number = '{$user}'");
        } // ja lietotajs nav ieprieksh ielogojies.
        elseif (!$data) {
            $db->query("INSERT INTO usersnew(profile_number, avatar, steamname) VALUES ('{$user}', '{$avatar_url}', '{$nickname}')");
        }
        // update boardname if its null
        if ($data["boardname"] == NULL) {
            $db->query("UPDATE usersnew SET boardname = '{$nickname}' WHERE profile_number = '{$user}' AND boardname IS NULL");
        }
    }
    public function getPlayerCheatedScores() {
        foreach(Leaderboard::getBannedScores() as $entry => $entryData) {
            $cheatedScores = false;
            if($entryData[4] == $this->profileNumber) {
                $cheatedScores[] = $entryData;
            }
            return $cheatedScores;
        }
    }
    public function getUserData() {
        $db = new database;
        $data = $db->query("SELECT avatar, boardname, steamname, banned, twitch, youtube, title FROM usersnew WHERE profile_number = '$this->profileNumber'");
        while($row = $data->fetch_object()) {
            return $row;
        }
    }
    public function isRegistered() {
        $db = new database;
        if($data = $db->query("SELECT profile_number FROM usersnew WHERE profile_number = '$this->profileNumber'")) {
            if($data->num_rows > 0) {
                return true;
            }
        }
        return false;
    }
    public function hasRecords() {
        $boardPoints = BoardCache::getBoard("GlobalPointTopBoard");
        return (isset($boardPoints[$this->profileNumber])) ? true : false;
    }

    public function getChangelog($dayAmount) {
        $db = new database;
        $activity = NULL;
        $data = $db->query("SELECT time_gained, score, maps.name FROM changelog
                            LEFT JOIN maps ON changelog.map_id = maps.steam_id
                            WHERE time_gained > DATE_SUB(NOW(), INTERVAL '$dayAmount' DAY)
                            AND profile_number = '$this->profileNumber'
                            ORDER BY time_gained DESC");
        while($row = $data->fetch_object()) {
            $row->score = Leaderboard::convert_valve_derp_time($row->score);
            $activity[] = $row;
        }
        return $activity;
    }
    public function getActivity($dayAmount) {
        date_default_timezone_set('Europe/London');

        for ($i = 0; $i <= $dayAmount; $i++) {
            $timestamp = time();
            $tm = 86400 * $i; // 60 * 60 * 24 = 86400 = 1 day in seconds
            $tm = $timestamp - $tm;
            $activityAmount[date("m/d/Y", $tm)] = 0;
        }

        $changelog = $this->getChangelog($dayAmount);
        $this->{'changelogPast' . $dayAmount . 'days'} = $changelog;
        if($changelog != NULL) {
            foreach($changelog as $key => $data) {
                $changelogEntryDate = date("m/d/Y", strtotime($data->time_gained));;
                $activityAmount[$changelogEntryDate]++;
            }
        }
        $this->{'activityPast' . $dayAmount . 'days'} = $activityAmount;
    }
    public function getWorldrecordsData() {
        $Worldrecords = new stdClass();
        $Worldrecords->SP = $this->getWorldrecordList(BoardCache::getBoard("SPBoard"));
        $Worldrecords->COOP = $this->getWorldrecordListCOOP(BoardCache::getBoard("COOPBoard"));

        $Worldrecords->SPAmount = $this->countWorldrecords($Worldrecords->SP);
        $Worldrecords->COOPAmount = $this->countWorldrecords($Worldrecords->COOP);
        $Worldrecords->GlobalAmount = $Worldrecords->SPAmount + $Worldrecords->COOPAmount;
        $this->Worldrecords = $Worldrecords;
    }
    public function getWorldrecordList($board) {
        foreach($board as $chapter => $chapterData) {
            $worldrecordList[$chapter] = array();
            foreach($chapterData as $map => $mapData) {
                /* First place profile number */
                if($mapData[1][0][2] == $this->profileNumber) {
                    $worldrecordList[$chapter][$map] = $mapData[1][0][1];
                }
            }
        }
        return $worldrecordList;
    }
    public function getWorldrecordListCOOP($board) {
        foreach($board as $chapter => $chapterData) {
            $worldrecordList[$chapter] = array();
            foreach($chapterData as $map => $mapData) {
                /* First place profile number */
                //var_dump($mapData); die;
                if($mapData[1][0][2] == $this->profileNumber || $mapData[1][1][2] == $this->profileNumber) {
                    if($mapData[1][0][1] == $mapData[1][1][1]) {
                        $worldrecordList[$chapter][$map] = $mapData[1][0][1];
                    }
                    else {
                        /* COOP fix where first place has only one player */
                        if($mapData[1][0][2] == $this->profileNumber) {
                            $worldrecordList[$chapter][$map] = $mapData[1][0][1];
                        }
                    }
                }

            }
        }
        return $worldrecordList;
    }
    public function countWorldrecords($worldrecordList) {
        $amount = 0;
        foreach($worldrecordList as $chapter => $chapterData) {
            $amount = $amount + count($chapterData);
        }
        return $amount;
    }
    public function calculatePointsForChapters($board) {
        foreach($board as $chapter => $chapterData) {
            $points[$chapter] = 0;
            foreach($chapterData as $map => $mapData) {
                if(isset($mapData[1][$this->profileNumber])) {
                    $points[$chapter] = $points[$chapter] + $mapData[1][$this->profileNumber][0];
                }
            }
        }
        return $points;
    }

    /**
     * What the fuck is point of this if we have a globally cached Top boards of points?
     */
    public function calculateAllPoints() {
        $points = new stdClass();
        $points->SPChapters = $this->calculatePointsForChapters(BoardCache::getBoard("SPBoardPoints"));
        $points->COOPChapters = $this->calculatePointsForChapters(BoardCache::getBoard("COOPBoardPoints"));
        $points->SPPointsAll = 0;
        $points->COOPPointsAll = 0;
        foreach($points->SPChapters as $chapter => $chapterPoints) {
            $points->SPPointsAll = $points->SPPointsAll + $chapterPoints;
        }
        foreach($points->COOPChapters as $chapter => $chapterPoints) {
            $points->COOPPointsAll = $points->COOPPointsAll + $chapterPoints;
        }
        $points->pointSummary = $points->COOPPointsAll + $points->SPPointsAll;
        $this->Points = $points;
    }

    /**
     * 
     */
    public function getRanks() {
        $SPTop = BoardCache::getBoard("SPPointTopBoard");
        $COOPTop = BoardCache::getBoard("COOPPointTopBoard");
        $GlobalTop = BoardCache::getBoard("GlobalPointTopBoard");

        $ranks = new stdClass();
        $ranks->SP = (isset($SPTop[$this->profileNumber])) ? (array_search($this->profileNumber, array_keys($SPTop)) + 1) : NULL;
        $ranks->COOP = (isset($COOPTop[$this->profileNumber])) ? (array_search($this->profileNumber, array_keys($COOPTop)) + 1) : NULL;
        $ranks->Global = (isset($GlobalTop[$this->profileNumber])) ? (array_search($this->profileNumber, array_keys($GlobalTop)) + 1) : NULL;
        $this->ranks = $ranks;

        $friendstobeat = new stdClass();
        $friendstobeat->SP = $this->friendsToBeat($SPTop);
        $friendstobeat->COOP = $this->friendsToBeat($COOPTop);
        $friendstobeat->Global = $this->friendsToBeat($GlobalTop);
        $this->friendstobeat = $friendstobeat;
    }
    public function friendsToBeat($board) {
        if(!isset($board[$this->profileNumber])) {
            return NULL;
        }
        $nicknames = BoardCache::getBoard("Nicknames");
        $boardIndexes = array_keys($board);
        $playerIndex = array_search($this->profileNumber, $boardIndexes);

        $friendstobeat = array();

        $i = 2;
        $nextCountFails = 0;
        /* Next ones */
        while($i > 0) {
            if(($playerIndex - $i) >= 0) {
                if(isset($boardIndexes[($playerIndex - $i)])) {
                    $place = ($playerIndex - $i);
                    $ftbProfileNumber = $boardIndexes[$place];
                    $friendstobeat[$ftbProfileNumber] = array($board[$ftbProfileNumber], $nicknames[$ftbProfileNumber], ($place + 1), $ftbProfileNumber);
                }
                else {
                    $nextCountFails++;
                }
            }
            else {
                $nextCountFails++;
            }
            $i--;
        }

        /* The current player itself */
        $friendstobeat[$this->profileNumber] = array($board[$this->profileNumber], $nicknames[$this->profileNumber], ($playerIndex + 1), $this->profileNumber);

        /* Previous ones (compensating failed next ones) */
        $i = 1;
        $max = 2 + $nextCountFails;
        while($i <= $max) {
            if(isset($boardIndexes[($playerIndex + $i)])) {
                $place = ($playerIndex + $i);
                $ftbProfileNumber = $boardIndexes[$place];
                $friendstobeat[$ftbProfileNumber] = array($board[$ftbProfileNumber], $nicknames[$ftbProfileNumber], ($place + 1), $ftbProfileNumber);
            }
            $i++;
        }
        return $friendstobeat;
    }
    /**
     * This is too DRY.
     */
    public function getAveragePlace() {
        $SPLeaderboard = BoardCache::getBoard("SPBoardPoints");
        $SPPlaces = 0;
        $SPMaps = 0;
        foreach($SPLeaderboard as $chapter => $chapterData) {
            foreach($chapterData as $map => $mapData) {
                if(isset($mapData[1][$this->profileNumber])) {
                    $SPPlaces = $SPPlaces + (array_search($this->profileNumber, array_keys($mapData[1])) + 1);
                    $SPMaps++;
                }
            }
        }

        $this->SPAveragePlace = ($SPMaps >= 10) ? (round(($SPPlaces / $SPMaps), 1, PHP_ROUND_HALF_UP)) : NULL;

        $COOPLeaderboard = BoardCache::getBoard("COOPBoardPoints");
        $COOPPlaces = 0;
        $COOPMaps = 0;
        foreach($COOPLeaderboard as $chapter => $chapterData) {
            foreach($chapterData as $map => $mapData) {
                if(isset($mapData[1][$this->profileNumber])) {
                    $COOPPlaces = $COOPPlaces + (array_search($this->profileNumber, array_keys($mapData[1])) + 1);
                    $COOPMaps++;
                }
            }
        }
        $this->COOPAveragePlace = ($COOPMaps >= 10) ? (round(($COOPPlaces / $COOPMaps), 1, PHP_ROUND_HALF_UP)) : NULL;

        $this->GlobalAveragePlace = (($SPMaps + $COOPMaps) >= 10) ? (round(($SPPlaces + $COOPPlaces) / ($SPMaps + $COOPMaps), 1, PHP_ROUND_HALF_UP)) : NULL;
    }
    public function getAllRecords() {
        $records = new stdClass();
        $records->SP = $this->getRecordsFromBoard(BoardCache::getBoard("SPBoard"));
        $records->COOP = $this->getRecordsFromBoard(BoardCache::getBoard("COOPBoard"));
        $this->Records = $records;
    }
    public function getRecordsFromBoard($board) {
        $records = NULL;
        foreach($board as $chapter => $chapterData) {
            $worldrecordList[$chapter] = array();
            foreach($chapterData as $map => $mapData) {
                foreach($mapData[1] as $entry => $entryData) {
                    if($entryData[2] == $this->profileNumber) {
                        $records[$chapter][$map] = array($entryData[1], $mapData[0][0]);
                    }
                }
            }
        }
        return $records;
    }
    public function getProfileDisplayName() {
        if($this->userData->boardname != NULL) {
            return $this->userData->boardname;
        }
        if($this->userData->steamname != NULL) {
            return $this->userData->steamname;
        }
        return $this->profileNumber;
    }
}