<?php 
//@ignore
if (!defined('IN_INDEX')) {
	exit();
}
if(isset($_SESSION['useradmin']) && $_SESSION['useradmin'] >= $minlevel['logs']){ ?>
<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title"><?=$cfg['sitename']; ?> - Istoric comenzi GM</h3>
	</div>
	<div class="panel-body">
		<table class="table table-bordered">
			<thead>
				<th class="col-sm-2">GM</th>
				<th class="col-sm-3">DATA</th>
				<th class="col-sm-2">IP</th>
				<th>COMANDA</th>
			</thead>
			<tbody>
				<?php
					$page = (isset($_GET['p']) && !empty($_GET['p'])) ? $_GET['p'] : 1;
					$per_page = 10;
					$numEntries = mysqli_fetch_object($dbCon->query("SELECT COUNT(*) as entries FROM log.command_log"))->entries;
					$numEntries = ceil($numEntries/$per_page);
					
			
					if ($page <= 1) {
						$start = 0;
					} else {
						$start = $page*$per_page-$per_page;
					}	
						
					$qryGetGmLog = $dbCon->query("SELECT * FROM log.command_log ORDER BY date DESC LIMIT 10 OFFSET {$start}");
					while ($l = mysqli_fetch_assoc($qryGetGmLog)) {
						?>
							<tr>
								<td><?=$l['username']?></td>
								<td><?=$l['date']?></td>
								<td><?=$l['ip']?></td>
								<td><?=$l['command']?></td>
							</tr>
						<?php
					}
				?>
			</tbody>
		</table>
		<nav>
			<ul class="pager">
				<li class="previous <?php if($page<=1){echo"disabled";}?>"><a href="?page=admin_gmlog&p=<?=$page-1?>"><span aria-hidden="true">&larr;</span> Inapoi</a></li>
				<li><strong><?=$page?>/<?=$numEntries?></strong></li>
				<li class="next  <?php if($page>=$numEntries){echo"disabled";}?>"><a href="?page=admin_gmlog&p=<?=$page+1?>">Inainte <span aria-hidden="true">&rarr;</span></a></li>
			</ul>
		</nav>
	</div>
</div>
<?php } ?>