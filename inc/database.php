<?php

	$db_cfg = [
		'DBHOST' => "", // IP conectare server	
		'DBUSER' => "", // USERNAME baza de date server
		'DBPASS' => "", // PAROLA baza de date server
		];

	$dbCon = @mysqli_connect($db_cfg['DBHOST'], $db_cfg['DBUSER'], $db_cfg['DBPASS']) OR ($maintenance = true);
	$sqlServ = $dbCon;

	if (!$dbCon || mysqli_errno($dbCon) >= 1 || empty($db_cfg['DBHOST'])) {
		$maintenance = true;
	} else {

	function getConfigValue($setName) {
		global $dbCon;
		echo mysqli_fetch_object($dbCon->query("SELECT value FROM account.cms_settings WHERE name = '".$setName."'"))->value;
	}
	function getset($setName) {
		global $dbCon;
		return mysqli_fetch_object($dbCon->query("SELECT value FROM account.cms_settings WHERE name = '".$setName."'"))->value;
	}
	$cfg['sitename'] 	= getset('svname'); 
	$cfg['forum'] 		= getset('forum-url');
	}