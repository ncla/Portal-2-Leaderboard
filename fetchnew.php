<?php
include('model.php');
include('db_conf.php');
new Leaderboard();

$contents = file_get_contents("lp.txt");

$atm = time();
$difference = $atm - $contents;

if(round($difference) > 3600) {
	new LeastPortals;
	$currenttime = time();
	file_put_contents("lp.txt", $currenttime);
}
?>