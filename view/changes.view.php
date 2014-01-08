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
		var chamber_name = $(chamber).find(".titlebg:eq(0)").html();
		var c_name = chamber_name.replace(" ", "+");
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
			<div class="chapterinfo">
			<h1 class="chapternumber">Chapter 999999..</h1>
			<h1 class="chaptername">Changes</h1>
			</div>
			<div class="normalcontent">
				<div class="changes_entry">
					2013-08-19
				</div>
				<div class="changes_info">
					<div class="change_info">SP/COOP view generation improved by ~0.013 seconds, by making use of prepared statements.</div>
				</div>
				<div class="changes_entry">
					2013-08-17
				</div>
				<div class="changes_info">
					<div class="change_info">SP/COOP and CHAMBER view query improved to blacklist (ignore) individual players on x chamber. This affects chambers Funnel Intro, Funnel Drill, Trust Fling, Funnel Catch (SP)</div>
					<div class="change_info">Previously it would not show times that are LESS than current legit world record time. If Undeadgamer97 improved his 38.38s time on Trust Fling, his time would not show because it is better time than the current legit world record time. I would have to update the legit time manually.</div>
					<div class="change_info">If you do improve your time, in a legitamate way, and you are banned on my leaderboards on a specific chamber, please contact me Nuclear on Steam.</div>
				</div>
				<div class="changes_entry">
					2013-08-12
				</div>
				<div class="changes_info">
					<div class="change_info">CHAMBER pages are introduced. Access them from SP/COOP view by clicking on the chamber name. You can view previous/next chamber by clicking on the left/right in the chamber image block.</div>
					<div class="change_info">COOP chamber names now doesn't have numbers in them.</div>
				</div>
				<div class="changes_entry">
					2013-08-05
				</div>
				<div class="changes_info">
					<div class="change_info">Trust Flings, Funnel Catch, Funnel Drill now display scores that are equal or higher than the actual legit WR time.</div>
					<div class="change_info">COOP view displays two players in first place, if they both have the same time.</div>
				</div>
				<div class="changes_entry">
					2013-08-03
				</div>
				<div class="changes_info">
					<div class="change_info">Now if you login with Steam on my site, it will assign a nickname on leaderboards, if you had a profileID number previously.s</div>
				</div>
				<div class="changes_entry">
					2013-08-01
				</div>
				<div class="changes_info">
					<div class="change_info">Leaderboards site released for public</div>
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