<?php 
//@ignore
if (!defined('IN_INDEX')) {
    exit();
}
if(isset($_SESSION['useradmin']) && $_SESSION['useradmin'] >= $minlevel['ishopadmin']){ ?>
<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title"><?=$cfg['sitename'];?> - Administrare categorii ishop</h3>
	</div>
	<div class="panel-body">
		<table class="table table-bordered">
			<thead>
				<th>ID</th>
				<th>Nume</th>
			</thead>
			<tbody>
			<?php
				$getCats = $sqlServ->query("SELECT * FROM account.cms_is_cats");
				while ($cat = mysqli_fetch_object($getCats)) {
			?>
				<tr>
					<td><?=$cat->id?></td>
					<td><?=$cat->nume?></td>
				</tr>
			<?php
				}
			?>
			</tbody>
		</table>
		<p>Adaugare categorii</p>
		<?php
			if (isset($_POST['addcat'])){
				$catname = filter_var($_POST['catname'], FILTER_SANITIZE_STRING);
				$qryAddCat = $sqlServ->query("INSERT INTO account.cms_is_cats (`nume`) VALUES ('".$catname."');");
				if ($qryAddCat) {
					error("Categoria $catname a fost adaugata", 'success');
				} else {
					error("A aparut o eroare si nu a outut fi adaugata categoria");
				}
				
			}
		?>
		<form method="POST" action="?page=admin_ishop_cat">
			<table class="table" style="margin-right:0;">
				<tr>
					<td>Nume:</td>
					<td><input type="text" name="catname" class="form-control" /></td>
				</tr>
				<tr>
					<td colspan="2"><input type="submit" name="addcat" class="btn btn-primary" value="Adaugare"></td>
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