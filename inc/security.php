<?php 
	function sanitize($var) {
		$var = htmlentities($var, ENT_QUOTES);
		$var = htmlspecialchars($var, ENT_QUOTES, 'UTF-8');
		if(get_magic_quotes_gpc()) {
			$var = stripslashes($var);
		}
		return $var;
	}

	function stripInput($text) {
		if(!is_array($text)) {
			$text = stripslashes(trim($text));
			$text = preg_replace('/(&amp;)+(?=\#([0-9]{2,3});)/i', '&', $text);
			$search = array(
					'&',
					'\"',
					"'",
					'\\',
					'\"',
					'\'',
					'<',
					'>',
					' '
			);
			$replace = array(
					'&',
					'&quot;',
					'&#39;',
					'&#92;',
					'&quot;',
					'&#39;',
					'<',
					'>',
					' '
			);
			$text = str_replace($search, $replace, $text);
		} else {
			foreach($text as $key => $value) {
				$text[$key] = stripInput($value);
			}
		}
		return $text;
	}
