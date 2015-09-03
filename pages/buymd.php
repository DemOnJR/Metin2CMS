<?php 
//@ignore
if (!defined('IN_INDEX')) {
    exit();
}
if(!isset($_SESSION['userid'])){header('Location: ?page=home');}else {?>
<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title"><?=$cfg['sitename']?> - Cumpara monede dragon</h3>
	</div>
	<div class="panel-body">
	<p>La mentiuni va rugam sa introduceti si valoarea codului!</p>
	<?php
		if (isset($_POST['submit'])) {
			$method = sanitize(stripInput($_POST['method']));
			$cod = $_POST['code'];
			$mentiuni = sanitize(stripInput($_POST['mentiuni']));
			$captcha = sanitize(stripInput($_POST['captcha']));
			if ($captcha == $_SESSION['captcha']) {
				if (strlen($cod) >= 14) {
					$qry = $sqlServ->query("INSERT INTO `account`.`cms_donations` (`account`, `code`, `status`, `mentiuni`) VALUES ('".$_SESSION['user']."', ".$cod.", 'PENDING', '".$mentiuni."')");
					if ($qry) {
						gen_notif("Codul a fost adaugat si va fi validat in maximum 24 de ore.");
					} else {
						gen_error("Codul nu a putut fi adaugat. Incercati mai tarziu sau contactati un administrator.");
					}
				} else {
						gen_error("Codul nu a putut fi adaugat. Incercati mai tarziu sau contactati un administrator.");
					}
			} else {
				gen_error("Codul captcha a fost introdus gresit.");
			}
		}
	?>
		<form method="POST" action="?page=buymd">
			<table class="table table-striped table-bordered">
				<tr>
					<td>Metoda:</td>
					<td>
						<select class="form-control" name="method">
						<?php
							foreach ($paymethod as $key => $keyv) {
								echo "<option value=\"".$key."\">".$keyv."</option>";
							}
						?>
						</select>
					</td>

				</tr>
				<tr>
					<td>Cod:</td>
					<td><input type="text" class="form-control" name="code" required></td>
				</tr>
				<tr>
					<td>Mentiuni</td>
					<td><textarea class="form-control" name="mentiuni" rows="5"></textarea></td>
				</tr>
				<tr>
					<td><img src="libs/Captcha.php"></td>
					<td><input type="text" name="captcha" class="form-control" required></td>
				</tr>
				<tr>
					<td colspan="2"><input type="submit" class="btn btn-success" name="submit" value="Trimitere"></td>
				</tr>
			</table>
		</form>	
	</div>
</div>
<?php } ?>