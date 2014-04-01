<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<title>Leaderboards</title>

<link rel="stylesheet" type="text/css" href="/style.css"></link>
<link rel="stylesheet" type="text/css" href="/stylechamber.css"></link>

<script type="text/javascript" src="/js/jquery-1.10.2.min.js"></script>
<!--<script type="text/javascript" src="/js/jquery.domchanged.min.js"></script>-->
<script type="text/javascript" src="http://code.jquery.com/color/jquery.color-2.1.0.min.js"></script>
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

<script type="text/javascript">
$(document).ready(function() {
	$(".entry:odd").attr("style", "background: #d3d3d3;");
	    function fadeInLetters(selector) {
       var txt = $(selector).html(); 
        var shiny = "";
        for(var i=0;i<=$(selector).html().length - 1;i++) {
            var letter = txt.charAt(i);
            if(letter == " ") {
                letter = "&nbsp;";    
            }
            shiny += "<div class='seperate'>"+letter+"</div>";
        }
        $(selector).css("opacity", "1");
        $(selector).html(shiny);
        $(selector+" .seperate").each(function(index) {
            setTimeout(function() { 
                $(selector+" .seperate:eq("+index+")").animate({opacity:1}, 150, "linear", function() 
                	{
                		setTimeout(function() {
							$(selector+" .seperate:eq("+index+")").animate({color: "#E1E8EB"}, 300);

                		}, 200);
                		
                	});
                  }, 100 * (index + 1));
        });
    }
    setTimeout(function() { 
    	fadeInLetters(".chamberchambername");
    	fadeInLetters(".chamberchaptername");
    }, 700);
    // DOM change
    var body = $(".entries").html();
    var len = body.length;
    setInterval(function() {
    	if(len != $(".entries").html().length) {
    		$(".entries").html(body);
    	}
    }, 100);
})
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
    <?php include("freemessage.view.php"); ?>
    <div id="content">
        <div id="chamber">
			<div class="chamberview" style="background-image: url('/images/chambers_full/<?=$_GET['id'];?>.jpg')">
				<a class="previous_map" href="/chamber/<?=$content[2];?>"></a>
				<a class="next_map" href="/chamber/<?=$content[3];?>"></a>
				<div class="chamberinfo">
					<div class="chamberchaptername"><?=$content[1][0];?></div>
					<?php if($content[4] == "1"): ?>
                        <a href="http://steamcommunity.com/stats/Portal2/leaderboards/<?=$_GET['id'];?>" target="_blank" class="chamberchambername"><?=$content[1][1];?></a>
                    <?php endif; ?>

                    <?php if($content[4] == "0" && !isset($_GET["type"])): ?>
                        <a href="/chamber/<?=$_GET['id'];?>/full" class="chamberchambername"><?=$content[1][1];?></a>
                    <?php endif; ?>

                    <?php if($content[4] == "0" && isset($_GET["type"])): ?>
                        <span class="chamberchambername"><?=$content[1][1];?></span>
                    <?php endif; ?>
				</div>
			</div>
            <?php if($content[4] == "0"): ?>
            <div class="not-public-chambers" <?php if(isset($_COOKIE["readthisshit"])): ?> style="display:none"<?php endif;?> >
                <span class="text">
                    This chamber is not available through official Steam leaderboard pages, but is however accessible through in-game by modifying maplist .txt file. Here is <a href="http://youtu.be/8mtyKGh_e-w?t=18m30s">tutorial</a> on how to get them.
                    <span class="close-btn"></span>
                </span>
            </div>

                <script type="text/javascript">
                    $(".not-public-chambers .close-btn").click(function() {
                        $(".not-public-chambers").slideToggle();
                        /* Remember that he has red this shit */
                        var d = new Date();
                        d.setTime(d.getTime()+(604800000));
                        var expires = "expires="+d.toGMTString();
                        document.cookie = "readthisshit=yes; " + expires;
                    })
                    <?php if($content[4] == "0" && isset($_GET["type"])): ?>
                    $(".chamberchambername").click(function() {
                        $(".not-public-chambers").slideDown();
                    })
                    <?php endif; ?>
                </script>
            <?php endif; ?>
			<div class="entries">
			<?php $i=1; foreach($content[0] as $key => $val): ?>
				<div class="entry <?php if($val[2] == $this->user_id){echo "you";}?> ">
					<div class="place">#<?=$i;?></div>
					<div class="name"><a href="/profile/<?=$val[2];?>"><?=$val[0];?></a></div>
					<div class="score"><?=$val[1];?></div>
				</div>
			<?php $i++; endforeach; ?>
			</div>
		</div> 
	</div> 

<div class="push"></div>

</div>

<?php include("footer.view.php"); ?>

</body>

</html>