<?php 
//@ignore
if (!defined('IN_INDEX')) {
    exit();
}
?>
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title"><?php echo $cfg['sitename']; ?> - Informatii caracter</h3>
			</div>
			<div class="panel-body">
			<?php if (!isset($_GET['name']) || empty($_GET['name'])) {
				header('Location: ?page=home');
			}
				$name = filter_var($_GET['name'], FILTER_SANITIZE_STRING);
				$ck_player = $sqlServ->Query("SELECT * FROM player.player where name='".$name."'");
				$nump = mysqli_num_rows($ck_player);
				if (!$nump > 0) {
					echo "Jucatorul nu a putut fi gasit.";
				} else {

					$sql = $sqlServ->Query("SELECT * FROM player.player where name='".$_GET['name']."';");
					$shit = mysqli_fetch_array($sql);

					$pid = $shit['id']; 
					$regat = $sqlServ->Query("SELECT empire FROM player.player_index WHERE pid1='$pid' or pid2='$pid' or pid3='$pid' or pid4='$pid'");
					$shit2 = mysqli_fetch_array($regat);

					$id_breasla_sql = $sqlServ->Query("SELECT guild_id FROM player.guild_member WHERE pid='$pid'") OR $id_breasla = null;
					$id_breasla = mysqli_fetch_object($id_breasla_sql);

					if (!is_null($id_breasla)) {
						$nume_breasla = mysqli_fetch_object($sqlServ->Query("SELECT name FROM player.guild WHERE id='".$id_breasla->guild_id."'"));
						$breasla = $nume_breasla->name;
					} else {
						$breasla = "-";
					}

					
					if ($sql) {
								
						echo'	<table class="table table-bordered">
								<tr>
									<td width="25px" rowspan="10"><img src="img/clase/'.$shit['job'].'.png" /></td>
									<td > 
										<center><img src="img/regat/'.$shit2['empire'].'.jpg" /><kbd>'.$shit['name'].'</kbd></center>
									</td>				
								</tr>
								<tr><td>Nivel: <code>'.$shit['level'].'</code></tr>
								<tr><td>Breasla: <code>'.$breasla.'</code></td></tr>
								<tr><td>Experienta: <code>'.$shit['exp'].'</code></td></tr>
								<tr><td>Minute jucate: <code>'.$shit['playtime'].'</code></td></tr>
								<tr><td>Yang: <code>'.$shit['gold'].'</code></td></tr>
								<tr><td>VIT: <code>'.$shit['ht'].'</code></td></tr>
								<tr><td>INT: <code>'.$shit['iq'].'</code></td></tr>
								<tr><td>STR: <code>'.$shit['st'].'</code></td></tr>
								<tr><td>DEX: <code>'.$shit['dx'].'</code></td></tr>
							</table>
							<center><img src="sig.php?p='.$shit['name'].'" ></center><br />
							<a class="btn btn-s btn-warning right" rel="nofollow" href="javascript: history.go(-1)">Inapoi</a>
						';
						if (isset($_SESSION['useradmin']) && $_SESSION['useradmin'] >= $minlevel['pedit']) {
							echo '<a href="?page=admin_charedit&id='.$shit['id'].'" class="btn btn-success">Editare</a>';
						}
					} else {
						echo "Jucatorul nu a putut fi gasit.";
					}
				}
			?>
			</div>
		</div>