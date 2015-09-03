<?php
session_start();
ob_start();

require_once '../inc/database.php';

if (!isset($_SESSION['userid'])) {
	exit("Trebuie sa fiti logat pentru a putea cumpara iteme. <a href=\"../\">Inapoi pe site</a>");
}
require '../libs/Ip.php';
require '../libs/Error.php';

require '../inc/functions.php';


$cfg['sitename'] = getset('svname', $sqlServ);

$cat = (isset($_GET['cat'])) ? filter_var($_GET['cat'], FILTER_SANITIZE_STRING) : null;
updateSession();
?>
<!DOCTYPE html>
<html lang="en">
<head>

	<title>Magazin de iteme - <?=$cfg['sitename']?></title>
	<link rel="stylesheet" type="text/css" href="../css/yeti.css">
	<link rel="stylesheet" type="text/css" href="../css/ishop.css">
	<link rel="icon" href="http://gf1.geo.gfsrv.net/cdn98/191b803adbf82f4b8febe3a2c38c2c.ico">

</head>
<body>
	<div class="limits">
		<div class="col-sm-12">
			<div class="navbar navbar-inverse shadow">
			      <a class="navbar-brand" href="../"><?=$cfg['sitename']?></a>
			      <ul class="nav navbar-nav">
			        <li><a href="../">Inapoi pe site</a></li>
			      </ul>
			      <ul class="nav navbar-nav navbar-right" style="margin-right:0px;">
			      	<p class="navbar-text">Autentificat ca <?=$_SESSION['user']?></p>
			      	<li><a href="../?page=logout">Logout</a></li>
			      	<p class="navbar-text">MD: <?=$_SESSION['usermd']?></p>
			      </ul>
			</div>
		</div>
		<div class="col-md-3">
			<div class="list-group shadow">
			  <a href="./" class="list-group-item"><span class="glyphicon glyphicon-home"></span> Prima pagina</a>
			  <?php
			  	$getCatQry = $sqlServ->query("SELECT * FROM account.cms_is_cats");
			  	while ($cats = mysqli_fetch_object($getCatQry)){
			  ?>
			  	<a href="?page=show&cat=<?=$cats->id?>" class="list-group-item <?=chkactive($cats->id, 'cat')?>" style="font-weight:bold;"><?=$cats->nume?></a>
			  <?php } ?>
			</div>
		</div>
		<div class="col-md-9">
		<?php
			$page = (isset($_GET['page'])) ? filter_var($_GET['page'], FILTER_SANITIZE_STRING) : 'show';
			switch ($page) {
				case 'show':
					require 'views/show.php';
					break;
				case 'buy':
					require 'views/buy.php';
					break;
				default:
					require 'views/show.php';
					break;
			}
		?>
		</div>
	<div class="copyright" >
			<div style="float:left;">Copyright &copy; <?=$cfg['sitename']." ".date('Y') ?>. Toate drepturile rezervate.</div>
			<div style="float:right;">Website creat de <a href="http://www.meclaud.cf/">MeClaud</a></div>
	</div>
	</div>
	<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
	<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
	<script src="../js/bootstrap.min.js"></script>
	<script src="../js/npm.js"></script>
</body>
</html>