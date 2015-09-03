<?php
/** 
* @copyright (C) MeClaud 2014-2015
* @author MeClaud <me.claud.69@gmail.com>
* @package Metin2CMS
*
*	This program is free software; you can redistribute it and/or modify
*	it under the terms of the GNU General Public License as published by
*	the Free Software Foundation; either version 2 of the License, or
*	(at your option) any later version.
*
*	This program is distributed in the hope that it will be useful,
*	but WITHOUT ANY WARRANTY; without even the implied warranty of
*	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*	GNU General Public License for more details.
*/
session_start();
session_name('metin2cms');
ob_start();

// @ignore
define('IN_INDEX', true);
$maintenance = false;

require_once 'inc/database.php';

require 'libs/Ip.php';
require 'libs/Error.php';

require 'inc/security.php';
require 'inc/functions.php';
require 'inc/pages.php';
require 'inc/data.php';

require_once 'inc/config.php';

if ($maintenance === true) {
	header('Location: ./mentenanta/');
	exit;
}
updateSession();
?>

<!DOCTYPE html>
<html lang="EN">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta charset="utf-8">
	<meta name="description" content="Metin2 private server">
	<meta name="author" content="MeClaud">
	<link rel="icon" href="http://gf1.geo.gfsrv.net/cdn98/191b803adbf82f4b8febe3a2c38c2c.ico">

	<title><?=$cfg['sitename']."&nbsp;-&nbsp;".$pages['title']; ?></title>

	<link href="css/yeti.css" rel="stylesheet">
	<link href="css/theme.css" rel="stylesheet">
	<link rel="stylesheet"  href="css/blog.css">
	<link rel="stylesheet"  href="css/font-awesome.css">
