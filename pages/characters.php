<?php 
//@ignore
if (!defined('IN_INDEX')) {
    exit();
}
if(!isset($_SESSION['userid'])){header('Location: ?page=home');}else {
if (isset($_GET['debug']) && is_numeric($_GET['debug']) && !empty($_GET['debug'])) {
    
    $char = $_GET['debug'];
    $qry1 = mysqli_fetch_object($sqlServ->query("Select * from player.player where id='$char'")) OR exit(mysql_error());
    $qry2 = mysqli_fetch_object($sqlServ->query("Select * from account.account where id='".$qry1->account_id."'")) OR exit(mysql_error());
    $accountid = $qry2->id;
    $qry3 = $sqlServ->Query("SELECT * FROM player.player WHERE id='".$char."' AND account_id ='".$accountid."'");
    if (mysqli_num_rows($qry3)>0) {
        $resetPos = array();
        $resetPos[1]['map_index']=1; // Shinsoo
        $resetPos[1]['x']=468779;
        $resetPos[1]['y']=962107;
        $resetPos[2]['map_index']=21; // Chunjo
        $resetPos[2]['x']=55700;
        $resetPos[2]['y']=157900;
        $resetPos[3]['map_index']=41; // Jinno
        $resetPos[3]['x']=969066;
        $resetPos[3]['y']=278290;

        $getChar = mysqli_fetch_array($qry3);
        $pid = $getChar['id'];
        $qry4 = mysqli_fetch_array($sqlServ->Query("SELECT * FROM player.player_index WHERE pid1='$pid' or pid2='$pid' or pid3='$pid' or pid4='$pid'")) OR exit(mysql_error());
        $empire = $qry4['empire'];
        $qry5 = $sqlServ->Query("UPDATE player.player SET map_index='".$resetPos[$empire]['map_index']."', x='".$resetPos[$empire]['x']."', y='".$resetPos[$empire]['y']."',     exit_x='".$resetPos[$empire]['x']."', exit_y='".$resetPos[$empire]['y']."', exit_map_index='".$resetPos[$empire]['map_index']."', horse_riding='0' WHERE id='".$char."' LIMIT 1");
            if ($qry5) {
                gen_notif('Caracterul a fost trimis inapoi in Map1.');   
            } else {
                gen_error('Caracterul nu a putut fi debugat. Luati legatura cu un administrator daca mai aveti probleme.');
            }
    } else {
        gen_error('A aparut o eroare.');
    }
}
?>
<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title"><?=$cfg['sitename']; ?> - Caracterele mele</h3>
	</div>
	<div class="panel-body">
    <p>Daca ai ramas blocat intr-o mapa poti da debug pentru a reseta pozitia caracterului in map1</p>
    <p>Pentru a trimite un caracter in map1 este recomandat sa asteptati 5 minute inainte si dupa a da debug</p>
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Nume</th>
                <th>Rasa</th>
                <th>Nivel</th>
                <th>Breasla</th>
                <th>Optiuni</th>
            </tr>
        </thead>
        <tbody>
        <?php
$getcharquery = "SELECT player.id,player.name,player.job,player.level,player.playtime,guild.name AS guild_name
    FROM player.player
    LEFT JOIN player.guild_member 
    ON guild_member.pid=player.id 
    LEFT JOIN player.guild 
    ON guild.id=guild_member.guild_id
    WHERE player.account_id='".$_SESSION['userid']."'";
$exsql = $sqlServ->Query($getcharquery);
$i = 0;
$rasa = array(
	'0' => "War (M)",
	'1' => "Ninja (F)",
	'2' => "Sura (M)",
	'3' => "Saman (F)",
	'4' => "War (F)",
	'5' => "Ninja (M)",
	'6' => "Sura (F)",
	'7' => "Saman (M)"
	 );
while ($info = mysqli_fetch_object($exsql)) {
$i=$i+1;

echo'
            <tr class="success">
                <td>'.$i.'</td>
                <td><a href="?page=character&name='.$info->name.'">'.$info->name.'</a></td>
                <td>'.$rasa[$info->job].'</td>
                <td>'.$info->level.'</td>
                <td>'.$info->guild_name.'</td>
                <td><a href="?page=characters&debug='.$info->id.'" class="btn btn-xs btn-default" >DEBUG</a></td>
            </tr>
';
}
?>
        </tbody>
    </table>
	</div>
</div>
<?php } ?>