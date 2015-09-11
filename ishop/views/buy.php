<?php if (!isset($_SESSION['userid']) || empty($_SESSION['userid']) || !isset($_GET['page']) || empty($_GET['page'])) { exit(); } else { ?>
<div class="panel panel-default shadow">
	<div class="panel-heading">Cumpara</div>
	<div class="panel-body">
		<?php
			$error = 0;
			if (isset($_GET['buy'])){
				$item = filter_var($_GET['buy'], FILTER_SANITIZE_STRING);

				$getItemInfoQry = $sqlServ->query("SELECT * FROM account.cms_is_items WHERE vnum = $item");
				$getItemInfo = mysqli_fetch_object($getItemInfoQry);

				if (mysqli_num_rows($getItemInfoQry) >= 1){
					if (isset($_POST['buy'])) {
						$vnum = filter_var($_POST['vnum'], FILTER_SANITIZE_STRING);
						if (isset($_SESSION['usermd']) && $_SESSION['usermd'] >= $getItemInfo->price) {
							$newMD = $_SESSION['usermd'] - $getItemInfo->price;
							$updateMD = $sqlServ->query("UPDATE `account`.`account` SET `coins`=$newMD WHERE  `id`=".$_SESSION['userid']."");
							if ($updateMD) {
								$belPos = checkPos($_SESSION['userid']);
								$possiblePos = findPos($belPos['islager'], 1);
								if (!empty($possiblePos)) {
									$addItem = $sqlServ->query("INSERT INTO player.item SET owner_id = '".$_SESSION['userid']."', window = 'MALL', pos = '".$possiblePos[0]."', count = '1', vnum = '".$getItemInfo->vnum."'");
									ishopLog($_SESSION['userid'], 'A cumparat '.$getItemInfo->nume.'['.$getItemInfo->id.']');
									if (!$addItem) die(mysqli_error());
									if ($addItem) {
										error('Succes, ai cumparat '.$getItemInfo->nume,'success');
									} else {
										error('A aparut o eroare si nu a putut fi cumparat itemul, ia legatura cu un administrator!');
									}
									
								} else {
									error('Depozitul tau este plin.');
								}

							}
						} else {
							error('Nu detineti suficiente monede pentru a cumpara itemul');
						}
					}
			?>
		<form method="POST" action="?page=buy&buy=<?=$getItemInfo->vnum?>">
			<div class="panel panel-primary">
				<div class="panel-heading"><?=$getItemInfo->nume?></div>
				<table class="table">
						<tr><td rowspan="3" class="col-md-1"><img src="item/<?=$getItemInfo->vnum?>.png"></td></tr>
						<tr><td><?=$getItemInfo->desc?></td></tr>
						<tr><td>Pret: <?=$getItemInfo->price?>MD </td></tr>
				</table>
			</div>
			<a href="?page=show" class="btn btn-warning" style="float:left;">Renunta</a>
			
			<?php
			if (isset($_SESSION['usermd']) && $_SESSION['usermd'] >= $getItemInfo->price) {
			?>
				<input type="hidden" name="vnum" value="<?=$getItemInfo->vnum?>">
				<input type="submit" name="buy" class="btn btn-success" style="float:right;" value="Cumpara" />
			<?php
			} else {
				echo '<font style="float:right;">Nu detineti suficiente monede pentru a cumpara itemul.</font>';
			}
			?>
		</form>

		<?php
			} else {
				$error = 1;
			}
		}else{
			$error = 1;
		}
			if ($error) {
				error('Nici un item selectat. <a href="?page=show">Inapoi la prima pagina</a>');
			}
		?>
	</div>
</div>
<?php } ?>