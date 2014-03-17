<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<title>Leaderboards</title>
<script type="text/javascript" src="/js/jquery-1.10.2.min.js"></script>
<link rel="stylesheet" type="text/css" href="/style.css"></link>
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

		<div id="filters">
			<div id="filter_instructions_lol">Use these filters to display the changelog you want</div>
			<div id="filter_options">
				<form name="filters" action="/changelog" method="post">
					<div style="float: left;" class="input">
						<label for="nickname">Nickname</label>
						<input type="text" name="byplayernickname" value="<?=$param['byplayernickname'];?>">
					</div>

					<div style="float: left;" class="input">
						<label for="profilenumber">Steam profile number</label>
						<input type="text" name="byplayer_steamid" value="<?=$param['byplayer_steamid'];?>">
					</div>

					<div style="float: left;" class="input">
						<label for="profilenumber">Map name</label>
						<input type="text" name="bychamber_name" value="<?=$param['bychamber_name'];?>">
					</div>

					<div style="float: left;" class="input">
						<label for="profilenumber">Chapter name</label>
						<input type="text" name="bychapter_name" value="<?=$param['bychapter_name'];?>">
					</div>
					<script type="text/javascript">
					$(document).ready(function() {
						$(".checkbox").click(function() {
							$(this).toggleClass("ticked");
							var v = $(this).parent().find("input:eq(0)").val();
							v = (v == 0 ? 1 : 0);
							$(this).parent().find("input:eq(0)").val(v);
						});
						function inputresize() {
							var troll = $("#filters").width() - 500;
							var troll = troll / 4;
							// my pro lazy javascript skills. pls dont judge me from this.
							$("input[type=text]").attr("style", "width:"+troll+"px");
						}
						inputresize();
						$(window).resize(inputresize);

						$("#otherentries .entry:odd").attr("style", "background: #d3d3d3;");



					});
					</script>
					<div style="float: left;" class="check">
						<div style="position: relative; ">Singleplayer</div>
						<div class="checkbox <?php if($param['sp'] == "1"): ?>ticked<?php endif; ?>"></div>
						<input type="hidden" value="<?=$param['sp'];?>" name="sp">
					</div>
					<div style="float: left;" class="check">
						<div style="position: relative;">Cooperative</div>
						<div class="checkbox <?php if($param['coop'] == "1"): ?>ticked<?php endif; ?>"></div>
						<input type="hidden" value="<?=$param['coop'];?>" name="coop">
					</div>
					<div style="float: left;" class="check">
						<div style="position: relative;">World record</div>
						<div class="checkbox <?php if($param['wr'] == "1"): ?>ticked<?php endif; ?>"></div>
						<input type="hidden" value="<?=$param['wr'];?>" name="wr">
					</div>
					<div style="float: right; margin: 30px 20px 0px 0px">
						<input type="submit" value="Filter"></input>
					</div>
				</form>


			</div>
		</div>

		<div id="changelog">
			<div id="firstentry">
				<div class="time">Time</div>
				<div class="player">Player</div>
				<div class="map">Map</div>
				<div class="chapter">Chapter</div>
				<div class="newscore">New score</div>
				<div class="previousscore">Previous score</div>
				<div class="worldrecord">World Record</div>
			</div>
			<div id="otherentries">
				<?php foreach ($content as $key => $val): ?>
				<div class="entry <?php if($val[9] == "1") { ?>hidden<?php } ?>">
					<div class="time"><?=$val[6]?></div>
					<div class="player"><?=$val[0]?></div>
					<div class="map"><?=$val[4]?></div>
					<div class="chapter"><?=$val[5]?></div>
					<div class="newscore"><?=$val[1]?> <?php if($val[8] != null) { echo "(-".$val[8].")"; }?></div>
					<div class="previousscore"><?=$val[7]?></div>
					<div class="worldrecord"><?php if($val[3] == 1) { ?><div class="wr"></div><?php } ?></div>
				</div>
				<?php endforeach; ?>
			</div>
		</div>

	</div>

<div class="push"></div>

</div>

<div id="footer">
	<div class="footerleft">Developed and designed by Nuclear, with minor help from @sNuuFix</div>
	<div class="footeright">This page was generated in <?php echo microtime(true) - $this->exec_time; ?> seconds</div>
</div>

</body>

</html>