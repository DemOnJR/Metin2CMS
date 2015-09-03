<?php 
//@ignore
if (!defined('IN_INDEX')) {
    exit();
}
if(isset($_SESSION['useradmin']) && $_SESSION['useradmin'] >= $minlevel['addmd']){ ?>
<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title"><?=$cfg['sitename']; ?> - Adaugare monede</h3>
	</div>
	<div class="panel-body">
	<p>Atentie! Noua suma va fi cea introdusa aici, adica daca bagati 0, contului i se vor modifica monedele in 0.</p>
		<?php
			$accid = isset($_GET['account']) ? $_GET['account'] : NULL;
			$account = is_null($accid) ? '' : mysqli_fetch_object($sqlServ->query("SELECT login FROM account.account WHERE id = ".$accid.""))->login;

		if (isset($_POST['adaugare'])){
			$accname = sanitize(stripInput($_POST['account']));
			$newmd = sanitize(stripInput($_POST['coins']));
			$captcha = sanitize(stripInput($_POST['captcha']));
			if ($_SESSION['captcha'] == $captcha) {
				if (empty($accname)) {
					gen_error('Campul Username nu poate fi gol');
				} elseif (!is_numeric($newmd)) {
					gen_error('Campul Valoare trebuie sa contina un numar');
				} else {
					$qry1 = $sqlServ->query("UPDATE account.account SET coins = ".$newmd." WHERE login = '".$accname."';");
					if ($qry1){
						gen_notif('Contului '.$accname.' i-au fost adaugate '.$newmd.' Monede dragon');
					} else {
						gen_error('Nu au putut fi adaugate monede');
					}
				}
			} else {
				gen_error('Codul captcha nu este valid.');
			}
		}
		?>
	<form action="?page=admin_addcoins" method="POST">
		<table class="table table-bordered">
			<tr>
				<td>Username</td>
				<td><input type="text" name="account" class="form-control" value="<?=$account?>"></td>
			</tr>
			<tr>
				<td>Valoare</td>
				<td><input type="text" name="coins" class="form-control"></td>
			</tr>
			<tr>
				<td><img src="libs/Captcha.php"></td>
				<td><input type="text" name="captcha" class="form-control"></td>
			</tr>
			<tr>
				<td colspan="2"><center><input type="submit" class="btn btn-m btn-info" value="Adaugare" name="adaugare" ></center></td>
			</tr>
		</table>
	</form>
	</div>
</div>
<?php 
} else {
	header('Location: ?page=home');
}
?>