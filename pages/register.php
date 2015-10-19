<?php
//@ignore
if (!defined('IN_INDEX')) {
    exit();
}

if (isset($_POST['register']) && $_POST['register'] == "Inregistrare") {
	if($register_on){
		$username = sanitize(stripInput($_POST['username']));
		$password = sanitize(stripInput($_POST['password']));
		$rpassword = sanitize(stripInput($_POST['rpassword']));
		$usermail = sanitize(stripInput($_POST['usermail']));
		$socialid = sanitize(stripInput($_POST['socialid']));
		$rlname = sanitize(stripInput($_POST['rlname']));
		$captcha = ($use_captcha === true) ? sanitize(stripInput($_POST['captcha'])) : null;

		if ($use_captcha === false || $captcha == $_SESSION['captcha']){
			$errors = 0;
			if (strlen($username) <= 7) {
				$errors++;
				error('Usernameul este prea scurt!');
			}
			if (strlen($password) <= 7) {
				$errors++;
				error('Parola este prea scurta!');
			}
			if (strlen($usermail) <= 4) {
				$errors++;
				error('Adresa de email este prea scurta!');
			}
			if (strlen($rlname) <= 2) {
				$errors++;
				error('Numele real este prea scurta!');
			}
			if (!isset($_POST['agreed'])) {
				$errors++;
				error('Trebuie sa fiti de acord cu regulamentul jocului!');
			}
			if (strlen($socialid) > 7) {
				$errors++;
				error('Codul de siguranta trebuie sa aiba cel mult 7 cifre');
			}
			if($errors == 0){
				if ($password == $rpassword) {
					
					$check_login = $sqlServ->query("SELECT * FROM account.account WHERE login = '{$username}'");
					$check_email = $sqlServ->query("SELECT * FROM account.account WHERE email = '{$usermail}'");

						if(mysqli_num_rows($check_login) >= 1) {
							error("Exista deja un cont cu acest username.");
						} else if(mysqli_num_rows($check_email) >= 1) {
							error("Acest e-mail este folosit");
						} else {
							if(filter_var($usermail, FILTER_VALIDATE_EMAIL)) {
								$query = "INSERT INTO account.account (login, password, real_name, social_id, email, create_time, safebox_expire, autoloot_expire, money_drop_rate_expire, coins) VALUES ('{$username}', PASSWORD('{$password}'), '{$rlname}', '{$socialid}', '{$usermail}', NOW(), '{$safebox_expire}', '{$autoloot_expire}', '{$money_drop_rate_expire}', {$starting_coins})";
									
									if ($sqlServ->query($query)) {
										error("Contul <strong>".$username."</strong> a fost inregistrat cu succes!", 'success');
									}  else { echo "noo!";}
											
							} else {
								error("Adresa de e-mail este invalida.");
							}
						}
				} else {
					error("Parolele introduse nu coincid.");
				}
			}
		} else {
			error("Codul captcha nu a fost introdus corect.");
		}
	}
}
?>
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title"><?php echo $cfg['sitename']; ?> - Inregistrare</h3>
			</div>
			<div class="panel-body">
			<?php if(!$register_on) {
				gen_error("Inregistrarea este dezactivata.");
			} elseif (isset($_SESSION['userid'])) {
				gen_error("Nu puteti accesa aceasta pagina cand sunteti autentificat!");
			}
			else{?>
			<div class="alert alert-warning" role="alert">
			Atentie! Toate campurile sunt obligatorii si trebuie completate.
			</div>
			<div class="alert alert-info" role="alert">
			Folositi o parola complexa. Nu raspundem de conturi furate.
			</div>
					<form method="POST" class="form-horizontal">
						<div class="form-group">
							<label class="col-sm-3 control-label">Nume de utilizator:</label>
							<div class="col-sm-9">
								<input type="text" class="form-control " name="username" required placeholder="A-Z a-z 0-9">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Parola:</label>
							<div class="col-sm-9">
								<input type="password" class="form-control " name="password" required placeholder="A-Z a-z 0-9">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Repetă parola:</label>
							<div class="col-sm-9">
								<input type="password" class="form-control " name="rpassword" required>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Adresa de e-mail:</label>
							<div class="col-sm-9">
								<input type="text" class="form-control " name="usermail" required>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Nume real:</label>
							<div class="col-sm-9">
								<input type="text" class="form-control " name="rlname" required placeholder="A-Z a-z 0-9">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Cod de securitate:</label>
							<div class="col-sm-9">
								<input type="number" class="form-control " name="socialid" required placeholder="7 cifre">
							</div>
						</div>
								<?php if($use_captcha === true){ ?>
									<div class="form-group">
										<label class="col-sm-3 control-label"><img src="libs/Captcha.php"></label>
										<div class="col-sm-9">
											<input type="number" class="form-control " name="captcha" required placeholder="Codul din imagine">
										</div>
									</div>
								<?php } ?>
								
						<div class="form-group">
							<label class="col-sm-5 control-label">Sunt de acord cu <a href="reguli.html">regulamentul jocului</a></label>
							<div class="col-sm-7">
								<input type="checkbox" class="form-control" name="agreed" required>
							</div>
						</div>
						<center><input type="submit" class="btn btn-s btn-primary" name="register" value="Inregistrare"></center>
					</form>
			<?php } ?>
		</div>
	</div>