<?php 
//@ignore
if (!defined('IN_INDEX')) {
    exit();
}
if(!isset($_SESSION['userid'])){header('Location: ?page=home');}else {
if (isset($_POST['submit']) && $_POST['submit'] == "Actualizare") {
	$oldpass 	=	sanitize($_POST['oldpass']);
	$newpass 	=	sanitize($_POST['newpass']);
	$newpassr 	=	sanitize($_POST['newpassr']);
	if (strlen($newpass) < 7 || empty($oldpass) || empty($newpass)) {
		gen_error("Parola noua trebuie sa aiba minimum 7 caractere.");
	}elseif(!($newpass == $newpassr)) {
		gen_error("Parolele nu corespund.");
	}else{
		$check = "SELECT id,login FROM account.account WHERE password=PASSWORD('".$oldpass."') AND id='".$_SESSION['userid']."' LIMIT 1";
        $checksql = mysqli_query($sqlServ, $check);

        if(mysqli_num_rows($checksql) > 0) {

			$change = "UPDATE account.account SET password=PASSWORD('".$newpass."') WHERE id='".$_SESSION['userid']."' LIMIT 1;";
			$changesql = mysqli_query($sqlServ, $change);

			if ($changesql) {
				gen_notif("Parola a fost schimbata.");
			} else {
				gen_error("A aparut o eroare si nu s-a putut actualiza parola. Va rugam incercati mai tarziu.");
			}

        } else {
        	gen_error("Parola introdusa nu este corecta.");
        }
	}
}
?>
<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title"><?php echo $cfg['sitename']; ?> - Actualizare informatii cont</h3>
	</div>
	<div class="panel-body">
	<!-- Pass change start here -->
	<form action="#" method="POST">
		<div class="table table-responsive">
			<table class="table table-bordered">
				<tr>
					<td>Parola veche</td>
					<td><input type="password" name="oldpass" id="password" class="form-control smallbar marginbar" required="" placeholder="A-Z a-z 0-9"/></td>
				</tr>
				<tr>
					<td>Parola noua</td>
					<td><input type="password" name="newpass" id="password" class="form-control smallbar marginbar" required="" placeholder="A-Z a-z 0-9"/></td>
				</tr>
				<tr>
					<td>Confirmare parola noua</td>
					<td><input type="password" name="newpassr" id="password" class="form-control smallbar marginbar" required="" placeholder="A-Z a-z 0-9"/></td>
				</tr>
				<tr>
					<td colspan="2"><center><input type="submit" name="submit" class="btn btn-s btn-info" value="Actualizare" /></center></td>
				</tr>
			</table>
		</div>
	</form>
	<!-- Pass change end here -->
	</div>
</div>
<?php } ?>