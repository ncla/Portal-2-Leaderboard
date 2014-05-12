<?php
include('loader.php');

$board = new Leaderboard();
$board->fetchNewData();
/*
    APC has different cache when used from command line, see:
    http://www.php.net/manual/en/function.apc-fetch.php#106360
*/
if('127.0.0.1' == $_SERVER["REMOTE_ADDR"]) {
    $board->cacheLeaderboard();
}
else {
    file_get_contents('http://board.ncla.me/refreshcache.php');
}
?>