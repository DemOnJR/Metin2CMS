<?php 
//@ignore
if (!defined('IN_INDEX')) {
    exit();
}
if(isset($_SESSION['useradmin']) && $_SESSION['useradmin'] >= $minlevel['ishopadmin']){ 

//Delete item
if (isset($_POST['validate-da'])) {
	$qryDelete = $sqlServ->query("DELETE FROM `account`.`cms_is_items` WHERE  `id`= ".$_POST['itemid'].";");
	if ($qryDelete) {
		error("Itemul a fost sters", 'success');
	} else {
		error("Itemul nu a putut fi sters");
	}
} elseif (isset($_POST['validate-nu'])) {}
if (isset($_GET['deleteid']) && is_numeric($_GET['deleteid'])) {

?>
<div class="panel panel-default shadow gtg">
	<div class="panel-body">
		<center>
			<form action="?page=admin_ishop_items" method="POST">
				<p>Esti sigur ca vrei sa stergi acest item?</p>
				<input type="hidden" name="itemid" value="<?=$_GET['deleteid']?>">
				<input type="submit" name="validate-nu" class="btn btn-danger" value="NU">
				<input type="submit" name="validate-da" class="btn btn-success" value="DA">
			</form>
		</center>
	</div>
</div>
<?php
}
?>

<div class="panel panel-primary gtg">
	<div class="panel-heading">Adaugare item:</div>	
	<div class="panel-body">
		<?php
			if (isset($_POST['adaugare'])) {
				$vnum = filter_var($_POST['vnum'], FILTER_SANITIZE_STRING);
				$nume = filter_var($_POST['nume'], FILTER_SANITIZE_STRING);
				$pret = filter_var($_POST['pret'], FILTER_SANITIZE_STRING);

				$qryAdd = $sqlServ->query("INSERT INTO `account`.`cms_is_items` (`nume`, `desc`, `vnum`, `price`, `catid`) VALUES ('".$nume."', '".$_POST['descriere']."', $vnum, $pret, ".$_POST['categorie'].");");
				if ($qryAdd) {
					error("Success, itemul a fost adaugat", 'success');
				} else {
					error("Eroare: nu a putut fi adaugat itemul");
				}
			}
		?>
		<form action="?page=admin_ishop_items" method="POST">
			<table class="table table-bordered">
				<tr>
					<td>Vnum</td>
					<td><input type="text" class="form-control" name="vnum"></td>
				</tr>
				<tr>
					<td>Nume</td>
					<td><input type="text" class="form-control" name="nume"></td>
				</tr>
					<script type="text/javascript" src="plugins/tiny_mce/tiny_mce.js"></script>
					<script type="text/javascript">
						tinyMCE.init({
							mode : "textareas",
							theme : "advanced",
							plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave,visualblocks",
									theme_advanced_buttons1 : "code,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,bullist,numlist,|,outdent,indent,blockquote,|,image,|,undo,redo,visualblocks",
							theme_advanced_buttons2 : "styleselect,formatselect,fontselect,fontsizeselect,|,preview",
							theme_advanced_toolbar_location : "top",
							theme_advanced_toolbar_align : "left",
							theme_advanced_statusbar_location : "bottom",
							theme_advanced_resizing : true,
					
							// Drop lists for link/image/media/template dialogs
							template_external_list_url : "lists/template_list.js",
							external_link_list_url : "lists/link_list.js",
							external_image_list_url : "lists/image_list.js",
							media_external_list_url : "lists/media_list.js",
							// Style formats
							style_formats : [
								{title : 'Bold text', inline : 'b'},
								{title : 'Red text', inline : 'span', styles : {color : '#ff0000'}},
								{title : 'Red header', block : 'h1', styles : {color : '#ff0000'}},
								{title : 'Example 1', inline : 'span', classes : 'example1'},
								{title : 'Example 2', inline : 'span', classes : 'example2'},
								{title : 'Table styles'},
								{title : 'Table row 1', selector : 'tr', classes : 'tablerow1'}
							],
							// Replace values for the template plugin
							template_replace_values : {
								username : "Some User",
								staffid : "991234"
							}
						});
					</script>
					<!-- /TinyMCE -->
				<tr>
					<td>Descriere</td>
					<td><textarea name="descriere" cols="70"></textarea></td>
				</tr>
				<tr>
					<td>Pret</td>
					<td><input type="text" class="form-control" name="pret"></td>
				</tr>
				<tr>
					<td>Categorie</td>
					<td>
						<select name="categorie" class="form-control">
							<?php
								$getCatQry = $sqlServ->query("SELECT * FROM account.cms_is_cats");
								
								while ($row = mysqli_fetch_object($getCatQry)) {	
							?>
								<option value="<?=$row->id?>"><?=$row->nume?></option>
							<?php
								}
							?>
						</select>
					</td>
				</tr>
				<tr><td colspan="2"><input type="submit" name="adaugare" value="Adaugare" class="btn btn-primary btn-s"></td></tr>
			</table>
		</form>
	</div>
</div>


<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title"><?=$cfg['sitename'];?> - Administrare iteme ishop</h3>
	</div>
	<div class="panel-body">
	<table class="table table-bordered" style="text-align:center;">
			<thead>
				<th  style="text-align:center;">#</th>
				<th style="text-align:center;">Nume</th>
				<th style="text-align:center;">Cod</th>
				<th style="text-align:center;">Descriere</th>
				<th style="text-align:center;">Pret</th>
				<th style="text-align:center;">Imagine</th>
				<th style="text-align:center;">Categorie</th>
				<th></th>
			</thead>
			<tbody>
			<?php
				function getCatName($sqlServ, $catid){
					return mysqli_fetch_object($sqlServ->query("SELECT * FROM account.cms_is_cats WHERE id = ".$catid.""))->nume;
				}

				$getItems = $sqlServ->query("SELECT * FROM account.cms_is_items");
				$i=0;
				while ($itm = mysqli_fetch_object($getItems)){
					$i++;
			?>
				<tr>
					<td><?=$i?></td>
					<td><?=$itm->nume?></td>
					<td><?=$itm->vnum?></td>
					<td><?=textcut($itm->desc, 10)?></td>
					<td><?=$itm->price?></td>
					<td>
						<?php if (file_exists('ishop/item/'.$itm->vnum.'.png')){ ?>
							<img src="ishop/item/<?=$itm->vnum?>.png">
						<?php } else { ?>
							<img src="ishop/item/default.jpg" width="32px">
						<?php } ?>
					</td>
					<td><?=getCatName($sqlServ, $itm->catid)?></td>
					<td><a href="?page=admin_ishop_items&deleteid=<?=$itm->id?>" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></a></td>
				</tr>
			<?php } ?>
			</tbody>
		</table>
	</div>
</div>
<?php 
} else {
	header('Location: ?page=home');
}
?>