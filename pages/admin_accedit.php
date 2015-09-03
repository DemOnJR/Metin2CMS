<?php
//@ignore
if (!defined('IN_INDEX')) {
    exit();
}
if(isset($_SESSION['useradmin']) && $_SESSION['useradmin'] >= $minlevel['accedit']){
if (isset($_POST['sendnotification']) && getSet('notification_state') == 'true') {
	$subject = filter_var($_POST['subject'], FILTER_SANITIZE_STRING);
	$message = filter_var($_POST['message'], FILTER_SANITIZE_STRING);
	$dest = filter_var($_POST['dest'],FILTER_SANITIZE_STRING);
	if (sendNotification($subject, $message, $dest) === true) {
		error('Notificare trimisa', 'success');
	} else {
		error('Notificarea nu a putut fi trimisa', 'warning', true, false);
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
<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title"><?=$cfg['sitename']; ?> - Editare cont</h3>
	</div>
	<div class="panel-body">
		<?php
			if (isset($_GET['username']) && !empty($_GET['username'])) {
				$id = mysqli_fetch_object($sqlServ->query("SELECT id FROM account.account WHERE login = '".$_GET['username']."'"))->id;
			} elseif(isset($_GET['id']) && !empty($_GET['id']) && is_numeric($_GET['id'])) {
				$id = $_GET['id'];	
			}
			if (isset($id)) {
				$qry1 = $sqlServ->query("SELECT * FROM account.account WHERE id = '".$id."'");
				$obj1 = mysqli_fetch_object($qry1);
				if ($_SESSION['useradmin'] >= $minlevel['ban']) {
					$action = isset($_GET['action']) ? $_GET['action'] : 'none';
					if ($action == 'ban') {
						$qry3 = $sqlServ->query("UPDATE account.account SET status = 'BLOCK' WHERE account.id = ".$obj1->id.";");
						if ($qry3) {
							gen_notif("Contul ".$obj1->login." a fost blocat.");
						}
					} elseif ($action == 'approve') {
						$qry3 = $sqlServ->query("UPDATE account.account SET status = 'OK' WHERE account.id = ".$obj1->id.";");
						if ($qry3) {
							gen_notif("Contul ".$obj1->login." a fost aprobat.");
						}
					} elseif ($action == 'unban') {
						$qry3 = $sqlServ->query("UPDATE account.account SET status = 'OK' WHERE account.id = ".$obj1->id.";");
						if ($qry3) {
							gen_notif("Contul ".$obj1->login." a fost deblocat.");
						}
					}
				}
		?>
		
		<?php if(getSet('notification_state') == 'true'){ ?>
		<div class="collapse" id="sendnotification">
			<div class="well">
				<form class="form-horizontal" method="POST">
					<div class="form-group">
						<label class="col-sm-2 control-label">Subiect</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" name="subject">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">Mesaj</label>
						<div class="col-sm-10">
							<textarea name="message"></textarea>
						</div>
					</div>
					<input type="hidden" name="dest" value="<?=$obj1->id?>">
					<center><button class="btn btn-xs btn-primary" name="sendnotification" type="submit"><i class="fa fa-send"></i> Trimitere</button></center>
				</form>
			</div>
		</div>
		<?php } ?>


		<table class="table table-bordered">
			<tr>
				<td style="width:150px;">Username</td>
				<td colspan="2"><?=$obj1->login?></td>
			</tr>
			<tr>
				<td>Email</td>
				<td colspan="2"><?=$obj1->email?></td>
			</tr>
			<tr>
				<td>IP</td>
				<td colspan="2"><?=$obj1->web_ip?></td>
			</tr>
			<tr>
				<td>Data inregistrarii</td>
				<td colspan="2"><?= $obj1->create_time ?></td>
			</tr>
		<?php if ($_SESSION['useradmin'] >= $minlevel['addmd']){ ?>
			<tr>
				<td>Monede dragon</td>
				<td><?=$obj1->coins?></td>
				<td style="width:50px;"><a href="?page=admin_addcoins&account=<?=$obj1->id?>" class="btn btn-success btn-xs">Adauga</a></td>
			</tr>
		<?php } 
			if($_SESSION['useradmin'] >= $minlevel['ban']){
		?>
			<tr>
				<td>Status</td>
				<td><?=$obj1->status?></td>
		<?php if ($obj1->status == 'OK'){?>
				<td><a href="?page=admin_accedit&id=<?=$id?>&action=ban" class="btn btn-danger btn-xs">Blocare</td>
		<?php } elseif($obj1->status == 'PENDING') {?>
				<td><a href="?page=admin_accedit&id=<?=$id?>&action=approve" class="btn btn-success btn-xs">Aprobare</td>
		<?php } else { ?>
				<td><a href="?page=admin_accedit&id=<?=$id?>&action=unban" class="btn btn-success btn-xs">Deblocare</td>
		<?php }	?>
			</tr>
		<?php } ?>
		</table>		
		<p>Caractere <?php if(getSet('notification_state') == 'true'){ ?><button style="margin:4px;" class="pull-right btn btn-xs btn-info" type="button" data-toggle="collapse" data-target="#sendnotification" aria-expanded="false" aria-controls="sendnotification"><i class="fa fa-envelope"></i></button><?php } ?></p>
		<table class="table table-bordered">
			<thead>
				<th>Nume</th>
				<th>Nivel</th>
				<th>Minute jucate</th>
				<th style="width:50px;">&nbsp;</th>
			</thead>
			<tbody>
		<?php
			$qry2 = $sqlServ->query("SELECT * FROM player.player WHERE account_id = '".$obj1->id."'");
			$num = mysqli_num_rows($qry2);
			if ($num > 0) {
				while ($obj2 = mysqli_fetch_object($qry2)){
		?>
			<tr>
				<td><?=$obj2->name?></td>
				<td><?=$obj2->level?></td>
				<td><?=$obj2->name?></td>
				<td><a href="?page=admin_charedit&id=<?=$obj2->id?>" class="btn btn-xs btn-success">EDIT</a></td>
			</tr>
		<?php }
			} else {
				echo "<td colspan=\"4\" style=\"text-align:center;\">Nu exista caractere pe acest cont</td>";
			}
		?>
			</tbody>
		</table>

		<?php
			} else {
				gen_error("Contul nu a fost gasit in baza de date.");
			}
			
		?>
	</div>
</div>
<?php 
} else {
	header('Location: ?page=home');
}
?>