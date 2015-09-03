<?php 
//@ignore
if (!defined('IN_INDEX')) {
    exit();
}
if(isset($_SESSION['useradmin']) && $_SESSION['useradmin'] >= $minlevel['logs']){ 
if (isset($_POST['clear-logs'])) {
	confirm('Esti sigur ca doresti sa golesti logurile?','clear-logs-y');
}
if( isset($_POST['clear-logs-y'])){
	$qryEmptyLog = $dbCon->query("TRUNCATE `account`.`cms_log_ishop`;");
	if ($qryEmptyLog) {
		error('Ai sters toate logurile de la ishop', 'success');
	} else {
		error('A aparut o eroare','danger');
	}
	
}
?>
<div class="panel panel-primary">
	<div class="panel-heading">LOG cumparaturi ishop</div>
	<div class="panel-body">
		<div class="btn-group pull-right">
			<form method="POST">
				<button class="btn btn-danger btn-xs" title="Curata loguri" name="clear-logs"><i class="fa fa-trash"></i></button>
			</form>
		</div>
		<br>
		<br>
		<table class="table table-bordered">
			<thead>
				<th>#</th>
				<th>Cont</th>
				<th>Actiune</th>
				<th>Data</th>
				<th>IP</th>
			</thead>
			<tbody>
				<?php
				$qryGetLogs = $dbCon->query("SELECT * FROM account.cms_log_ishop");
				if($qryGetLogs->num_rows >= 1){
					$i = 1;
					while ($l = mysqli_fetch_object($qryGetLogs)){
				?>
					<tr>
						<td><?=$i++?></td>
						<td><a href="?page=admin_accedit&id=<?=$l->account?>"><?=$l->account?></a></td>
						<td><?=$l->action?></td>
						<td><?=$l->date?></td>
						<td><?=$l->ip?></td>
					</tr>
				<?php }} else { ?>
					<tr>
						<td colspan="5">Nu exista inregistrari</td>
					</tr>
				<?php }	?>
			</tbody>
		</table>
	</div>
</div>
<?php } ?>