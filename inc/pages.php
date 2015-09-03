<?php
	$curpage = (isset($_GET['page']) && !empty($_GET['page'])) ? $_GET['page'] : 'home' ;

	$pages = array();
	switch ($curpage) {
		case 'home':
			$pages['title'] = 'Prima pagina';
			$pages['file'] = 'pages/home.php';
			break;
		case 'register':
			$pages['title'] = 'Cont nou';
			$pages['file'] = 'pages/register.php';
			break;
		case 'highscore':
			$pages['title'] = 'Clasament';
			$pages['file'] = 'pages/highscore.php';
			break;
		case 'download':
			$pages['title'] = 'Descarcare client';
			$pages['file'] = 'pages/download.php';
			break;
		case 'guild':
			$pages['title'] = 'Informatii breasla';
			$pages['file'] = 'pages/guild.php';
			break;

		#### USER ####

		case 'login':
			$pages['title'] = 'Autentificare';
			$pages['file'] = 'pages/login.php';
			break;
		case 'logout':
			$pages['title'] = 'Delogare';
			$pages['file'] = 'pages/logout.php';
			break;
		case 'character':
			$pages['title'] = 'Informatii caracter';
			$pages['file'] = 'pages/character.php';
			break;
		case 'characters':
			$pages['title'] = 'Caracterele mele';
			$pages['file'] = 'pages/characters.php';
			break;
		case 'change_pass':
			$pages['title'] = 'Schimbare parola';
			$pages['file'] = 'pages/change_pass.php';
			break;
		case 'account':
			$pages['title'] = 'Informatii cont';
			$pages['file'] = 'pages/account.php';
			break;
		case 'buymd':
			$pages['title'] = 'Cumpara monede dragon';
			$pages['file'] = 'pages/buymd.php';
			break;
		case 'notifications':
			$pages['title'] = 'Notificari';
			$pages['file'] = 'pages/notifications.php';
			break;

		#### ADMIN ####

		case 'admin_home':
			$pages['title'] = 'Panou de administrare';
			$pages['file'] = 'pages/admin_home.php';
			break;
		case 'admin_settings':
			$pages['title'] = 'Setari website';
			$pages['file'] = 'pages/admin_settings.php';
			break;
		case 'admin_downloads':
			$pages['title'] = 'Administrare descarcari';
			$pages['file'] = 'pages/admin_downloads.php';
			break;
		case 'admin_news':
			$pages['title'] = 'Administrare stiri si evenimente';
			$pages['file'] = 'pages/admin_news.php';
			break;
		case 'admin_webadmins':
			$pages['title'] = 'Administratori site';
			$pages['file'] = 'pages/admin_webadmins.php';
			break;
		case 'admin_playersearch':
			$pages['title'] = 'Cautare jucator';
			$pages['file'] = 'pages/admin_playersearch.php';
			break;
		case 'admin_accountsearch':
			$pages['title'] = 'Cauta cont';
			$pages['file'] = 'pages/admin_accountsearch.php';
			break;
		case 'admin_charedit':
			$pages['title'] = 'Editare caracter';
			$pages['file'] = 'pages/admin_charedit.php';
			break;
		case 'admin_accedit':
			$pages['title'] = 'Editare cont';
			$pages['file'] = 'pages/admin_accedit.php';
			break;
		case 'admin_addcoins':
			$pages['title'] = 'Adaugare monede';
			$pages['file'] = 'pages/admin_addcoins.php';
			break;
		case 'admin_donations':
			$pages['title'] = 'Administrare donatii';
			$pages['file'] = 'pages/admin_donations.php';
			break;
		case 'admin_ishop_cat':
			$pages['title'] = 'Administrare categorii ishop';
			$pages['file'] = 'pages/admin_ishop_cat.php';
			break;
		case 'admin_ishop_items':
			$pages['title'] = 'Administrare iteme ishop';
			$pages['file'] = 'pages/admin_ishop_items.php';
			break;
		case 'admin_ishop_log':
			$pages['title'] = 'Log cumparaturi ishop';
			$pages['file'] = 'pages/admin_ishop_log.php';
			break;

		#### DEFAULT ####

		default:
			$pages['title'] = 'Prima pagina';
			$pages['file'] = 'pages/home.php';
			break;
	}


?>