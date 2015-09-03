<?php if (!isset($_SESSION['userid']) || empty($_SESSION['userid'])) { exit('Trebuie sa fii logat.'); } else { ?>
<div class="panel panel-primary shadow">
<?php
	if (is_numeric($cat) && !is_null($cat)){
		$getCatName = $sqlServ->Query("SELECT * FROM account.cms_is_cats WHERE id = $cat LIMIT 1");
		$catName = mysqli_fetch_object($getCatName)->nume;		
	} else {
		$catName = 'Acasa';
	}
?>
	<div class="panel-heading">Iteme &bull; <?=$catName?></div>
	<div class="panel-body">
	<?php if (is_numeric($cat) && !is_null($cat)) { ?> <p>Iteme din aceasta categorie:</p> <?php }else{ ?><p>Ultimele 5 iteme adaugate:</p><?php } ?>
	<?php
		$getItems = (is_numeric($cat) && !is_null($cat)) ? $sqlServ->query("SELECT * FROM account.cms_is_items WHERE catid = $cat ORDER BY id DESC") : $sqlServ->query("SELECT * FROM account.cms_is_items ORDER BY id DESC LIMIT 5");
		if (mysqli_num_rows($getItems) == 0) {
			error("Momentan nu exista iteme in aceasta categorie.");
		}
		while ($item = mysqli_fetch_array($getItems)){
	?>
		<div class="panel panel-primary">
			<div class="panel-heading"><?=$item['nume']?></div>
			<table class="table">
					<tr><td rowspan="3" class="col-md-1">
							<?php if(file_exists('item/'.$item['vnum'].'.png')) { ?>
								<img src="item/<?=$item['vnum']?>.png">
							<?php } else { ?>
								<img src="item/default.jpg" width="32px">
							<?php } ?>
						</td></tr>
					<tr><td><?=$item['desc']?></td></tr>
					<tr><td>Pret: <?=$item['price']?>MD </td><td><a href="?page=buy&buy=<?=$item['vnum']?>" class="btn btn-success btn-xs" style="float:right;">CUMPARA</a></td></tr>
			</table>
		</div>
	<?php
		}
	?>
	</div>
</div>
<?php } ?>