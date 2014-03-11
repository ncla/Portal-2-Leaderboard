<?php 
	if(!$this->logged) { ?>
	<a href="<?php echo SteamSignIn::genUrl("http://".$_SERVER['HTTP_HOST']."/?page=validateuser"); ?>" id="loginsteam"></a>
	<div id="seper"></div>
	<div id="edition"></div>
<?php } else { ?>
	<div id="welcome" class="threelines">
		
		<div class="firstline">Welcome back, <?=$this->nickname;?></div>
		<div>Profile ID - <?=$this->profile_number;?></div>
        <div><a href="/editprofile">Edit profile</a> | <a href="/profile/<?=$this->profile_number;?>">View profile</a></div>
	</div><img class="avatar" src="<?=$this->avatar;?>" alt="" />
	<div id="seper"></div>
	<div id="edition"></div>
<?php } ?>