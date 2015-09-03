<?php
/**
* Clasa care se ocupa de erori
*/

	function error($v, $t = 'warning', $d = true, $dm = true){
		$wM = [
			'danger' => '<h4>Atentie!</h4>',
			'warning' => '<h4>Atentie!</h4>',
			'success' => null,
			'info' => null,
		];
		$dsc = ($d === true) ? 'alert-dismissible' : null;
		$dsb = ($d === true) ? '<button type="button" class="close" data-dismiss="alert">&times;</button>' : null;

		$m = ($dm === true) ? $wM[$t] : null;
		echo '
			<div class="alert '.$dsc.' alert-'.$t.'">
				'.$dsb.'
				'.$m.'
				<p>'.$v.'</p>
			</div>
			';
	}

	
	function confirm($t,$an,$et = 'info',$extraForm = '', $m = 'POST'){
		echo '<form method ="'.$m.'">';
			echo $extraForm;
			echo '<div class="alert alert-dismissible alert-'.$et.'">';
				echo '<p>'.$t.'</p>';
				echo '<button type="submit" class="btn btn-xs btn-danger" data-dismiss="alert">NU</button> ';
				echo '<button type="submit" class="btn btn-xs btn-success" name="'.$an.'">DA</button> ';
			echo '</div>';
		echo '</form>';
	}
?>