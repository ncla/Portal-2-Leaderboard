<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<title>Leaderboards</title>

<link rel="stylesheet" type="text/css" href="/style.css?13371337420swagswag"></link>
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
	<?php //var_dump($content); ?>
	<div id="content">
		<div class="col-2set singlesegment">
			<div class="col1">
				<div class="ss-wrapper">
					<div id="ss-p1">
						<div class="ss-info">
							<h1>Portal 1</h1>
							<?php foreach($content[0]["Portal 1"] as $category => $board): ?>
								<h2><?=$category;?></h2>
							<?php endforeach; ?>
							<div class="ss-controls">
								<?php $i = 0; ?>
								<?php foreach($content[0]["Portal 1"] as $category => $board): ?>
									<?php $i++; ?>
									<span <?php if($i == 1):?>class="active"<?php endif;?>><?=$i;?></span>
								<?php endforeach; ?>
							</div>
						</div>
					</div>
					<div class="ss-tables">
						<?php foreach($content[0]["Portal 1"] as $category => $board): ?>
						<div class="datatable">
							<div id="firstentry">
								<div class="player">Player(s)</div>
								<div class="time-noloads">Time without loads</div>
								<div class="time-withloads">Time with loads</div>
							</div>
							<div id="otherentries">
								<?php foreach($board as $entry => $entryData): ?>
								<div class="entry">
									<div class="player"><?=$entryData["Player"]?></div>
									<div class="time-noloads"><?=$entryData["Time(w/o Loads)"]?></div>
									<div class="time-withloads"><?=$entryData["Time(w/ Loads)"]?></div>
								</div>
								<?php endforeach; ?>
							</div>
						</div>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
			<div class="col2">
				<div class="ss-wrapper">
					<div id="ss-p2">
						<div class="ss-info">
							<h1>Portal 2</h1>
							<?php foreach($content[0]["Portal 2"] as $category => $board): ?>
								<h2><?=$category;?></h2>
							<?php endforeach; ?>
							<div class="ss-controls">
								<?php $i = 0; ?>
								<?php foreach($content[0]["Portal 2"] as $category => $board): ?>
									<?php $i++; ?>
									<span <?php if($i == 1):?>class="active"<?php endif;?>><?=$i;?></span>
								<?php endforeach; ?>
							</div>
						</div>
					</div>
					<div class="ss-tables">
						<?php foreach($content[0]["Portal 2"] as $category => $board): ?>
						<div class="datatable">
							<div id="firstentry">
								<div class="player">Player(s)</div>
								<div class="time-noloads">Time without loads</div>
								<div class="time-withloads">Time with loads</div>
							</div>
							<div id="otherentries">
								<?php foreach($board as $entry => $entryData): ?>
								<div class="entry">
									<div class="player"><?=$entryData["Player"]?></div>
									<div class="time-noloads"><?=$entryData["Time(w/o Loads)"]?></div>
									<div class="time-withloads"><?=$entryData["Time(w/ Loads)"]?></div>
								</div>
								<?php endforeach; ?>
							</div>
						</div>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
			<div class="ss-notice"><b>Notice:</b> this is a mirror of <a href="http://cronikeys.com/portal/index.php?title=Leaderboards">CRONIKEYS.COM Wiki "Leaderboard" page</a>. This page was last updated <?=$content[1];?></div>
		</div>
	</div>
	<script type="text/javascript">
	$(document).ready(function() {
		$(".ss-controls span").click(function() {
			$(this).parent().find("span").removeClass("active");
			$(this).addClass("active");
			var btnIndex = $(this).index();
			var ssContainer = $(this).parent().parent();
			var ssWrapper = $(ssContainer).parent().parent();
			$(ssContainer).find("h2").hide();
			$(ssContainer).find("h2:eq("+btnIndex+")").show();
			$(ssWrapper).find(".datatable").hide();
			$(ssWrapper).find(".datatable:eq("+btnIndex+")").show();
		})
	})
	</script>
<div class="push"></div>
</div>

<?php include("footer.view.php"); ?>
</body>

</html>