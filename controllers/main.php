<?php
class MainController {
    private $pages = array(
        "home" => array(
            "contentTemplate" => "singleplayer.phtml",
            "pageTitle" => "Singleplayer"
        ),
        "coop" => array(
            "contentTemplate" => "cooperative.phtml",
            "pageTitle" => "Cooperative"
        ),
        "changelog" => array(
            "contentTemplate" => "changelog.phtml",
            "pageTitle" => "Score updates"
        ),
        "profile" => array(
            "contentTemplate" => "profile.phtml",
            "pageTitle" => "Profile"
        ),
        "chamber" => array(
            "contentTemplate" => "chamber.phtml",
        ),
        "leastportals" => array(
            "contentTemplate" => "leastportals.phtml",
            "pageTitle" => "Least portals"
        ),
        "singlesegment" => array(
            "contentTemplate" => "singlesegment.phtml",
            "pageTitle" => "Singlesegment runs"
        ),
        "404" => array(
            "contentTemplate" => "404.phtml",
            "pageTitle" => "404 Not Found"
        ),
        "editprofile" => array(
            "contentTemplate" => "editprofile.phtml",
            "pageTitle" => "Edit profile"
        ),
        "validateuser" => array(
            "contentTemplate" => "404.phtml",
        ),
        "logout" => array(
            "pageTitle" => "Log out"
        )
    );

    public function __construct()
    {
        $this->startupTimestamp = microtime(true);

        $this->Page = $this->getParam("page");
        $this->ID = $this->getParam("id");
        $this->Type = $this->getParam("type");
        
        session_set_cookie_params(86400);
        session_start();

        $this->manageRequest();
    }

    public function manageRequest() {
        $view = new View();
        if(isset($this->Page) == NULL) {
            $this->Page = "home";
        }
        if (!isset($this->pages[$this->Page])) {
            $this->Page = "404";
        }

        if($this->Page == "validateuser") {
            if ($user = SteamSignIn::validate()) {
                Users::processProfile($user);
            }
            header("Location: /home");
        }

        if($this->Page == "logout") {
            unset($_SESSION["user"]);
            header("Location: /home");
        }

        $view->pageName = @$this->pages[$this->Page]["pageTitle"]; // Shhh my little child

        if($this->Page == "validateuser") {
            if ($user = SteamSignIn::validate()) {
                Users::processProfile($user);
                header("Location: /home");
            }
        }


        if (Users::isLoggedIn()) {
            $view->User = new Users(Users::getLoggedInUser());
            $view->User->getLoggedInUserData();
        }

        /* Nuclear, dont you think its wiser to just use one template for SP and COOP page? */
        if($this->Page == "home") {
            $view->board = BoardCache::getBoard("SPBoard");
        }
        if($this->Page == "coop") {
            $view->board = BoardCache::getBoard("COOPBoard");
        }

        if($this->Page == "changelog") {
            $param = array("bychamber_name" => "", "bychapter_name" => "", "byplayernickname" => "", "byplayer_steamid" => "", "bytype" => "", "amount" => "50", "sp" => "1", "coop" => "1", "wr" => "");
            if ($_POST) {
                $changelog_post = array();
                foreach ($_POST as $key => $val) {
                    $changelog_post[$key] = $val;
                }
                foreach ($changelog_post as $key => $val) {
                    if (array_key_exists($key, $param)) {
                        $param[$key] = $changelog_post[$key];
                    }
                }
                if ($changelog_post["sp"] == "1" && $changelog_post["coop"] != "1") {
                    $param["bytype"] = "0";
                } elseif ($changelog_post["sp"] != "1" && $changelog_post["coop"] == "1") {
                    $param["bytype"] = "1";
                }
                if ($changelog_post["wr"] == "0") {
                    $param["wr"] = "";
                }
            }
            $view->scoreUpdates = Leaderboard::get_latest_changes($param);
        }

        if($this->Page == "profile" && $this->ID != NULL) {
            $view->profile = new Users($this->ID);
            $view->profile->getProfileData();
            /* All the necessary swag */
            $view->addCss("/morris-0.4.3.min.css")
                 ->addJs("/js/morris-0.4.3.min.js")
                 ->addJs("/js/raphael-min.js")
                 ->addJs("/js/Vague.js");
            $view->pageName = (isset($view->profile->profileDisplayName)) ? $view->profile->profileDisplayName : "No profile";
        }

        if($this->Page == "chamber" && $this->ID != NULL) {
            $view->addJs("http://code.jquery.com/color/jquery.color-2.1.0.min.js");
            $amount = ($this->Type == "full") ? 200 : 20;
            $view->chamber = Leaderboard::return_chamber($this->ID, $amount);
            $view->pageName = $view->chamber[1][1]; // Chamber name
        }

        if($this->Page == "leastportals") {
            $view->board = LeastPortals::return_leastportals_board();
        }

        if($this->Page == "singlesegment") {
            $view->singlesegment = Leaderboard::getSinglesegmentData();
        }

        if($this->Page == "singlesegmentupdate") {
            Leaderboard::newSingleSegmentData();
            header("Location: /home");
        }

        if($this->Page == "editprofile") {
            if (Users::isLoggedIn()) {
                $user = $_SESSION["user"];
                if ($_POST) {
                    if (strlen($_POST["twitch"]) != 0) {
                        if (!preg_match("/^[A-Za-z0-9_]+$/", $_POST["twitch"])) {
                            $msg = "Twitch username must contain only letters, numbers, and underscores. ";
                        }
                    }
                    if (strlen($_POST["youtube"]) != 0) {
                        if (!preg_match("/^[A-Za-z0-9_]+$/", $_POST["youtube"])) {
                            $msg = "Youtube username must contain only letters, numbers, and underscores. ";
                        }
                    }

                    if (!isset($msg)) {
                        $db = new database();
                        $twitch = $db->real_escape_string($_POST["twitch"]);
                        $youtube = $db->real_escape_string($_POST["youtube"]);
                        Users::saveProfile($user, $twitch, $youtube);
                        $msg = "Your precious data was saved.";
                    }
                    $content["msg"] = $msg;
                }
                $content["inputs"] = Users::getEditProfileData($user);
            } else {
                header("Location: /home");
            }
        }

        /* I bet there is someone out there who thinks this is wrong */
        include($_SERVER["DOCUMENT_ROOT"] . "/views/main.phtml");
    }

    protected function getParam($name) {
        return (isset($_GET[$name])) ? $_GET[$name] : NULL;
    }
}