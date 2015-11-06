<?php 
//@ignore
if (!defined('IN_INDEX')) {
    exit();
}
if(isset($_SESSION['useradmin']) && $_SESSION['useradmin'] > 0){ ?>
<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title"><?php echo $cfg['sitename']; ?> - Optiuni administrare site&server</h3>
	</div>
	<div class="panel-body">
		<?=error('Versiune CMS: '.$cfg['cms_ver'], 'success')?>
		<?=error('In caz ca gasiti vreo problema legata de cms trimiteti un email catre <i>me.claud.69@gmail.com</i>', 'warning')?>
		<?php if($_SESSION['useradmin'] >= $minlevel['downloads'] || $_SESSION['useradmin'] >= $minlevel['news'] || $_SESSION['useradmin'] >= $minlevel['webadmins'] || $_SESSION['useradmin'] >= $minlevel['hpsett']) { ?>
			<ul class="list-group">
				<a class="list-group-item active">Administrare Site</a>
				<?php if($_SESSION['useradmin'] >= $minlevel['downloads']) { ?>	<a href="?page=admin_downloads" class="list-group-item">Administrare pagina download</a><?php } ?>
				<?php if($_SESSION['useradmin'] >= $minlevel['news']) { ?>		<a href="?page=admin_news" class="list-group-item">Administrare stiri si evenimente</a><?php } ?>
				<?php if($_SESSION['useradmin'] >= $minlevel['webadmins']) { ?>	<a href="?page=admin_webadmins" class="list-group-item">Administratori site</a><?php } ?>
				<?php if($_SESSION['useradmin'] >= $minlevel['hpsett']) { ?>	<a href="?page=admin_settings" class="list-group-item">Setari site</a><?php } ?>
			</ul>
		<?php } ?>

		<?php if($_SESSION['useradmin'] >= $minlevel['psearch'] || $_SESSION['useradmin'] >= $minlevel['accsearch']) { ?>	
			<ul class="list-group">
				<a class="list-group-item active">Administrare Jucatori</a>
				<?php if($_SESSION['useradmin'] >= $minlevel['psearch']) { ?>		<a href="?page=admin_playersearch" class="list-group-item">Cauta jucator</a><?php } ?>
				<?php if($_SESSION['useradmin'] >= $minlevel['accsearch']) { ?>	<a href="?page=admin_accountsearch" class="list-group-item">Cauta cont</a> <?php } ?>
			</ul>
		<?php } ?>

		<?php if($_SESSION['useradmin'] >= $minlevel['ishopadmin'] || $_SESSION['useradmin'] >= $minlevel['logs']) { ?>
			<ul class="list-group">
				<a class="list-group-item active">Administrare magazin iteme</a>
				<?php if($_SESSION['useradmin'] >= $minlevel['ishopadmin']) { ?>	<a href="?page=admin_ishop_cat" class="list-group-item">Administrare categorii</a><?php } ?>
				<?php if($_SESSION['useradmin'] >= $minlevel['ishopadmin']) { ?>	<a href="?page=admin_ishop_items" class="list-group-item">Administrare iteme</a><?php } ?>
				<?php if($_SESSION['useradmin'] >= $minlevel['logs']) { ?>	<a href="?page=admin_ishop_log" class="list-group-item">LOG cumparaturi</a><?php } ?>
			</ul>
		<?php } ?>

		<?php if($_SESSION['useradmin'] >= $minlevel['donations'] || $_SESSION['useradmin'] >= $minlevel['addcoins']) { ?>
			<ul class="list-group">
				<a class="list-group-item active">Administrare Financiara</a>
				<?php if($_SESSION['useradmin'] >= $minlevel['donations']) { ?>	<a href="?page=admin_donations" class="list-group-item">Administrare donatii</a><?php } ?>
				<?php if($_SESSION['useradmin'] >= $minlevel['addcoins']) { ?>	<a href="?page=admin_addcoins" class="list-group-item">Adauga monede</a><?php } ?>
			</ul>
		<?php } ?>

		<?php if($_SESSION['useradmin'] >= $minlevel['mods']) { ?>
			<ul class="list-group">
				<a class="list-group-item active">Module suplimentare</a>
				<?php if($_SESSION['useradmin'] >= $minlevel['logs']) { ?>	<a href="?page=admin_gmlog" class="list-group-item">LOG comenzi GM</a><?php } ?>
			</ul>
		<?php } ?>
	</div>
</div>
<?php 
} else {
	header('Location: ?page=home');
}
?>