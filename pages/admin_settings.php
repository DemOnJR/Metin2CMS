<?php 
//@ignore
if (!defined('IN_INDEX')) {
    exit();
}

if (isset($_SESSION['useradmin']) && $_SESSION['useradmin'] >= $minlevel['hpsett']) {	?>
<div class="panel panel-primary">
	<div class="panel-heading"><?=$cfg['sitename']?> - Setari website</div>
	<div class="panel-body">
		<?php
		if (isset($_POST['submit'])){

			$gamemode = filter_var($_POST['gamemode'], FILTER_SANITIZE_STRING);
			$exprate = filter_var($_POST['exprate'], FILTER_SANITIZE_STRING);
			$droprate = filter_var($_POST['droprate'], FILTER_SANITIZE_STRING);
			$yangrate = filter_var($_POST['yangrate'], FILTER_SANITIZE_STRING);
			$svname = filter_var($_POST['svname'], FILTER_SANITIZE_STRING);
			$forumurl = filter_var($_POST['forumurl'], FILTER_SANITIZE_STRING);
			$register = filter_var($_POST['register-on'], FILTER_SANITIZE_STRING);
			$captcha = filter_var($_POST['captcha'], FILTER_SANITIZE_STRING);
			$notifstate = filter_var($_POST['notifs'], FILTER_SANITIZE_STRING);

			$qry = array();

			$qry[] = $sqlServ->query("UPDATE account.cms_settings SET value = '".$gamemode."' WHERE  name = 'gamemode';");
			$qry[] = $sqlServ->query("UPDATE account.cms_settings SET value = '".$yangrate."' WHERE  name = 'yangrate';");
			$qry[] = $sqlServ->query("UPDATE account.cms_settings SET value = '".$droprate."' WHERE  name = 'droprate';");
			$qry[] = $sqlServ->query("UPDATE account.cms_settings SET value = '".$exprate ."' WHERE  name = 'exprate';");
			$qry[] = $sqlServ->query("UPDATE account.cms_settings SET value = '".$svname ."' WHERE  name = 'svname';");
			$qry[] = $sqlServ->query("UPDATE account.cms_settings SET value = '".$forumurl ."' WHERE  name = 'forum-url';");
			$qry[] = $sqlServ->query("UPDATE account.cms_settings SET value = '".$register ."' WHERE  name = 'register_on';");
			$qry[] = $sqlServ->query("UPDATE account.cms_settings SET value = '".$captcha ."' WHERE  name = 'captcha';");
			$qry[] = $sqlServ->query("UPDATE account.cms_settings SET value = '".$notifstate ."' WHERE  name = 'notification_state';");

			if ($qry) {
				error('Modificarile au fost salvate', 'success');
			} else {
				error('Modificarile nu au putut fi salvate', 'danger');
			}
		}
		?>
		<form method="POST" action="?page=admin_settings">
			<table class="table table-bordered">
				<tr>
					<td colspan="2"><center><i style="color:magenta; font-size:16px;" class="fa fa-info-circle"></i> Detalii server</center></td>
				</tr>
				<tr>
					<td>Nume server</td>
					<td><input type="text" name="svname" value="<?php getConfigValue('svname', $sqlServ)?>" class="form-control" /></td>
				</tr>
				<tr>
					<td>Adresa forum</td>
					<td><input type="text" name="forumurl" value="<?php getConfigValue('forum-url', $sqlServ)?>" class="form-control" /></td>
				</tr>
				<tr>
					<td>Mod de joc</td>
					<td><input type="text" name="gamemode" value="<?php getConfigValue('gamemode', $sqlServ)?>" class="form-control" /></td>
				</tr>
				<tr>
					<td>Rata experienta</td>
					<td><input type="text" name="exprate" value="<?php getConfigValue('exprate', $sqlServ)?>" class="form-control" /></td>
				</tr>
				<tr>
					<td>Rata yang</td>
					<td><input type="text" name="yangrate" value="<?php getConfigValue('yangrate', $sqlServ)?>" class="form-control" /></td>
				</tr>
				<tr>
					<td>Rata drop</td>
					<td><input type="text" name="droprate" value="<?php getConfigValue('droprate', $sqlServ)?>" class="form-control" /></td>
				</tr>
				<tr>
					<td colspan="2"><center><i style="color:blue; font-size:16px;" class="fa fa-cog"></i> Setari website</center></td>
				</tr>
				<tr>
					<td>Inregistrare activa</td>
					<td><?=select(getset('register_on'),'register-on')?></td>
				</tr>
				<tr>
					<td>Foloseste captcha la inregistrare</td>
					<td><?=select(getset('captcha'),'captcha')?></td>
				</tr>
				<tr>
					<td>Sistem notificatii</td>
					<td><?=select(getset('notification_state'),'notifs')?></td>
				</tr>
				
			</table>
					<center><button type="submit" name="submit" class="btn btn-success"><i class="fa fa-save"></i> Salvare</button></center>
				
		</form>
	</div>
</div>
<?php } else {
	header('Location: ?page=home');
}?>