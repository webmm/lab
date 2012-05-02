<div class="pato">
	<div class="titol">Benvingut <?php echo $usuari->nom." ".$usuari->cognoms ?></div>
  
	<p>Som en David Torras i l'Albert Olivé, estudiants de 3r Grau de la carrera en Informàtica i Serveis. El nostre projecte consisteix en crear un gestor de tasques des d'una interfície molt intuïtiva, accessible i clara. A continuació, us fem un breu tutorial de l'eina per tal de què pogueu començar-la a utilitzar. <br><br>
		Podeu veure el tutorial aquí: <a href="/pagines/presentacio.html" target="_blank">Veure </a>
	</p>

</div>

<ul class="llistaitems tasques portada">
		<?php include("ajax/llistaTasquesGeneral.php"); ?>
</ul>