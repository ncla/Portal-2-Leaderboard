<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<title>Leaderboards</title>

<link rel="stylesheet" type="text/css" href="/style.css"></link>
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

<body>
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

	<div id="content">
	<?php include("freemessage.view.php"); ?>

		<?php 
			$highlight = $this->logged_player_board_nickname;
			var_dump($highlight);
			$i=1; foreach($content as $board_key => $board_val): ?>
			<div class="chapterinfo">
			<h1 class="chapternumber">Chapter 0<?php echo $i;$i++;?></h1>
			<h1 class="chaptername"><?=$board_key;?></h1>
			</div>

			<?php foreach($board_val as $chamb_key => $chamb_val): ?>


				<div class="chamber">
				<div class="chamberimage" style="background: url('/images/chambers/<?=$chamb_val[0];?>.jpg')">
					<div class="chambertitle">
						<div class="titlebghelper"></div>
						<div class="titlebg"><a href="/chamber/<?=$chamb_val[0];?>"><?=$chamb_key; ?></a></div>
						<div class="chamber_icons">
							<?php if($this->pro): ?><a href="#" class="icons youtube_icon"></a><?php endif; ?>
							<a href="<?php echo "http://steamcommunity.com/stats/Portal2/leaderboards/".$chamb_val[0]; ?>" class="icons steam_icon" target="_blank"></a>
						</div>
					</div>

				</div>
				<div class="chamber_scores">


												<?php foreach($chamb_val[1] as $pl_key => $pl_val): ?>
													<?php if($pl_key == 0) { ?>
													<div class="firstplace">
														<div class="entry <?php if($highlight == $pl_val[0]) { echo "highlight"; } ?>">
															<div class="name"><?=$pl_val[0]?></div>
															<div class="score"><?=$pl_val[1]?></div>
														</div>
													</div>
													<div class="othernoobscores">
													<?php } 
													else {
													?>
													<div class="entry <?php if($highlight == $pl_val[0]) { echo "highlight"; } ?>">
														<div class="name"><?=$pl_val[0]?></div>
														<div class="score"><?=$pl_val[1]?></div>
													</div>
													<?php } ?>

												<?php endforeach; ?>
													</div>
												</div>
</div>
			<?php endforeach; ?>


		

		<?php endforeach; ?>

	</div>

<div class="push"></div>

</div>

<div id="footer">
	<div class="footerleft">Developed and designed by Nuclear, with minor help from @sNuuFix</div>
	<div class="footeright">This page was generated in <?php echo microtime(true) - $this->exec_time; ?> seconds</div>
</div>
</body>

</html>