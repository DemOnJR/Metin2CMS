<?php
	require 'inc/security.php';

	$p = (isset($_GET['p'])) ? sanitize($_GET['p']) : null;

	if (!is_null($p)) {
		
		require 'inc/database.php';
		require 'inc/data.php';
		require 'inc/config.php';
	
		
		$checkChar = mysqli_query($dbCon, "SELECT * FROM player.player WHERE name = '".$p."' LIMIT 1");
		$pinfo = mysqli_fetch_object($checkChar);

		$accid = mysqli_query($dbCon, "SELECT * FROM player.player WHERE id = ".$pinfo->account_id);
		$aid = mysqli_fetch_object($accid);

		$pid = $p;
		$getEmp = mysqli_query($dbCon, "SELECT empire FROM player.player_index WHERE pid1='$pid' or pid2='$pid' or pid3='$pid' or pid4='$pid'");
		$emp = mysqli_fetch_assoc($getEmp);

		$id_breasla_sql = mysqli_query($dbCon, "SELECT guild_id FROM player.guild_member WHERE pid='$pid'") OR $id_breasla = null;
		$id_breasla = mysqli_fetch_object($id_breasla_sql);

		if (!is_null($id_breasla)) {
			$nume_breasla = mysqli_fetch_object(mysqli_query($dbCon, "SELECT name FROM player.guild WHERE id='".$id_breasla->guild_id."'"));
			$breasla = $nume_breasla->name;
		} else {
			$breasla = " - ";
		}

		if (!$checkChar) {
			die("Caracterul nu exista");
		} else {

			Header('Content-Type: image/png');

			$font = 'fonts/Constantia.TTF';
			$logo = 'fonts/logo.TTF';
			$image = 'img/sig.PNG';
			$img = imagecreatefrompng($image);
			
			$reg = [
				1 => 'Rosu',
				2 => 'Galben',
				3 => 'Albastru'
			];
			$regColor = [
				1 => imagecolorallocate($img, 250, 0, 0),
				2 => imagecolorallocate($img, 250, 220, 0),
				3 => imagecolorallocate($img, 0, 0, 250)
			];
			
			

			$alb = imagecolorallocate($img, 255, 255, 255);
			$g = imagecolorallocate($img, 0, 100, 200);

			imagettftext($img, 10, 1, 20, 25, $alb, $font, $pinfo->name);
			imagettftext($img, 10, 1, 20, 52, $alb, $font, "Nivel: ".$pinfo->level);
			imagettftext($img, 10, 1, 20, 79, $alb, $font, "Timp jucat: ");
			imagettftext($img, 10, 1, 85, 79, $alb, $font, $pinfo->playtime);
			
			imagettftext($img, 10, 1, 140, 25, $alb, $font, "Regat: ");
			imagettftext($img, 10, 1, 180, 25, $regColor[$emp['empire']], $font, $reg[$emp['empire']]);
			imagettftext($img, 10, 1, 140, 52, $alb, $font, "Breasla: ");
			imagettftext($img, 10, 1, 190, 52, $alb, $font, $breasla);
			imagettftext($img, 10, 1, 140, 79, $alb, $font, "Yang: ".$pinfo->gold);

			imagettftext($img, 10, 1, 300, 25, $alb, $font, $rase[$pinfo->job]);
			imagettftext($img, 10, 0, 380, 85, $alb, $font, getset('svname'));



			imageinterlace($img);

			imagepng($img);
		}
	} 