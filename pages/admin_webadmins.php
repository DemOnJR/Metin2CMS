<?php 
//@ignore
if (!defined('IN_INDEX')) {
    exit();
}
if(isset($_SESSION['useradmin']) && $_SESSION['useradmin'] >= $minlevel['webadmins']){ ?>
<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title"><?php echo $cfg['sitename']; ?> - Administratori site</h3>
	</div>
	<div class="panel-body">
	<p>Conturi care au drepturi administrative:</p>
	<table class="table table-bordered">
<?php
$qry1 = $sqlServ->Query("SELECT * FROM account.account WHERE web_admin > 0");
?>
		<thead>
			<th style="text-align: center;">Username</th>
			<th style="text-align: center;">Rang</th>
			<th colspan="2" style="text-align: center;">Optiuni</th>
		</thead>
		<tbody>
<?php
	while ($table = mysqli_fetch_array($qry1) ){
?>
		<tr>
			<td style="text-align: center;"><?=$table['login']?></td>
			<td style="text-align: center;"><?=$adminrank[$table['web_admin']]?></td>
			<td style="text-align: center;"><a href="?page=admin_webadmins&modifid=<?=$table['login']?>&modiflvl=<?=$table['web_admin']?>#edit"><span class="glyphicon glyphicon-pencil" alt="Editare"></span></a></td>
			<td style="text-align: center;"><a href="?page=admin_webadmins&delete=<?=$table['id']?>&username=<?=$table['login']?>"><span class="glyphicon glyphicon-remove" alt="Stergere"></span></a></td>
			
		</tr>
<?php
}
?>
		</tbody>
	</table>
<?php
if (isset($_POST['adaugare']) && $_POST['adaugare'] == "Trimite") {
	if (strlen($_POST['username']) < 3) {
		gen_error('Numele contului trebuie sa aiba cel putin 3 caractere.');
	} else {
		$qry2 = $sqlServ->Query("UPDATE account.account SET web_admin = '".$_POST['nivel']."' WHERE account.login = '".$_POST['username']."';");
		if ($qry2) {
			error("Contului ".$_POST['username']." i-au fost adaugate drepturile de ".$adminrank[$_POST['nivel']], 'success');
		}
	}
} elseif (isset($_GET['delete']) && isset($_GET['username'])&& is_numeric($_GET['delete']) && !empty($_GET['delete']) && !empty($_GET['username'])) {
	$qry3 = $sqlServ->Query("UPDATE account.account SET web_admin = '0' WHERE account.id='".$_GET['delete']."'");
	if ($qry3) {
		gen_notif('Contului '.$_GET['username'].' i-au fost scoase drepturile de administrator pe site.');
	}
}
	$username = isset($_GET['modifid']) ? $_GET['modifid'] : '';
?>
	<p>Adaugare drepturi:</p>
	<form action="?page=admin_webadmins" id="edit" method="POST">
		<table class="table table-responsive">
			<tr>
				<td>Username</td>
				<td><input type="text" name="username" class="form-control" value="<?=$username?>"></td>
			</tr>
			<tr>
				<td>Rang</td>
				<td>
					<select name="nivel" class="form-control">
				       <?php foreach($adminrank AS $gKey => $gValue) {
				          echo'<option value="'.$gKey.'">'.$gValue.'</option>';
				        } ?>
					</select>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<center><input type="submit" name="adaugare" class="btn btn-success" value="Trimite"></center>
				</td>
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