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
			<h1 class="chaptername">Donation?</h1>
			</div>
			<div class="normalcontent">
				<div><b>TL,DR:</b> If you want changelog and YouTube search icon links in leaderboard view, donate 10$ or more. After you have donated, I will upgrade you as soon as possible.</div>
				<div>
					<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
					<input type="hidden" name="cmd" value="_s-xclick">
					<input type="hidden" name="hosted_button_id" value="8LNVXUWXRPJ7N">
					<table>
					<tr><td><input type="hidden" name="on0" value="Donation options">Donation options</td></tr><tr><td><select name="os0">
						<option value="Minimum">Minimum $10.00 USD</option>
						<option value="Donation 1">Donation 1 $1.00 USD</option>
						<option value="Donation 2">Donation 2 $5.00 USD</option>
					</select> </td></tr>
					</table>
					<input type="hidden" name="currency_code" value="USD">
					<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
					<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
					</form>
				</div>
				<div><img src="images/pro.jpg"></img></div>
				<div>Why I dare to ask for donations? Because of the amount of work I have put into this leaderboards site. I designed this webpage on my own, developed this myself, estimating in around 1000 lines of code. The leaderboards site, especially changelog feature, is quite resource heavy, as it sends 100 requests to Steam servers for each Portal 2 leaderboard, to get new data about leaderboards. The information updates every two minutes. Also there is web server costs, which might not be alot, but still a good reason to mention.</div>
				<div>There was ofcourse old Leaderboards site, which was, honestly saying, shit. It's way of storing data, comparing information and changeloging was wrong, design was boring and dark. And slowly became unoptimized by itself.</div>
				<div>Even if I don't get many donations, as another developer once said, developing something for experience is not a waste of time. I learned quite a lot while recoding this leadeboards site.</div>
				<div>If you can't donate those 10$, you can donate less and it still will be something charitable.</div>
				
				<div>If you want a certain new feature on this site, or want this type of leaderboards for a game that has Steam leadeboards, make a deal with me. ;)</div>
				<div>I would like to thank @sNuuFix for minor help developing this leaderboards, Lemonsunshine for gathering SP and COOP pictures for leaderboards, Cervon.net hosting for hosting this amazing site and making it possible to fetch new data automatically every 2 minutes for changelog.</div>
			</div>
	</div>

<div class="push"></div>

</div>

<?php include("footer.view.php"); ?>

</body>

</html>