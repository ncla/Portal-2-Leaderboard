<?php 
	$edition = "FREE";
	if($this->pro) {
		$edition = "PRO";
	}
	if(!$this->logged) { ?>
	<a href="<?php echo SteamSignIn::genUrl("http://".$_SERVER['HTTP_HOST']."/?page=validateuser"); ?>" id="loginsteam"></a>
	<div id="seper"></div>
	<a href="/donate" id="edition"><?=$edition;?></a>
<?php } else { ?>
	<div id="welcome" <?php if(!$this->pro) { ?> class="threelines"<?php } ?>>
		
		<div class="firstline">Welcome back, <?=$this->nickname;?></div>
		<div>Profile ID - <?=$this->profile_number;?></div>
		<?php if(!$this->pro) { ?><div id="donate"><a href="/donate">Donate<a></div><?php } ?>
	</div><img class="avatar" src="<?=$this->avatar;?>" alt="" />
	<div id="seper"></div>
	<a href="/donate" id="edition"><?=$edition;?></a>
<?php } ?>