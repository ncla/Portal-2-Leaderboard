<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<title>Leaderboards</title>

<link rel="stylesheet" type="text/css" href="/style.css?13371337420swag"></link>
<script type="text/javascript" src="/js/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="/js/Vague.js"></script>
<link rel="stylesheet" href="/morris-0.4.3.min.css">
<script src="/js/raphael-min.js"></script>
<script src="/js/morris-0.4.3.min.js"></script>

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
        <div id="profile">
            <?php $user = $content; ?>
            <?php if($user->isRegistered): ?>
                <?php $avatar = ($user->userData->avatar != NULL) ? $user->userData->avatar : "http://media.steampowered.com/steamcommunity/public/images/avatars/f9/f91787b7fb6d4a2cb8dee079ab457839b33a8845_full.jpg"; ?>
                <div class="userinformation">
                    <?php if($user->profileNumber == "76561198043770492"): ?>
                        <script type="text/javascript" src="/js/jquery.tubular.1.0.js"></script>
                        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/swfobject/2.1/swfobject.js"></script>
                        <div id="youtubewrap" style="width: 980px; height: 270px; overflow: hidden; background: #000;">
                            <div id="ytyt">
                                <div id="ytapiplayer">What are you? Living under fucking rock without Flash installed and/or JavaScript disabled?</div>
                            </div>

                            <script type="text/javascript">
                                $(document).ready(function() {
                                    var params = { allowScriptAccess: "always", wmode: "transparent" };
                                    var atts = { id: "myytplayer" };
                                    var videoID = "EF_xdvn52As";
                                    swfobject.embedSWF("http://www.youtube.com/v/"+ videoID +"?enablejsapi=1&iv_load_policy=3&playerapiid=ytplayer&version=3&controls=0&start=91&autoplay=1&disablekb=1&rel=0&showinfo=0","ytapiplayer", 980, 551, "8", null, null, params, atts);
                                });
                                function onYouTubePlayerReady(playerId) {
                                    player = document.getElementById("myytplayer");
                                    player.mute();
                                }
                            </script>
                        </div>
                    <?php else: ?>
                        <div class="profilebg hasavatar">
                            <img src="<?php echo $avatar; ?>" alt="" id="profileimage"/>
                        </div>
                        <script type="text/javascript">
                            var Vague = $('#profileimage').Vague({
                                intensity: 15,
                                forceSVGUrl: false
                            });
                            Vague.blur();
                        </script>
                    <?php endif; ?>
                    <div class="general">
                        <div class="general-wrapper">
                            <img src="<?php echo $avatar; ?>" alt=""/>
                            <div class="nickname"><?php echo $user->profileDisplayName; ?></div>
                            <?php if($user->userData->title != NULL): ?>
                                <div class="profile-desc"><?=$user->userData->title;?></div>
                            <?php endif; ?>
                            <div class="usericons">
                                <?php if(strlen($user->userData->youtube) > 0): ?>
                                    <a href="http://www.youtube.com/user/<?=$user->userData->youtube;?>" target="_blank"><span class="youtube"></span></a>
                                <?php endif; ?>

                                <?php if(strlen($user->userData->twitch) > 0): ?>
                                    <a href="http://www.twitch.tv/<?=$user->userData->twitch;?>" target="_blank"><span class="twitch"></span></a>
                                <?php endif; ?>

                                <a href="http://steamcommunity.com/profiles/<?=$user->profileNumber;?>" target="_blank"><span class="steam"></span></a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php if(!strlen($user->userData->twitch) > 0): ?>
                    <div class="twitch-linked">
                        <script type="text/javascript">
                            /* Original code from SteamDB.info */
                            jQuery.ajax({cache: true, dataType: 'jsonp', url: '//api.twitch.tv/api/steam/<?=$user->profileNumber;?>', success: function (data) {
                                if (data.name) {
                                    jQuery('.twitch-linked').append(jQuery('<span>', { text: 'This user has linked Steam profile to Twitch.TV as ' }).append(jQuery('<a>', { rel: 'nofollow', target: '_blank', href: '//www.twitch.tv/' + data.name, text: data.name }))).slideDown('slow');
                                }
                            }});
                        </script>
                    </div>
                <?php endif; ?>
                <?php if($user->userData->banned != 1 && $user->hasRecords): ?>
                <div class="profile-title"><span>GLOBAL STATISTICS</span></div>
                <div class="global-stats">
                    <div class="block-container">
                        <div class="block">
                            <div class="block-inner">
                                <div class="number"><?php echo $user->Worldrecords->SPAmount; ?></div>
                                <div class="title"><span>SINGLEPLAYER <br/>WORLD RECORD<?php if($user->Worldrecords->SPAmount != 1) {?>S<?php } ?></span></div>
                            </div>
                        </div>
                        <div class="block">
                            <div class="block-inner">
                                <div class="number"><?php echo $user->Worldrecords->COOPAmount; ?></div>
                                <div class="title"><span>COOPERATIVE <br/>WORLD RECORD<?php if($user->Worldrecords->COOPAmount != 1) {?>S<?php } ?></span></div>
                            </div>
                        </div>
                        <div class="block">
                            <div class="block-inner">
                                <div class="number"><?php echo $user->Worldrecords->GlobalAmount; ?></div>
                                <div class="title"><span>WORLD RECORD<?php if($user->Worldrecords->GlobalAmount != 1) {?>S<?php } ?> <br/>IN TOTAL</span></div>
                            </div>
                        </div>
                    </div>
                    <div class="block-container">
                        <div class="block">
                            <div class="block-inner">
                                <div class="number"><?php echo $user->Points->SPPointsAll; ?></div>
                                <div class="title"><span>SINGLEPLAYER <br/>POINT<?php if($user->Points->SPPointsAll != 1) {?>S<?php } ?></span></div>
                            </div>
                        </div>
                        <div class="block">
                            <div class="block-inner">
                                <div class="number"><?php echo $user->Points->COOPPointsAll; ?></div>
                                <div class="title"><span>COOPERATIVE <br/>POINT<?php if($user->Points->COOPPointsAll != 1) {?>S<?php } ?></span></div>
                            </div>
                        </div>
                        <div class="block">
                            <div class="block-inner">
                                <div class="number"><?php echo $user->Points->pointSummary; ?></div>
                                <div class="title"><span>POINT<?php if($user->Points->pointSummary != 1) {?>S<?php } ?> IN <br/>TOTAL</span></div>
                            </div>
                        </div>
                    </div>
                    <div class="block-container">
                        <div class="block">
                            <div class="block-inner">
                                <div class="number"><?php echo ($user->ranks->SP != NULL) ? Grammar::number($user->ranks->SP) : "NO"; ?></div>
                                <div class="title"><span>PLACE IN <br/>SINGLEPLAYER</span></div>
                            </div>
                        </div>
                        <div class="block">
                            <div class="block-inner">
                                <div class="number"><?php echo ($user->ranks->COOP != NULL) ? Grammar::number($user->ranks->COOP) : "<span class='no'>NO</span>"; ?></div>
                                <div class="title"><span>PLACE IN <br/>COOPERATIVE</span></div>
                            </div>
                        </div>
                        <div class="block">
                            <div class="block-inner">
                                <div class="number"><?php echo Grammar::number($user->ranks->Global); ?></div>
                                <div class="title"><span>PLACE IN <br/>LEADERBOARD</span></div>
                            </div>
                        </div>
                    </div>
                    <div class="block-container">
                        <div class="block">
                            <div class="block-inner">
                                <div class="number"><?php echo ($user->SPAveragePlace != NULL) ? $user->SPAveragePlace : "NO"; ?></div>
                                <div class="title">
                                    <span>
                                        AVERAGE PLACE<br/> IN SINGLEPLAYER
                                        <?php if($user->SPAveragePlace == NULL): ?><span class="place-expl" title="To determine your average place in Singleplayer leaderboards, you need minimum 10 entries on leaderboard">(?)</span><?php endif; ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="block">
                            <div class="block-inner">
                                <div class="number"><?php echo ($user->COOPAveragePlace != NULL) ? $user->COOPAveragePlace : "NO"; ?></div>
                                <div class="title">
                                    <span>
                                        AVERAGE PLACE<br/> IN COOPERATIVE
                                        <?php if($user->COOPAveragePlace == NULL): ?><span class="place-expl" title="To determine your average place in Cooperative leaderboards, you need minimum 10 entries on leaderboard">(?)</span><?php endif; ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="block">
                            <div class="block-inner">
                                <div class="number"><?php echo ($user->GlobalAveragePlace != NULL) ? $user->GlobalAveragePlace : "NO"; ?></div>
                                <div class="title">
                                    <span>
                                        AVERAGE PLACE<br/> OVERALL
                                        <?php if($user->GlobalAveragePlace == NULL): ?><span class="place-expl" title="To determine your average place overall, you need minimum 10 entries on leaderboard">(?)</span><?php endif; ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <script type="text/javascript">
                    $(".global-stats .block-container").each(function() {
                        var width = 0;
                        $(this).find(".number").each(function() {
                            if($(this).width() > width) {
                                width = $(this).width();
                            }
                        })
                        $(this).find(".number").width(width);
                    })
                </script>
                <div class="profile-title"><span>SCORE UPDATE ACTIVITY IN THE PAST 30 DAYS</span></div>
                <div class="statistics">
                    <div class="activity">
                        <?php if($user->changelogPast30days != null): ?>
                            <div id="changelogactivity" style="height: 175px;"></div>
                            <script type="text/javascript">
                                new Morris.Line({
                                    element: 'changelogactivity',
                                    data: [
                                        <?php foreach(array_reverse($user->activityPast30days) as $key => $val): ?>
                                        { year: '<?=$key;?>', value: <?=$val;?> },
                                        <?php endforeach; ?>
                                    ],
                                    xkey: 'year',
                                    ykeys: ['value'],
                                    labels: ['Score updates'],
                                    smooth: false,
                                    gridTextSize: 11,
                                    parseTime: false,
                                    pointFillColors: ['#2f96d1'],
                                    lineColors: ['#2f96d1'],
                                    hideHover: 'auto'
                                });
                            </script>
                        <?php else: ?>
                            <div class="noactivity">
                                <span class="noact-wrap">
                                    <span>User has no score update activity in the past 30 days.</span>
                                    <span class="manualsearch">Do a manual search on player <a href="/changelog">here</a></span>
                                </span>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="column-3">
                    <div class="column">
                        <div class="profile-title"><span>RECORDS IN SINGLEPLAYER</span></div>
                        <div class="block-content all-records">
                            <?php if($user->Records->SP != NULL): ?>
                                <?php foreach($user->Records->SP as $chapter => $chapterData): ?>
                                    <div class="chapter-name"><?=$chapter;?></div>
                                    <div class="chapter-content">
                                        <?php foreach($chapterData as $map => $time): ?>
                                            <div><a href="/chamber/<?=$time[1];?>"><?=$map;?> - <?=$time[0];?></a></div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div>Player has no singleplayer records.</div>
                            <?php endif;?>
                        </div>
                    </div>
                    <div class="column mid">
                        <div class="profile-title"><span>RECORDS IN COOPERATIVE</span></div>
                        <div class="block-content all-records">
                            <?php if($user->Records->COOP != NULL): ?>
                                <?php foreach($user->Records->COOP as $chapter => $chapterData): ?>
                                    <div class="chapter-name"><?=$chapter;?></div>
                                    <div class="chapter-content">
                                        <?php foreach($chapterData as $map => $time): ?>
                                            <div><a href="/chamber/<?=$time[1];?>"><?=$map;?> - <?=$time[0];?></a></div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                    <div>Player has no cooperative records.</div>
                            <?php endif;?>
                        </div>
                    </div>
                    <div class="column">
                        <!--
                       YOU ARE GETTING WORSE, DUH
                       <c> GLaDOS
                       -->
                        <?php if($user->friendstobeat->SP != NULL): ?>
                            <div class="profile-title"><span>FRIENDS TO BEAT ON SINGLEPLAYER</span></div>
                            <div class="block-content">
                                <?php foreach($user->friendstobeat->SP as $entry => $entryData): ?>
                                    <div class="friendtobeat-entry <?php if($entryData[3] == $user->profileNumber) {?> you<?php } ?>">
                                        <?=$entryData[2];?>. <a class="ftb-nickname" href="/profile/<?=$entryData[3];?>"><?=$entryData[1];?></a> - <?=$entryData[0];?> point<?php if($entryData[0] != 1) { ?>s<?php } ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif ;?>

                        <?php if($user->friendstobeat->COOP != NULL): ?>
                            <div class="profile-title"><span>FRIENDS TO BEAT ON COOPERATIVE</span></div>
                            <div class="block-content">
                                <?php foreach($user->friendstobeat->COOP as $entry => $entryData): ?>
                                    <div class="friendtobeat-entry <?php if($entryData[3] == $user->profileNumber) {?> you<?php } ?>">
                                        <?=$entryData[2];?>. <a class="ftb-nickname" href="/profile/<?=$entryData[3];?>"><?=$entryData[1];?></a> - <?=$entryData[0];?> point<?php if($entryData[0] != 1) { ?>s<?php } ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>

                        <?php if($user->friendstobeat->Global != NULL): ?>
                            <div class="profile-title"><span>FRIENDS TO BEAT GLOBALLY</span></div>
                            <div class="block-content">
                                <?php foreach($user->friendstobeat->Global as $entry => $entryData): ?>
                                    <div class="friendtobeat-entry <?php if($entryData[3] == $user->profileNumber) {?> you<?php } ?>">
                                        <?=$entryData[2];?>. <a class="ftb-nickname" href="/profile/<?=$entryData[3];?>"><?=$entryData[1];?></a> - <?=$entryData[0];?> point<?php if($entryData[0] != 1) { ?>s<?php } ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>

                        <div class="profile-title"><span>POINT DIVISION BY CHAPTERS</span></div>
                        <div class="block-content">
                            <?php foreach($user->Points->SPChapters as $chapter => $points): ?>
                                <div class="point-chapter"><?=$chapter;?> - <?=$points;?></div>
                            <?php endforeach; ?>
                            <?php foreach($user->Points->COOPChapters as $chapter => $points): ?>
                                <div class="point-chapter"><?=$chapter;?> - <?=$points;?></div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php elseif(!$user->hasRecords): ?>
                        <div class="profile-title"><span>NO RECORDS</span></div>
                        <div class="noactivity">
                                 <span class="noact-wrap">
                                      <span>This user does not have any records.</span>
                                      <span class="manualsearch">We can't generate any information without leaderboard data. So sad. :(</span>
                                 </span>
                        </div>
                    <?php elseif($user->userData->banned == 1): ?>
                        <div class="profile-title"><span>EXCEPTION</span></div>
                        <div class="noactivity">
                             <span class="noact-wrap">
                                  <span>This user is banned.</span>
                                  <span class="manualsearch">Such shame.</span>
                             </span>
                        </div>
                    <?php else: ?>
                        <div class="profile-title"><span>HERP DERP</span></div>
                        <div class="noactivity">
                                 <span class="noact-wrap">
                                      <span>Derp.</span>
                                      <span class="manualsearch">You broke the profile page.</span>
                                 </span>
                        </div>
                    <?php endif; ?>
                </div>
            <?php else: ?>
                <div class="user-noexist">
                    <div class="stmt">Profile does not exist, either player has no records or hasn't logged into our site.</div>
                    <div>If you believe the statement above is incorrect, please contact site administrator.</div>
                </div>
            <?php endif; ?>
        </div>
	</div>

<div class="push"></div>

</div>
<!--
    We are the universe. Destroying itself.
    Observing itself.
-->
<?php include("footer.view.php"); ?>

</body>

</html>