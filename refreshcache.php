<?php
include('model.php');
include('db_conf.php');
include('boardcache.php');
$board = new Leaderboard();
$board->cacheLeaderboard();
?>