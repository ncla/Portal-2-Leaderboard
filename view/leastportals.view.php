<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<title>Leaderboards</title>

<link rel="stylesheet" type="text/css" href="/style.css?13371337420swag"></link>
<script type="text/javascript" src="/js/jquery-1.10.2.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	$(".youtube_icon").click(function() {
		var chamber = $(this).parent().parent().parent().parent();
		var time = $(chamber).find(".portalamount:eq(0)").html();
		var chamber_name = $(chamber).find(".titlebg a:eq(0)").html();
		var c_name = chamber_name.replace(" ", "+").replace(/[0-9]/g, '');
		var url = "https://www.youtube.com/results?search_sort=video_date_uploaded_reverse&search_query=portal+2+"+c_name+"+"+time+" portals";
		window.open(url, '_blank');
	})
})
</script>
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

	<div id="content" class="leastportals">
		<?php 
			$highlight = $this->logged_player_board_nickname;
			$i=1; foreach($content as $board_key => $board_val): ?>
			<div class="chapterinfo">
			<?php 
			$chapter_number = $i;
			if(strlen($i) != 2) {
				$chapter_number = "0".$i;
			}
			?>
			<h1 class="chapternumber">Chapter <?php echo $chapter_number;$i++;?></h1>
			<h1 class="chaptername"><?=$board_key;?></h1>
			</div>
			<div class="chambers">
			<?php foreach($board_val as $chamb_key => $chamb_val): ?>


				<div class="chamber leastportals">
				<div class="chamberimage" style="background: url('/images/chambers/<?=$chamb_val[1];?>.jpg')">
					<div class="chambertitle">
						<div class="titlebghelper"></div>
						<div class="titlebg"><a href="http://steamcommunity.com/stats/Portal2/leaderboards/<?=$chamb_val[0];?>"><?=$chamb_key; ?></a></div>
						<div class="chamber_icons">
							<span class="icons youtube_icon"></span>
							<a href="<?php echo "http://steamcommunity.com/stats/Portal2/leaderboards/".$chamb_val[0]; ?>" class="icons steam_icon" target="_blank"></a>
						</div>
					</div>
					<div class="portalsused">
                        <?php $grammar = ($chamb_val[2] != 1) ? "PORTALS" : "PORTAL"; ?>
						<div class="portalamount"><?=$chamb_val[2];?></div> <?=$grammar;?>
					</div>
				</div>

			</div>
			<?php endforeach; ?>
			</div>

		

		<?php endforeach; ?>

	</div>

<div class="push"></div>

</div>

<?php include("footer.view.php"); ?>
</body>

</html>