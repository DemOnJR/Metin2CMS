<?php
//@ignore
if (!defined('IN_INDEX')) {
    exit();
}

$type = (isset($_GET['s'])) ? $_GET['s'] : 'players';

if ($type == 'guilds') {
// Guilds highscore
?>
<div class="panel panel-primary">
  <div class="panel-heading">
    <h3 class="panel-title"><?=$cfg['sitename']; ?> - Clasament bresle</h3>
  </div>
      <div class="panel-body">
      <center><a class="btn btn-xl btn-warning" href="?page=highscore&s=players">Jucatori</a></center>
<table id="dataTable" class="table table-striped">
                      <thead>
                          <tr>
                              <th>#</th>
                              <th>Regat</th>
                              <th>Nume</th>
                              <th>Lider</th>
                              <th>Nivel</th>
                              <th>W-D-L <font color="red">[*]</font></th>
                          </tr>
                      </thead>
 
<?php 
$sql = "SELECT * FROM player.guild ORDER BY ladder_point desc, exp desc, name asc limit 0,20";
      $i = "0" ;
 $query = mysqli_query($sqlServ, $sql);
while($row = mysqli_fetch_object($query))
   {
   $i = $i + 1 ;
   $leader = $row->master;
    echo"<td>$i</td>";
      $result = $sqlServ->query("SELECT empire from player.player_index where pid1 = '$leader' OR pid2 = '$leader' OR pid3 = '$leader' OR pid4 = '$leader'");
    $rowE = $result->fetch_row();
    $empire = $rowE[0];
    echo"<td><img src=\"img/regat/$empire.jpg\"></td>";
    echo"<td><a href=\"?page=guild&gid={$row->id}\">$row->name</a></td>";

      $result1 = $sqlServ->query("SELECT name FROM player.player where id = ".$row->master."");
      $rowL = $result1->fetch_row();
      $lider = $rowL[0];
    echo"<td>$lider</td>";
    echo"<td>$row->level</td>";
  echo"<td>$row->win - $row->draw - $row->loss</td></tr>";
}?>
</table>
<p><font color="red">[*]</font> - Castiguri - Egaluri - Infrangeri</p>
      </div>
    </div>
<?php } else { 
// Players highscore
?>
<div class="panel panel-primary">
  <div class="panel-heading">
    <h3 class="panel-title"><?=$cfg['sitename']; ?> - Clasament jucatori</h3>
  </div>
  <div class="panel-body">
  <center><a class="btn btn-xl btn-warning" href="?page=highscore&s=guilds">Bresle</a></center><br />
  <table class="table table-stripped table-bordered">
    <thead>
      <th>#</th>
      <th>Nume jucator</th>
      <th>Regat</th>
      <th>Breasla</th>
      <th>Nivel</th>
      <th>Experienta</th>
    </thead>
    <tbody>
    <?php
      $defPage = 1;
      $plPerPage = 10;

      $p = isset($_GET['p']) ? $_GET['p'] : 1;

      if ($p <= 1) { 
        $limstart = 0;
        $limend = $plPerPage;
      } else {
        $limstart = $p * $plPerPage - $plPerPage ;
        $limend = $plPerPage;
      }

      $qry1 = $sqlServ->query("SELECT player.id,player.name,player.level,player.exp,player_index.empire,guild.name AS guild_name 
                      FROM player.player 
                    LEFT JOIN player.player_index 
                    ON player_index.id=player.account_id 
                    LEFT JOIN player.guild_member 
                    ON guild_member.pid=player.id 
                    LEFT JOIN player.guild 
                    ON guild.id=guild_member.guild_id
                    INNER JOIN account.account 
                    ON account.id=player.account_id
                    WHERE player.name NOT LIKE '[%]%' AND player.name NOT LIKE '%[%]' AND account.status!='BLOCK'
                    ORDER BY player.level DESC, player.exp DESC 
                    LIMIT $limstart,$limend
                  ");
      $qry2 = mysqli_fetch_object($sqlServ->query("SELECT COUNT(*) as numarCaractere  
                                                        FROM player.player 
                                                        LEFT JOIN player.player_index 
                                                        ON player_index.id=player.account_id 
                                                        LEFT JOIN player.guild_member 
                                                        ON guild_member.pid=player.id 
                                                        LEFT JOIN player.guild 
                                                        ON guild.id=guild_member.guild_id
                                                        INNER JOIN account.account 
                                                        ON account.id=player.account_id
                                                        WHERE player.name NOT LIKE '[%]%' AND player.name NOT LIKE '%[%]' AND account.status!='BLOCK'
                                                        ORDER BY player.level DESC, player.exp DESC
                                                  "));
      $i = $limstart ;
      $cPages = array();
      $cPages = calcPages($qry2->numarCaractere, 0 ,$plPerPage);

      while ($row = mysqli_fetch_object($qry1)) {
        $i++;
        $empire = (empty($row->empire)) ? '' : '<img src="img/regat/'.$row->empire.'.jpg" height="20"/>';
        $guild = (empty($row->guild_name)) ? '-' : $row->guild_name;
    ?>
      <tr>
        <td style="text-align:center;"><?=$i?></td>
        <td style="text-align:center;"><a href="?page=character&name=<?=$row->name?>"><?=$row->name?></a></td>
        <td style="text-align:center;"><?=$empire?></td>
        <td style="text-align:center;"><?=$guild?></td>
        <td style="text-align:center;"><?=$row->level?></td>
        <td style="text-align:center;"><?=$row->exp?></td>
      </tr>
    <?php 
      } 
    ?>
    </tbody>
  </table>
  <?php
      if ($p > 1) {
        $lp = $p-1;
        echo "<a href=\"?page=highscore&s=players&p=".$lp."\" class=\"btn btn-warning\" style=\"float:left;\">Inapoi 10 ranguri</a>";
      }
      if ($p < $cPages[0]) {
        $lp = $p+1;
        echo "<a href=\"?page=highscore&s=players&p=".$lp."\" class=\"btn btn-success\" style=\"float:right;\">Urmatoarele 10 ranguri</a>";
      }
  ?>
  </div>
</div>

<?php } ?>