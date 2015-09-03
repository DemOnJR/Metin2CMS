 <?php
	function updateSession()
	{
		global $sqlServ;

		if (isset($_SESSION['userid']) && !empty($_SESSION['userid'])){
			$qry = mysqli_fetch_object($sqlServ->query("SELECT * FROM account.account where id = ".$_SESSION['userid']." LIMIT 1"));
			$_SESSION['usermd']	= $qry->coins;
			$_SESSION['useradmin']	= $qry->web_admin;
		}
	}
	function calcPages($gesEin,$aktSeite,$eSeite) {
		$output = array();
		$esQuote = ceil(($gesEin/$eSeite));
		if($aktSeite==0) {$aktSeite=1;}
		$startS = ($aktSeite*$eSeite)-$eSeite;
		$output[0]=$esQuote;
		$output[1]=$startS;
		return $output;
	}
	function gen_error($a)
	{
		echo '<div class="alert alert-warning" role="alert">'.$a.'</div>';
	}
	function gen_notif($a)
	{
		echo '<div class="alert alert-success" role="alert">'.$a.'</div>';
	}
	function textcut($text, $lungime){
		$tf = filter_var($text, FILTER_SANITIZE_STRING);
		$t = substr($tf, 0, $lungime);
		if (strlen($text) > $lungime-1) {
			$t = $t."...";
		}
		return $t; 
	}
	function chkactive($value)
	{
		global $curpage;

		if ($curpage == $value) {
			return 'active';
		}
	}
	function checkPos($inID) {
	    global $sqlServ;

	    $sqlCmd="SELECT pos,vnum FROM player.item WHERE owner_id='".$inID."' AND window='SAFEBOX'";
	    $sqlQry=$sqlServ->query($sqlCmd);
	    
	    $lagerPos=array();
	    while($getLager=mysqli_fetch_object($sqlQry)) {
	      $maxGr = 2;
	      $aktPos=$getLager->pos;
	      for($i=1;$i<=$maxGr;$i++) {
	        $lagerPos[$aktPos]=$getLager->vnum;
	        $aktPos = $aktPos + 5;
	      }
	    }
	    
	    $sqlCmd="SELECT pos,vnum FROM player.item WHERE owner_id='".$inID."' AND window='MALL'";
	    $sqlQry=$sqlServ->query($sqlCmd);
	    
	    $islPos=array();
	    while($getISL=mysqli_fetch_object($sqlQry)) {
	      $maxGr = 1;
	      $aktPos=$getISL->pos;
	      for($i=1;$i<=1;$i++) {
	        $islPos[$aktPos]=$getISL->vnum;
	        $aktPos = $aktPos + 5;
	      }
	    }
	    
	    $returnArray['lager']=$lagerPos;
	    $returnArray['islager']=$islPos;
	    
	    return $returnArray;
	}
	function findPos($belegtePos,$iGroesse) {
		$possPos=array();

		for($i=0;$i<45;$i++) {
			if(empty($belegtePos[$i])) {
				for($y=0;$y<$iGroesse;$y++) {
					$aktPos=$i+($y*5);
					$thisFits = true;
				
					if(!isset($belegtePos[$aktPos]) && $aktPos<45) {
						$thisFits = true;
					} else {
						$thisFits = false;
						break;
					}
				}
				if($thisFits) { $possPos[]=$i; }
			}
		}
		return $possPos;
	}
	function select($v, $n, $c = "form-control"){
		$l = ['true' => 'DA', 'false' => 'NU'];
		
		$a = ($v == 'true') ? 'true' : 'false';
		$b = ($v == 'false') ? 'true' : 'false';

		return '
			<select class="'.$c.'" name="'.$n.'">
				<option value="'.$a.'">'.$l[$a].'</option>
				<option value="'.$b.'">'.$l[$b].'</option>
			</select>
		';
	}
	function sendNotification($s,$m,$d){
		global $dbCon;

		$qry = $dbCon->query("INSERT INTO account.cms_notifications (account_id, date, subject, message) VALUES ({$d}, NOW(), '{$s}', '{$m}')");
		if ($qry) {
			return true;
		} else {
			return false;
		}
	}
	function deleteNotification($id){
		global $dbCon;

		$qry = $dbCon->query("DELETE FROM `account`.`cms_notifications` WHERE  `id`={$id};");
		if ($qry) {
			return true;
		} else {
			return false;
		}
	}
	function ishopLog($acc,$act){
		global $dbCon;
		$ip = getIp();

		$qry = $dbCon->query("INSERT INTO account.cms_log_ishop (account, action, date, ip) VALUES ({$acc}, '{$act}', NOW(), '{$ip}')");
		if ($qry) {
			return true;
		} else {
			return false;
		}
	}