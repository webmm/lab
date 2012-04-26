<?php include 'includes/init.php'; ?>

<?php

if($_POST) {
	Usuari::editaUsuari($_POST['nom'],$_POST['cognoms'],$_POST['email'],$_POST['pass']);
	$usuari = Usuari::get($usuari->id);
}

?>

<?php include 'includes/header.php'; ?>
<div class="wrapper full">
	<?php include 'includes/sidebar.php'; ?>

	<div id="app">
	  <?php include 'pagines/perfil.php'; ?>
	</div>
</div>

<?php include 'includes/footer.php'; ?>