<?php
//@ignore
if (!defined('IN_INDEX')) {
    exit();
}
		$qryGetNews = $sqlServ->Query("SELECT * FROM account.cms_news ORDER BY id DESC");
		if(mysqli_num_rows($qryGetNews)>0){
	?>
	
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title"><?=$cfg['sitename']; ?> - Stiri si evenimente</h3>
		</div>
		<div class="panel-body">
		<?php while ($n = mysqli_fetch_object($qryGetNews)) { ?>
		
			<legend>
				<div class="small"><?=$n->titlu?>
				<p class="pull-right small" style="font-style:italic; font-size:12px; color:#AAA;">By <?=$n->autor?> | <?=$n->data?></p></div>
			</legend>
			<div class="well" style="margin-top: -16px;"><?=$n->continut?></div>
		<?php } ?>
		</div>	
	</div>
	<?php } ?>




		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title"><?=$cfg['sitename']; ?> - Actiunea orientala MMORPG</h3>
			</div>
			<div class="panel-body">
				In vremuri stravechi rasuflarea Zeului Dragon veghea asupra regatelor Shinsoo, Chunjo si Jinno. Dar aceasta lume fascinanta a magiei se afla in fata unui pericol imens: Impactul Pietrelor Metin care au cauzat haos si distrugere pe continent si intre locuitori. Au izbucnit razboaie intre continente, animalele salbatice s-au transformat in bestii terifiante. Lupta impotriva influentei negative a Pietrelor Metin in postura unui aliat al Zeului Dragon. Aduna-ti toate puterile si armele pentru a salva regatul.
			</div>
		</div>
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title"><?=$cfg['sitename']; ?> - Galerie</h3>
			</div>
			<div class="panel-body" style="width:590px;">
				<div class="row">
					<div class="col-sm-3">
						<a href="" class="img-thumbnail" data-toggle="modal" data-target="#galerie1">
					      <img src="./img/galerie/thumbs/1.jpg">
					    </a>
					</div>
					<div class="col-sm-3">
						<a href="" class="img-thumbnail" data-toggle="modal" data-target="#galerie2">
					      <img src="img/galerie/thumbs/2.jpg">
					    </a>
					</div>
					<div class="col-sm-3">
						<a href="" class="img-thumbnail" data-toggle="modal" data-target="#galerie3">
					      <img src="img/galerie/thumbs/3.jpg">
					    </a>
					</div>
					<div class="col-sm-3" >
						<a href="" class="img-thumbnail" data-toggle="modal" data-target="#galerie4">
					      <img src="img/galerie/thumbs/4.jpg" alt="">
					    </a>
					</div>
				</div>
					<div class="modal fade" id="galerie1">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-body"><img src="img/galerie/1.jpg" alt="" width="100%"></div>
							</div>
						</div>
					</div>
					<div class="modal fade" id="galerie2">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-body"><img src="img/galerie/2.jpg" alt="" width="100%"></div>
							</div>
						</div>
					</div>
					<div class="modal fade" id="galerie3">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-body"><img src="img/galerie/3.jpg" alt="" width="100%"></div>
							</div>
						</div>
					</div>
					<div class="modal fade" id="galerie4">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-body"><img src="img/galerie/4.jpg" alt="" width="100%"></div>
							</div>
						</div>
					</div>
			</div>
		</div>