</head>
<body onload="ceas(); setInterval('ceas()', 1000 )">
	<div class="container-static">
	<div class="blog-masthead navbar-fixed-top">
		<div class="container" style="width=800px;">
			<div class="blog-nav">
				<a class="blog-nav-item <?=chkactive('home');?>" href="?page=home"><span class="glyphicon glyphicon-home"></span></a>
				<a class="blog-nav-item <?=chkactive('register');?>" href="?page=register">Inregistrare</a>
				<a class="blog-nav-item <?=chkactive('highscore');?>" href="?page=highscore">Clasament</a>
				<a class="blog-nav-item <?=chkactive('download');?>" href="?page=download">Descarcare</a>
				<a class="blog-nav-item" href="<?=$cfg['forum'];?>">Forum</a>
				<div class="pull-right">
					<div id="clockframe"><span id="clock">&nbsp;</span></div>
				</div>
			</div>
		</div>
	</div>
	<div id="header"></div>
	<div id="limitsh">
		<div class="sidebar-left">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<center>
						<h3 class="panel-title"><i class="fa fa-trophy"></i> Top <?=$cfg['toplimit']?> </h3>
					</center>
				</div>
				<div class="panel-body" style="margin:0; padding:2px;">
					<div class="topnav">
						<ul class="nav nav-pills" role="tablist">
							<li role="presentation"  class="active"><a href="#phighscore" aria-controls="home" role="tab" data-toggle="tab"><i class="fa fa-trophy"></i> Jucatori</a></li>
							<li role="presentation"><a href="#ghighscore" aria-controls="home" role="tab" data-toggle="tab"><span class="glyphicon glyphicon-tower"></span> Bresle</a></li>
						</ul>
					</div>
				</div>
				<div class="tab-content">
					<div class="tab-pane active" id="phighscore">
						<table class="table table-striped table-bordered highsc">
							<thead>
								<th>#</th>
								<th>Nume</th>
								<th>Nivel</th>
							</thead>
							<tbody>
								<?php
								$res= $sqlServ->Query("SELECT player.id,player.name,player.level,player.exp,player_index.empire,guild.name AS guild_name
									  FROM player.player
									  LEFT JOIN player.player_index
									  ON player_index.id=player.account_id
									  LEFT JOIN player.guild_member
									  ON guild_member.pid=player.id
									  LEFT JOIN player.guild
									  ON guild.id=guild_member.guild_id
									  INNER JOIN account.account
									  ON account.id=player.account_id
									  WHERE player.name NOT LIKE '[%]%' AND player.name NOT LIKE '.%#' AND player.name NOT LIKE '%[%]'  AND player.name NOT LIKE '[%]' AND account.status!='BLOCK'
									  ORDER BY player.level DESC, player.exp DESC
									  LIMIT ".$cfg['toplimit']);
								$i=0;
								while ($obj = mysqli_fetch_array($res)){
									$i=$i+1;
								?>
									<tr>
										<td><?=$i;?></td>
										<td><a href="?page=character&name=<?=$obj['name'];?>"><?=$obj['name'];?></a></td>
										<td><?=$obj['level'];?></td>
									</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
					<div class="tab-pane" id="ghighscore">
						<table class="table table-striped table-bordered highsc">
							<thead>
								<th>#</th>
								<th>Nume</th>
								<th>Regat</th>
							</thead>
							<tbody>
							<?php 
								$res  = $sqlServ->Query("SELECT id,name,master,ladder_point FROM player.guild LIMIT ".$cfg['toplimit']);$i=0;
								while ($obj = mysqli_fetch_array($res)){
									$i=$i+1;
							?>
									<tr>
										<td><?=$i;?></td>
										<td width="20px"><a href="?page=guild&gid=<?=$obj['id']?>"><?=$obj['name'];?></a></td>
									<?php
										$leader = $obj['master'];
										$res2 = $sqlServ->query("SELECT empire from player.player_index where pid1 = '$leader' OR pid2 = '$leader' OR pid3 = '$leader' OR pid4 = '$leader'");							
										$rowE = $res2->fetch_row();
										$empire = $rowE[0];
										echo"<td><img src=\"img/regat/$empire.jpg\"></td>";
									?>
									</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
				</div>
				<div class="panel-footer" style="border:none;">
					<center><a href="?page=highscore" class="btn btn-sm btn-default"> Clasament complet</a></center>
				</div>		
			</div>	
		</div>
		<div class="main">
			<?php
			if(isset($_SESSION['userid']) && getSet('notification_state') == 'true') {
				$notifs = $dbCon->query("SELECT * FROM `account`.`cms_notifications` WHERE (`read` = 'N' AND account_id = {$_SESSION['userid']})")->num_rows;
				if ($notifs == 1) {
					error('<i class="fa fa-bell"></i> Ai o notificare necitita.','info');
				} elseif ($notifs >= 2){
					error('<i class="fa fa-bell"></i> Ai '.$notifs.' notificari necitite.','info');
				}
			}
			?>	
			<?php require $pages['file']; ?>
		</div>
		<div class="sidebar">		
					<?php if(!isset($_SESSION['userid'])){ ?>
						<div class="panel panel-primary">
								<div class="panel-heading">
									<center><h3 class="panel-title"><span class="glyphicon glyphicon-user"></span> Autentificare</h3></center>
								</div>
						<div class="panel-body">	
							<form action="?page=login" method="POST" role="form">
								<div class="form-group">
									<input type="text" name="lusername" class="form-control" required="" placeholder="Utilizator" />
								</div>
								<div class="form-group">
									<input type="password" name="lpassword" class="form-control" required="" placeholder="Parola"/>
								</div>
								<div class="form-group">
										<div class="col-sm-offset-2 col-sm-10">
										  <input class="btn btn-default" name="loginbtn" id="loginbtn" type="submit" value="LogIn" />
										</div>
									  </div>
								
							</form>
						</div>
						</div>
					<?php } else { ?>
						<div class="list-group shadowed">
							<a class="list-group-item active">Bun venit, <strong><?php echo $_SESSION['user']; ?></strong>
								<p class="list-group-item-text" style="margin-top:4px; margin-bottom:4px;">Credit: <kbd><?= $_SESSION['usermd'];?> MD</kbd></p>
								<?php if(isset($_SESSION['useradmin']) && $_SESSION['useradmin'] > 0){?><p class="list-group-item-text">Grad: <kbd><?php echo $adminrank[$_SESSION['useradmin']]; ?></kbd></p> <?php } ?>
							</a>
							<?php if(getSet('notification_state') == 'true'){ ?><a class="list-group-item" href="?page=notifications"><i class="fa fa-bell"></i> Notificari <kbd class="pull-right"><?=@$notifs?></kbd></a><?php } ?>
							<a class="list-group-item" href="?page=logout"><i class="fa fa-sign-out"></i> Delogare</a>
							<a class="list-group-item" href="?page=account"><i class="fa fa-info-circle"></i> Informatii cont</a>
							<a class="list-group-item" href="?page=change_pass"><i class="fa fa-edit"></i> Schimba parola</a>
							<a class="list-group-item" href="?page=characters"><i class="fa fa-users"></i></span> Caracterele mele</a>
							<a class="list-group-item" href="?page=buymd"><i class="fa fa-cart-plus"></i> Adauga monede</a>
							<a class="list-group-item" href="ishop"><i class="fa fa-shopping-cart"></i> Magazin</a>
							<?php if(isset($_SESSION['useradmin']) && $_SESSION['useradmin'] > 0 ) { ?><a class="list-group-item" href="?page=admin_home"><i class="fa fa-cogs"></i> <b class="adminbut">Administrare</b></a> <?php } ?>
						</div>
					<?php } ?>
				
			
			<div class="panel panel-primary">
				<div class="panel-heading">
					<center><h3 class="panel-title"><span class="glyphicon glyphicon-stats"></span> Statistica</h3></center>
				</div>
				<div class="panel-body table-responsive">
					<table class="table">
						<tr>
							<td>Mod Joc: </td>
							<td><span class="badge"><?php getConfigValue('gamemode', $sqlServ)?></span></td>
						</tr>
						<tr>
							<td>Experienta: </td>
							<td><span class="badge"><?php getConfigValue('exprate', $sqlServ)?>%</span></td>
						</tr>
						<tr>
							<td>Yang: </td><td><span class="badge"><?php  getConfigValue('yangrate', $sqlServ)?>%</span></td>
						</tr>
						<tr>
							<td>Iteme: </td><td><span class="badge"><?php  getConfigValue('droprate', $sqlServ)?>%</span></td>
						</tr>

						<tr>
							<td style="color:green;">Online(5m): </td>
							<td><span class="badge">
									<?php
										((bool)mysqli_query($sqlServ, "USE player")); 
										$exe = mysqli_query($sqlServ, "SELECT COUNT(*) as count FROM player.player WHERE DATE_SUB(NOW(), INTERVAL 5 MINUTE) < last_play;"); 
										$player_online = mysqli_fetch_object($exe)->count;
										echo "<span class=\"badge\"><b>$player_online</b></span>"; 
									?>
								</span></td>
						</tr>

						<tr>
							<td style="color:green;">Online(24h): </td>
							<td><span class="badge">
									<?php
										((bool)mysqli_query($sqlServ, "USE player")); 
										$exe1 = mysqli_query($sqlServ, "SELECT COUNT(*) as count FROM player.player WHERE DATE_SUB(NOW(), INTERVAL 1440 MINUTE) < last_play;"); 
										$player_online1 = mysqli_fetch_object($exe1)->count;
										echo "<span class=\"badge\"><b>$player_online1</b></span>"; 
									?>
								</span></td>
						</tr>
					</table>
				</div>
			</div>
		</div>
	</div>
	<div class="copyright" >
			<div style="float:left;">Copyright &copy; <?=$cfg['sitename']." ".date('Y') ?>. Toate drepturile rezervate.</div>
			<div style="float:right;">Website creat de <a href="http://www.meclaud.cf/">MeClaud</a></div>
	</div>
	</div>
</body>
	<script src="js/jquery-2.0.3.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/npm.js"></script>
	<script src="js/jclock.js"></script>
</html>