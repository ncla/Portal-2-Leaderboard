<?php 
	$pls = array(
		'Want to know how good JETWASH_787 really is at Portal 2? <a href="/donate/">Upgrade to PRO to unlock changelog feature!</a>',
		'Too lazy to search for world record runs on YouTube? <a href="/donate/">Upgrade to PRO and get YouTube icon on leaderboard pages!</a>',
		'guise, pocky quit long ago here is evidence. <a href="/donate/">Upgrade to PRO and view score improvements.</a>',
		'Didn\'t know your favorite speedrunner got world record on a map because he didn\'t upload a video? <a href="/donate/">Not a problem anymore!</a>'
		);
	$lel = $pls[array_rand($pls)];
	if(!$this->pro) { ?>
		<div class="plsgibmoni"><?=$lel;?></div>
	<?php } ?>