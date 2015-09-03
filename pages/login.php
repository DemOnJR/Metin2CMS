<?php 
//@ignore
if (!defined('IN_INDEX')) {
    exit();
}

if (!empty($_SESSION['userid'])) {
	header('Location: ?page=home');
} else {
	if(isset($_POST['loginbtn']) && $_POST['loginbtn'] == 'LogIn') {
		$user = sanitize(stripInput($_POST['lusername']));
		$pw = sanitize(stripInput($_POST['lpassword']));
		
		$check = "SELECT * from account.account where login = '" . $user . "' and password = PASSWORD('$pw')";
				$query = mysqli_query($sqlServ, $check);
					$num = mysqli_num_rows($query);

					if ($num>0) {
						gen_notif("Acum esti logat ca ".$user."! <meta http-equiv='refresh' content='1; URL=?page=home' />");
						$info = mysqli_fetch_object($query);
						if ($info->status == 'OK') {
							$_SESSION['userid'] = $info->id;
							$_SESSION['user']	= $info->login;
							$_SESSION['usermd']	= $info->coins;
							$_SESSION['useradmin'] = $info->web_admin;
						} else {
							gen_error("Contul tau este blocat! <meta http-equiv='refresh' content='1; URL=?page=home' />");
						}
						
					} else {
						gen_error("Logarea nu a avut succes. Verifica datele introduse! <meta http-equiv='refresh' content='1; URL=?page=home' />");
					} 
		
	} else {
		header('Location: ?page=home');
	}
}
?>