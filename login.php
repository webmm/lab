<?php
$nosession = true;
include 'includes/init.php';


if(Usuari::entrat()){
	header("Location: http://".General::base_url."/");
}

include 'includes/header_logout.php';

?>

<div id="pagina-login">
això si
addthis

	<div class="login">
	<h2>Login</h2>

	<form method="post" id="login-form" accept-charset="utf-8">
	
		<label for="email">Email</label>
		<input type="email" name="email" id="email">

		<label for="pass">Contrasenya</label>
		<input type="password" name="pass" id="pass">
		<span class="help-inline"><a href="/recuperar">He oblidat la meva contrasenya</a></span>
	
        <label for="recordar" class="checkbox">
        <input type="checkbox" name="recordar" value="1" id="recordar"> Recordar usuari
		<span class="help-block">No activar en ordinadors públics</span>
		</label>

		<input type="submit" value="Iniciar sessió" name="login" class="btn btn-primary">
	</form>

	</div>

	<div class="registrar">

	<h2>Registre</h2>
	

	<form method="post" id="registrar-form" accept-charset="utf-8">
	
		<label for="nom">Nom</label>
		<input type="text" name="nom" id="nom">
		
		<label for="cognom">Cognoms</label>
		<input type="text" name="cognoms" id="cognoms">

		<label for="email1">Email</label>
		<input type="email" name="email" id="email">
		
		<label for="email2">Confirmar l'email</label>
		<input type="email" name="email2" id="email2">
	
		<div class="clearfix">
		<label for="pass1">Contrasenya</label>
		<input type="password" name="pass" id="pass">
		
		<div class="clearfix">
		<label for="pass2">Confirmar la contrasenya</label>
		<input type="password" name="pass2" id="pass2">
	
		<input type="submit" value="Registrar-me" name="register" class="btn btn-primary">
	</form>

	</div>

</div>

<?php include 'includes/footer_logout.php'; ?>