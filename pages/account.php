<?php
//@ignore
if (!defined('IN_INDEX')) {
    exit();
}

if(!isset($_SESSION['userid'])){header('Location: ?page=home');}else {?>
<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title"><?=$cfg['sitename'];?> - Informatii cont</h3>
	</div>
	<div class="panel-body">
    <?php
        $db1 = $sqlServ->Query("SELECT * FROM account.account WHERE login = '".$_SESSION['user']."'");
        $array1 = mysqli_fetch_array($db1);

        $db2 = $sqlServ->Query("SELECT COUNT(*) FROM player.player WHERE account_id = '".$_SESSION['userid']."' ");
        $array2 = mysqli_fetch_array($db2);
    ?>
        <table class="table table-bordered">
            <tr>
                <td width="30%">Username</td>
                <td><?=$array1['login'];?></td>
            </tr>
            <tr>
                <td>E-mail</td>
                <td><?=$array1['email']?></td>
            </tr>
            <tr>
                <td>Cod stergere caracter</td>
                <td><?=$array1['social_id']?></td>
            </tr>
            <tr>
                <td>Caractere</td>
                <td><?=$array2['COUNT(*)']?></td>
            </tr>
            <tr>
                <td>Stare cont</td>
                <td>
                    <?php if ($array1['status'] == "OK"){ echo '<font color="green"><b>OK</b></font>'; } else {echo ' <font color="red"><b>BLOCAT</b></font>'; } ?>
                </td>
            </tr>
            <tr>
                <td>Monede dragon</td>
                <td><?=$array1['coins']?> <a href="?page=buymd"><span class="glyphicon glyphicon-shopping-cart"></span></a></td>
            </tr>
        </table>
	</div>
</div>
<?php } ?>