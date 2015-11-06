<?php
	define('SITEPATH', 'http://localhost/mc_m2cms/'); // Adresa websitului (sa se incheie cu slash "/")

	if($maintenance === false){
		$cfg['toplimit']	= getset('top_limit'); // Cati jucatori sa afiseze topul
		$cfg['cms_ver'] 	= "1.3.2";
		
		// Config settings
		if (getset('captcha') == 'true') {
			$use_captcha = true;
		} else {
			$use_captcha = false;
		}
		if (getset('register_on') == 'true') {
			$register_on = true;	
		} else {
			$register_on = false;
		}
		
		$safebox_expire 		= '2020-01-01 12:00:00';
		$autoloot_expire 		= '2020-01-01 12:00:00';
		$money_drop_rate_expire = '2020-01-01 12:00:00';
		$starting_coins 		= 0; // Monedele primite la inregistrare
	}