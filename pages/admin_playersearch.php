<?php 
//@ignore
if (!defined('IN_INDEX')) {
    exit();
}
if(isset($_SESSION['useradmin']) && $_SESSION['useradmin'] >= $minlevel['psearch']){ ?>
<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title"><?=$cfg['sitename']; ?> - Cautare jucator</h3>
	</div>
	<div class="panel-body">
<?php
if(isset($_POST['Cauta'])){
	$char = $_POST['caracter'];
	if($char!=NULL){
		$qry = $sqlServ->Query("SELECT * from player.player where name like '%$char%'");	
		if(mysqli_num_rows($qry) == 0){
			echo gen_error("Caracterul nu exista");	
		} else { ?>
			<table class="table table-bordered">
				<thead>
					<th>ID cont</th>
					<th>Cont</th>
					<th>Nume</th>
					<th>Level</th>
					<th>Ip</td>
					<th>&nbsp;</th>
				</thead>
				<tbody>
		<?php
			while($caracter = mysqli_fetch_array($qry)){
				$account = mysqli_fetch_array($sqlServ->Query("Select * from account.account where id='".$caracter['account_id']."'"));
		?>
					<tr>
						<td><?=$caracter['account_id']?></td>
						<td><a href="?page=admin_accedit&id=<?=$caracter['account_id']?>"><?=$account['login']?></a></td>
						<td><?=$caracter['name']?></td>
						<td><?=$caracter['level']?></td>
						<td><?=$caracter['ip']?></a></td>
						<td><a href="?page=admin_charedit&id=<?=$caracter['id']?>">Editare</a></td>
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
					<td>Nume jucator</td>
					<td><input type="text" name="caracter" class="form-control"></td>
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