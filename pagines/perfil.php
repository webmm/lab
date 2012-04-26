<div class="pagina-perfil">

	<h1>Modificar el perfil</h1>
	
	<form action="" id="perfilForm" method="post" accept-charset="utf-8">
		<label for="nom">Nom</label>
		<input type="text" name="nom" value="<?php echo $usuari->nom ?>" id="nom">
		
		<label for="cognoms">Cognoms</label>
		<input type="text" name="cognoms" value="<?php echo $usuari->cognoms ?>" id="cognoms">
		
		<label for="email">Email</label>
		<input type="email" name="email" value="<?php echo $usuari->email ?>" id="email">
		
		<label for="pass">Password</label>
		<input type="password" name="pass" value="" id="pass">
		
		<label for="pass2">Confirmar password</label>
		<input type="password" name="pass2" value="" id="pass2">
		
		<div class="actions">
			<input type="submit" class="btn btn-primary" value="Enviar">
		</div>
	</form>

</div>