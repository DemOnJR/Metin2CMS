<?php 
//@ignore
if (!defined('IN_INDEX')) {
    exit();
}
if(isset($_SESSION['useradmin']) && $_SESSION['useradmin'] >= $minlevel['pedit']){ ?>
<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title"><?=$cfg['sitename']; ?> - Editare caracter</h3>
	</div>
	<div class="panel-body">
	<?php if (!isset($_GET['id']) || empty($_GET['id'])) {
				header('Location: ?page=home');
			}
				$ck_player = $sqlServ->Query("SELECT * FROM player.player where id='".$_GET['id']."'");
				$nump = mysqli_num_rows($ck_player);
				if (!$nump > 0) {
					error("Jucatorul nu a putut fi gasit.");
				} else {

					$sql = $sqlServ->Query("SELECT * FROM player.player where id='".$_GET['id']."';");
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
						if (isset($_POST['modificare'])){
							$qry = $sqlServ->Query("UPDATE player.player SET name = '".$_POST['name']."', job = '".$_POST['rasa']."', level = '".$_POST['level']."', exp = '".$_POST['experienta']."', playtime = '".$_POST['playtime']."', gold = '".$_POST['yang']."', ht = '".$_POST['vit']."', iq = '".$_POST['int']."', st = '".$_POST['str']."', dx = '".$_POST['dex']."' WHERE id = '".$_POST['id']."'");
							if ($qry) {
								error("Success!", 'success');
							} else {
								echo "Error".mysql_error();
							}
						}		
						?>
						<form action="?page=admin_charedit&id=<?=$shit['id']?>" method="POST">
							<table class="table table-bordered">
								<input type="hidden" name="id" value="<?=$shit['id']?>">
								<tr>
									<td width="25px" rowspan="10">
										<img src="img/clase/<?=$shit['job']?>.png" />
										<select name="rasa">
											<option value="<?=$shit['job']?>">Curent: <?=$rase[$shit['job']]?></option>
											<?php foreach ($rase as $key => $value) {
												echo "<option value=\"".$key."\">".$value."</option>";
											}?>
										</select>
									</td>
									<td style="width: 25px;"> 
										<img src="img/regat/<?=$shit2['empire']?>.jpg" />
									</td>
									<td>
									Nume: <input type="text" name="name" style="float:right;" value="<?=$shit['name']?>"><br />
									</td>				
								</tr>
								<tr><td colspan="2">Nivel: <input type="text" name="level" style="float:right;" value="<?=$shit['level']?>"></td></tr>
								<tr><td colspan="2">Breasla: <code><?=$breasla?></code></td></tr>
								<tr><td colspan="2">Experienta: <input type="text" name="experienta" style="float:right;" value="<?=$shit['exp']?>"></td></tr>
								<tr><td colspan="2">Minute jucate: <input type="text" name="playtime" style="float:right;" value="<?=$shit['playtime']?>"></td></tr>
								<tr><td colspan="2">Yang: <input type="text" name="yang" style="float:right;" value="<?=$shit['gold']?>"></td></tr>
								<tr><td colspan="2">VIT: <input type="text" name="vit" style="float:right;" value="<?=$shit['ht']?>"></td></tr>
								<tr><td colspan="2">INT: <input type="text" name="int" style="float:right;" value="<?=$shit['iq']?>"></td></tr>
								<tr><td colspan="2">STR: <input type="text" name="str" style="float:right;" value="<?=$shit['st']?>"></td></tr>
								<tr><td colspan="2">DEX: <input type="text" name="dex" style="float:right;" value="<?=$shit['dx']?>"></td></tr>
							</table>
								<button type="submit" class="btn btn-s btn-success" name="modificare"><i class="fa fa-save"></i> Salvare</button>
							</form>
						<?php
					} else {
						echo "Jucatorul nu a putut fi gasit.";
					}
				}
			?>
	</div>
</div>
<?php 
} else {
	header('Location: ?page=home');
}
?>