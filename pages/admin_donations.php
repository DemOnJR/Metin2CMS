<?php 
//@ignore
if (!defined('IN_INDEX')) {
    exit();
}
if(isset($_SESSION['useradmin']) && $_SESSION['useradmin'] >= $minlevel['donations']){ ?>
<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title"><?=$cfg['sitename']; ?> - Administrare donatii</h3>
	</div>
	<div class="panel-body">
	<table class="table table-bordered table-striped">
		<thead>
			<th>ID</th>
			<th>Cont</th>
			<th>Cod</th>
			<th>Mentiuni</th>
			<th>Status</th>
			<th colspan="3">Optiuni</th>
		</thead>
		<tbody>
		<?php
			$qry = $sqlServ->query("SELECT * FROM account.cms_donations ORDER by id");
			while ($res = mysqli_fetch_array($qry)) {
		?>
			<tr class="info">
				<td><?=$res['id']?></td>
				<td><?=$res['account']?></td>
				<td><?=$res['code']?></td>
				<td><?=$res['mentiuni']?></td>
				<td><?=$res['status']?></td>
				<td><a href="?page=admin_donations&id=<?=$res['id']?>&action=approve&account=<?=$res['account']?>"><span class="glyphicon glyphicon-ok"></span></a></td>
				<td><a href="?page=admin_donations&id=<?=$res['id']?>&action=deny"><span class="glyphicon glyphicon-remove"></span></a></td>
				<td><a href="?page=admin_accedit&username=<?=$res['account']?>&action=ban"><span class="glyphicon glyphicon-lock"></span></a></td>
			</tr>
		<?php } ?>
		</tbody>
	</table>

	<?php
		if (isset($_POST['add'])) {
			$checkMD = mysqli_fetch_object($sqlServ->query("SELECT coins FROM account.account WHERE login = '".$_POST['cont']."'"))->coins;
			$newmd = $checkMD + $_POST['valoare'];
			$qryAdd = $sqlServ->query("UPDATE account.account SET coins = ".$newmd." WHERE login = '".$_POST['cont']."';");
			if ($qryAdd) {
				gen_notif("Monedele au fost adaugate.");
			} else {
				gen_error("Nu au putut fi adaugate monedele.");
			}
		}
		if (isset($_GET['id']) && is_numeric($_GET['id']) && !empty($_GET['id']) && isset($_GET['action']) && !empty($_GET['action'])) {
			if ($_GET['action'] == "approve") {
				$qryApprove = $sqlServ->query("UPDATE account.cms_donations SET status = 'OK' WHERE id = ".$_GET['id']."");
				if ($qryApprove) {
					gen_notif("Donatia a fost aprobata. Introduceti numarul de monede pe care le adaugati contului.");
					?>
					<p>Valoarea noua va fi valoarea_veche+valoarea_introdusa </p>
						<form action="?page=admin_donations" method="POST">
							<table class="table table-bordered">
								<tr>
									<td>Cont</td>
									<td><input type="text" name="cont" value="<?php echo $c = isset($_GET['account']) ? $_GET['account'] : ''; ?>" class="form-control"></td>
								</tr>
								<tr>
									<td>Valoare</td>
									<td><input type="text" name="valoare" class="form-control"></td>
								</tr>
								<tr>
									<td colspan="2"><input type="submit" name="add" class="form-control" value="Adaugare"></td>
								</tr>
							</table>
						</form>
					<?php
				} else {
					gen_error("A aparut o eroare.");
				}
			}
		}
	?>
	</div>
</div>
<?php 
} else {
	header('Location: ?page=home');
}
?>