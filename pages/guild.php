<?php
//@ignore
if (!defined('IN_INDEX')) {
    exit();
}

if (isset($_GET['gid']) && is_numeric($_GET['gid'])) {
	$gid = filter_var($_GET['gid'], FILTER_SANITIZE_STRING);

	$qryGetGuildInfo = $dbCon->query("SELECT * FROM player.guild WHERE id = {$gid}");
	if (mysqli_num_rows($qryGetGuildInfo) >= 1) {
		$g = mysqli_fetch_object($qryGetGuildInfo);

		// Regat breasla
		$qryGetEmpire = $dbCon->query("SELECT * FROM player.player_index WHERE pid1={$g->master} OR pid2={$g->master} OR pid3={$g->master} OR pid4={$g->master}");
		$empire = mysqli_fetch_object($qryGetEmpire)->empire;

		// Lider breasla
		$qryGetMaster = $dbCon->query("SELECT * FROM player.player WHERE id = {$g->master}");
		$master = mysqli_fetch_object($qryGetMaster)->name;

		// Membri breasla
		$qryNumGuildMembers = $dbCon->query("SELECT COUNT(*) AS members FROM player.guild_member WHERE guild_id = {$g->id}");
		$memberCount = mysqli_fetch_object($qryNumGuildMembers)->members;
?>
<div class="panel panel-primary">
	<div class="panel-heading"><?=$cfg['sitename']?> - Informatii breasla <?=$g->name?></div>
	<div class="panel-body">
		<ul class="nav nav-tabs" role="tablist">
			<li role="presentation" class="active"><a href="#guildinfo" aria-controls="guildinfo" role="tab" data-toggle="tab">Informatii</a></li>
			<li role="presentation"><a href="#guildmembers" aria-controls="guildmembers" role="tab" data-toggle="tab">Membri</a></li>
		</ul>
		<div class="tab-content">
			<div role="tabpanel" class="tab-pane active" id="guildinfo">
				<div class="well">
					<table class="table table-bordered">
						<tr>
							<td>Nume</td>
							<td><?=$g->name?></td>
						</tr>
						<tr>
							<td>Nivel</td>
							<td><?=$g->level?></td>
						</tr>
						<tr>
							<td>Regat</td>
							<td><img src="img/regat/<?=$empire?>.jpg"></td>
						</tr>
						<tr>
							<td>Lider</td>
							<td><a href="?page=character&name=<?=$master?>"><?=$master?></a></td>
						</tr>
						<tr>
							<td>Membri</td>
							<td><?=$memberCount?></td>
						</tr>
						<tr>
							<td>Razboaie castigate</td>
							<td><?=$g->win?></td>
						</tr>
						<tr>
							<td>Razboaie pierdute</td>
							<td><?=$g->loss?></td>
						</tr>
						<tr>
							<td>Remize</td>
							<td><?=$g->draw?></td>
						</tr>
						<tr>
							<td>Puncte</td>
							<td><?=$g->ladder_point?></td>
						</tr>
					</table>
				</div>
			</div>
			<div role="tabpanel" class="tab-pane" id="guildmembers">
				<div class="well">
					<?php
						$qryGetMembers = $dbCon->query("SELECT * FROM player.guild_member WHERE guild_id = {$g->id} ORDER BY is_general DESC");
						$guildRanks = ['Normal', 'General'];
						$i = 0;
					?>
					<table class="table table-bordered">
						<thead>
							<th>#</th>
							<th>Nume</th>
							<th>Nivel</th>
							<th>Rang</th>
						</thead>
						<tbody>
							<?php
							while ($m = mysqli_fetch_object($qryGetMembers)) {
								$qryGetMemberInfo = $dbCon->query("SELECT * FROM player.player WHERE id = {$m->pid}");
								$p = mysqli_fetch_object($qryGetMemberInfo);
								$i++;
							?>
							<tr>
								<td><?=$i?></td>
								<td><a href="?page=character&name=<?=$p->name?>"><?=$p->name?></a></td>
								<td><?=$p->level?></td>
								<td><?=$guildRanks[$m->is_general]?></td>
							</tr>
							<?php
							}
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<?php }
} ?>