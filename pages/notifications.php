<?php
// @ignore
if (!defined('IN_INDEX')) {exit();}

if (isset($_SESSION['userid'])) {
if (getSet('notification_state') == 'true') {
mysqli_select_db($dbCon, 'account');
if (isset($_POST['delete'])) {
	$id = filter_var($_POST['id'], FILTER_SANITIZE_STRING);
	if(deleteNotification($id)){
		error('Notificarea a fost stearsa','success');
	} else {
		error('A aparut o eroare','danger',true,false);
	}
}
?>
	<div class="panel panel-primary">
		<div class="panel-heading"><h3 class="panel-title"><?=$cfg['sitename']?> - Notificari</h3></div>
		<div class="panel-body">
			<?php
				if (isset($_POST['mark'])) {
					$id = filter_var($_POST['id'], FILTER_SANITIZE_STRING);
					$qryMarkNotif = $dbCon->query("UPDATE `cms_notifications` SET `read` = 'Y' WHERE `id` = {$id}");
					if ($qryMarkNotif) {
						error('Marcat ca citit!','success');
					} else {
						error('A aparut o eroare', 'danger',true,false);
					}
				}

				$qryGetNotifs = $dbCon->query("SELECT * FROM `cms_notifications` WHERE `account_id` = {$_SESSION['userid']} ORDER BY date DESC");
				if ($qryGetNotifs->num_rows == 0) {
					error('Nu ai notificari primite.','info',false);
				} else {
					
					while($n = mysqli_fetch_object($qryGetNotifs)){
						if ($n->read == 'N') {
							echo'<form method="POST"><legend class="legend">'.$n->subject.'<input type="hidden" name="id" value="'.$n->id.'"><button class="pull-right btn btn-xs btn-info" name="mark" type="submit"><i class="fa fa-check"></i></button> <button class="pull-right btn btn-xs btn-danger" name="delete" type="submit" alt="Stergere"><i class="fa fa-remove"></i></button></form>';
						} else {
							echo '<form method="POST"><legend class="legend">'.$n->subject.'<input type="hidden" name="id" value="'.$n->id.'"><button class="pull-right btn btn-xs btn-danger" name="delete" type="submit" alt="Stergere"><i class="fa fa-remove"></i></button></form>';
						}
						echo '</legend>';
						echo '<div class="well">';
						echo $n->message;

						echo '<div class="notif-date">'.$n->date.'</div></div>';
					}
					
				} 
			?>
		</div>
	</div>
<?php } else {
	error('Sistemul este oprit!','danger',true,false);
} }?>