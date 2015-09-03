<?php 
//@ignore
if (!defined('IN_INDEX')) {
    exit();
}
?>		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title"><?php echo $cfg['sitename']; ?> - Cerinte sistem</h3>
			</div>
			<div class="panel-body">
			<table class="table table-striped">
				<thead>
					<tr>
						<th>&nbsp;</th>
						<th>Minime</th>
						<th>Recomandate</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>Procesor</td>
						<td>Pentium 3 1 GHz</td>
						<td>Pentium 4 1.8 GHz</td>
					</tr>
					<tr>
						<td>Memorie RAM</td>
						<td>512 MB</td>
						<td>1 GB</td>
					</tr>
					<tr>
						<td>Spatiu disc</td>
						<td>1,5 GB</td>
						<td>2 GB</td>
					</tr>
					<tr>
						<td>Memorie RAM GPU</td>
						<td>32 MB</td>
						<td>64 MB</td>
					</tr>
					<tr>
						<td>Sistem de operare</td>
						<td colspan="2">Windows Xp,Vista, 7, 8, 8.1</td>
					</tr>
					<tr>
						<td>Sunet</td>
						<td colspan="2">DirectX 9.0c sau mai nou</td>
					</tr>
					<tr>
						<td>Periferice</td>
						<td colspan="2">Maus, tastatura</td>
					</tr>
				</tbody>
			</table>
			</div>
		</div>
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title"><?=$cfg['sitename']; ?> - Download</h3>
			</div>
			<div class="panel-body">
				<table class="table table-striped">
					<thead>
						<tr>
							<th>Metoda</th>
							<th>Nume</th>
							<th>Versiune</th>
							<th>Data</th>
							<th>&nbsp</th>
						</td>
					</thead>
					<tbody>
					<?php
						$getDown = $sqlServ->Query("SELECT * FROM account.cms_downloads");
							while($res = mysqli_fetch_array($getDown)){
								echo "<tr>";
									echo "<td>".$res['type']."</td>";
									echo "<td>".$res['name']."</td>";
									echo "<td>".$res['version']."</td>";
									echo "<td>".$res['date']."</td>";
									echo "<td><a class=\"btn btn-xs btn-danger\" href=\"".$res['url']."\">DOWNLOAD&nbsp;<span class=\"badge\">".$res['size']."</span></a></td>";
								echo "</tr>";
							} 

					?>
					</tbody>
				</table>
			</div>
		</div>