<?php 
//@ignore
if (!defined('IN_INDEX')) {
    exit();
}
if(isset($_SESSION['useradmin']) && $_SESSION['useradmin'] >= $minlevel['downloads']){ ?>
<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title"><?=$cfg['sitename'];?> - Administrare pagina download</h3>
	</div>
	<div class="panel-body">
		<?php
		$date = date('Ymd');

			if (isset($_POST['addbtn']) && $_POST['addbtn'] == "Adauga") {

				$addDownload = $sqlServ->Query("INSERT INTO `account`.`cms_downloads` (`type`, `name`, `version`, `date`, `url`, `size`) VALUES ('".$_POST['type']."', '".$_POST['name']."', '".$_POST['version']."', ".$date.", '".$_POST['url']."', '".$_POST['size']."');");
			}
		?>
		<form action="?page=admin_downloads" method="POST" role="form">
			<div class="form-group input-group has-success">
				<span class="input-group-addon" name="tip">Tip</span>
				<select class="form-control" name="type">
					<option>-</option>
					<option>TORRENT</option>
					<option>DIRECT</option>
					<option>AUTOPATCHER</option>
				</select>
			</div>
			<div class="form-group input-group has-success">
				<span class="input-group-addon">Nume</span>
				<input type="text" name="name" class="form-control" required="" placeholder="Ex: Cient oficial" />
			</div>
			<div class="form-group input-group has-success">
				<span class="input-group-addon">Versiune</span>
				<input type="text" name="version" class="form-control" required="" placeholder="Ex: 1.0" />
			</div>
			<div class="form-group input-group has-success">
				<span class="input-group-addon">Marime</span>
				<input type="text" name="size" class="form-control" required="" placeholder="Ex: 1,1 GB" />
			</div>
			<div class="form-group input-group has-success" >
				<span class="input-group-addon">URL</span>
				<input type="text" name="url" class="form-control" required="" placeholder="Ex: http://www.exemplu.com"/>
			</div>
			<div class="form-group form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<input class="btn btn-default" name="addbtn" id="addbtn" type="submit" value="Adauga" />
			    </div>
			</div>			
		</form>
	</div>
</div>
<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title"><?=$cfg['sitename'];?> - Administrare pagina download</h3>
	</div>
	<div class="panel-body">
		<table class="table table-responsive">
			<thead>
				<tr>
					<th>#</th>
					<th>Nume</th>
					<th>Tip</th>
					<th>Versiune</th>
					<th>Marime</th>
					<th>URL</th>
					<th>Optiuni</th>
				</tr>
			</thead>
			<tbody>
			<?php 
				$getDownloads = $sqlServ->Query("SELECT * FROM account.cms_downloads") ;

				if (isset($_GET['delid']) && is_numeric($_GET['delid']) && !empty($_GET['delid'])){
			
						$delDownloads = $sqlServ->Query("DELETE FROM account.cms_downloads WHERE cms_downloads.id = ".$_GET['delid']."");
			
					if ($delDownloads) {
						gen_notif("Valoare stearsa cu succes!");
					} else {
						gen_error("A aparut o eroare.");
					}
				

				}
					while ($res = mysqli_fetch_array($getDownloads)) {
						
						echo "
								<tr>
									<td>".$res['id']."</td>
									<td>".$res['name']."</td>
									<td>".$res['type']."</td>
									<td>".$res['version']."</td>
									<td>".$res['size']."</td>
									<td><a href=\"".$res['url']."\">".$res['url']."</a></td>
									<td><a href=\"?page=admin_downloads&delid=".$res['id']."\"><span class=\"glyphicon glyphicon-remove\">&nbsp;</span></a></td>
								</tr>
							";
					}
			?>
			</tbody>
		</table>
	</div>
</div>
<?php 
} else {
	header('Location: ?page=home');
}
?>