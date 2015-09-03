<?php 
//@ignore
if (!defined('IN_INDEX')) {
    exit();
}
if(isset($_SESSION['useradmin']) && $_SESSION['useradmin'] >= $minlevel['accsearch']){ ?>
<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title"><?=$cfg['sitename']; ?> - Cautare cont</h3>
	</div>
	<div class="panel-body">
<?php
if(isset($_POST['Cauta'])){
	$acc = $_POST['account'];
	if($acc!=NULL){
		$qry = $sqlServ->Query("SELECT * from account.account where login like '%$acc%'");	
		if(mysqli_num_rows($qry) == 0){
			echo gen_error("Caracterul nu exista");	
		} else { ?>
			<table class="table table-bordered">
				<thead>
					<th>ID cont</th>
					<th>Username</th>
					<th>Email</th>
					<th>Status</th>
					<th>Ip</td>
					<th>&nbsp;</th>
				</thead>
				<tbody>
		<?php
			while($account = mysqli_fetch_array($qry)){
		?>
					<tr>
						<td><?=$account['id']?></td>
						<td><?=$account['login']?></td>
						<td><?=$account['email']?></td>
						<td><?=$account['status']?></td>
						<td><?=$account['web_ip']?></td>
						<td><a href="?page=admin_accedit&id=<?=$account['id']?>">Editare</a></td>
					</tr>
				<?php } ?>
				</tbody>
			</table>
<?php 	}
	}
}
?>
		<form method="POST">
			<table class="table table-bordered">
				<tr>
					<td>Nume cont</td>
					<td><input type="text" name="account" class="form-control"></td>
				</tr>
				<tr>
					<td colspan="2"><center><input type="submit" class="btn btn-success" name="Cauta" value="Cauta"></center></td>
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