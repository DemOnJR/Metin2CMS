<?php 
//@ignore
if (!defined('IN_INDEX')) {
    exit();
}
if(isset($_SESSION['useradmin']) && $_SESSION['useradmin'] >= $minlevel['news']){?>
<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title"><?=$cfg['sitename']; ?> - Stiri si evenimente</h3>
	</div>
	<div class="panel-body">
	<?php
		if (isset($_POST['submit']) && $_POST['submit'] == "Adaugare" || isset($_POST['edit'])) {

			$titlu = filter_var($_POST['titlu'], FILTER_SANITIZE_STRING);
			$autor = filter_var($_POST['autor'], FILTER_SANITIZE_STRING);
			$continut = stripInput($_POST['continut']);

						
			if(isset($_POST['edit']) ){
				$qryUpdateNews = $sqlServ->query("UPDATE account.cms_news SET titlu = '{$titlu}', autor = '{$autor}', data='{$_POST['data']}', continut='{$continut}' WHERE id = {$_GET['postid']}");
				if ($qryUpdateNews) {
					error('Stirea a fost modificata.', 'success');
				} else {
					error('Stirea nu a putut fi modificata.');
				}
			}else{
				$newsAddQry = $sqlServ->Query("INSERT INTO account.cms_news (`titlu`, `autor`, `data`, `continut`) VALUES ('".$titlu."', '".$autor."', '".$_POST['data']."', '".$continut."');");
				if ($newsAddQry) {
					error('Stirea a fost adaugata.', 'success');
				} else {
					error('Stirea nu a putut fi adaugata.');
				}
			}
		}

	?>
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
	<form method="POST">
		<table class="table table-bordered">
		<?php
			$edit_title = '';
			$edit_content = '';
			$edit_author = '';
			$edit_date = date('Y-m-d H:i:s');
			if (isset($_GET['a']) && $_GET['a'] = 'edit' && isset($_GET['postid']) && !empty($_GET['postid'])) {
				$postid = filter_var($_GET['postid'], FILTER_SANITIZE_STRING);
				$qryCheckNews = $sqlServ->query("SELECT * FROM account.cms_news WHERE id = {$postid}");
				if (mysqli_num_rows($qryCheckNews) >= 1) {
					$news_info = mysqli_fetch_object($qryCheckNews);
					$edit_title = $news_info->titlu;
					$edit_content = $news_info->continut;
					$edit_author = $news_info->autor;
					$edit_date = $news_info->data;
				}
			}

		?>
			<tr>
				<td>Titlu</td>
				<td><input type="text" class="form-control" name="titlu"  value="<?=$edit_title?>" required></td>
			</tr>
			<tr>
				<td>Continut</td>
				<td><textarea cols="70" class="form-control" name="continut"><?=$edit_content?></textarea></td>
			</tr>
			<tr>
				<td>Autor</td>
				<td><input type="text" class="form-control" value="<?=$edit_author?>" name="autor" placeholder="Ex: [GF]x"></td>
			</tr>
			<tr>
				<td>Data</td>
				<td><input type="text" class="form-control"  name="data" value="<?=$edit_date?>"></td>
			</tr>
			<tr>
				<td colspan="2">
					<center>
						<?php if(empty($edit_title)){ ?>
							<input type="submit" name="submit" value="Adaugare" class="btn btn-success">
						<?php } else { ?>
							<input type="submit" name="edit" value="Update" class="btn btn-success">
						<?php } ?>
					</center>
				</td>
			</tr>
		</table>
	</form>
	</div>
</div>
<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title"><?=$cfg['sitename']; ?> - Stiri si evenimente</h3>
	</div>
	<div class="panel-body">
		<table class="table table-bordered">
			<thead>
				<th>ID</th>
				<th>Titlu</th>
				<th>Continut</th>
				<th>Autor</th>
				<th>Optiuni</td>
			</thead>
			<tbody>
			<?php
			if (isset($_POST['delete'])) {
				$deleteQry = $sqlServ->Query("DELETE FROM account.cms_news WHERE cms_news.id = ".$_POST['delid']."");
				if ($deleteQry) {
					error("Stergerea s-a efectuat cu succes.", 'success');
				} else {
					error("A aparut o eroare si nu s-a putut efectua stergerea.");
				}
			}
			$qryNews = $sqlServ->Query("SELECT * FROM account.cms_news");
			while ($news = mysqli_fetch_array($qryNews)){
			?>
				<tr>
					<td><?=$news['id']?></td>
					<td><?=$news['titlu']?></td>
					<td><?php echo textcut($news['continut'], 25); ?></td>
					<td><?=$news['autor']?></td>
					<td>
						<form method="POST">
							<input type="hidden" value="<?=$news['id']?>" name="delid">
							<button class="btn btn-xs btn-danger" type="submit" name="delete"><i class="fa fa-times"></i></button>
							<a href="?page=admin_news&a=edit&postid=<?=$news['id']?>" class="btn btn-info btn-xs"><i class="fa fa-edit"></i></a>
						</form>
					</td>
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