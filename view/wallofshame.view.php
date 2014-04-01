<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<title>Leaderboards</title>

<link rel="stylesheet" type="text/css" href="/style.css?13371337420swag"></link>
<script type="text/javascript" src="/js/jquery-1.10.2.min.js"></script>
<?php if($this->pro): ?>
<script type="text/javascript">
$(document).ready(function() {
	$(".youtube_icon").click(function() {
		var chamber = $(this).parent().parent().parent().parent();
		var time = $(chamber).find(".score:eq(0)").html();
		var chamber_name = $(chamber).find(".titlebg a:eq(0)").html();
		var c_name = chamber_name.replace(" ", "+").replace(/[0-9]/g, '');
		var url = "https://www.youtube.com/results?search_query=portal+2+"+c_name+"+"+time;
		window.open(url, '_blank');
	})
})
</script>
<?php endif; ?>
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-43126557-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
</head>

<body class="wallofshame">
<div id="wrapper">
	<div id="header">
		<div id="header_left">
			<h2 id="sitetitle">PORTAL 2 LEADERBOARDS</h2>
			<div id="navigation">
				<?php include("navigation.view.php"); ?>
			</div>
		</div>

		<div id="header_right">
			<div id="userinfo">
				<?php include("userinfo.view.php"); ?>
			</div>
		</div>
	</div>
	<?php 
	$bannedPlayers = $content[0]; 
	$bannedScores = $content[1];
	?>
	<div id="content">

		<div class="chapterinfo banned-scores">
			<h1 class="chaptername">Individually banned player scores</h1>
		</div>
		<div class="banana banned-scores">
				<h2>In total <?php echo count($bannedScores); ?> scores are removed by banning individual scores on chambers</h2>
				<?php foreach($bannedScores as $score => $scoreData): ?>
					<p><span class="chambername"><a href="http://steamcommunity.com/stats/Portal2/leaderboards/<?=$scoreData[3]?>"><?=$scoreData[1]?> <?=$scoreData[0]?></a></span> by <span class="playernamewrapper"><a href="http://steamcommunity.com/profiles/<?=$scoreData[4]?>" class="playername"><?=$scoreData[2]?></a></span></p>
				<?php endforeach; ?>
			</div>

		<div class="chapterinfo">
			<h1 class="chaptername">Banned player affected scores</h1>
		</div>
			<div class="banana">
				<h2>In total <?php echo count($bannedPlayers); ?> scores are removed by banning player profile ID</h2>
				<?php foreach($bannedPlayers as $score => $scoreData): ?>
					<p><span class="chambername"><a href="http://steamcommunity.com/stats/Portal2/leaderboards/<?=$scoreData[2]?>"><?=$scoreData[1]?> <?=$scoreData[0]?></a></span> by <span class="playernamewrapper"><a href="http://steamcommunity.com/profiles/<?=$scoreData[3]?>" class="playername"><?=$scoreData[3]?></a></span></p>
				<?php endforeach; ?>
			</div>
	</div>

<div class="push"></div>

</div>

<?php include("footer.view.php"); ?>
</body>

</html>