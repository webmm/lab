<?php if (!isset($_GET['id'])): ?>
<ul class="llistaitems">
		<li><a href="#" class="afegir afegir-tasca li-btn">+ Afegir tasca</a></li>
		<?php 
			$tasques = Tasca::getListAll();
			foreach ($tasques as $tasca) {
				echo '<li><a href="/tasques/'.$tasca->pid.'/"><span>'.$tasca->nom.'</span></a></li>';
			}
		?>	
</ul>
<?php else: ?>
<?php $tasca = Tasca::getFromPid($_GET['id']) ?>
<?php print_r($tasca) ?>
	<div class="pagina-tasca">
	
		<div class="tasca-capcalera">
			<label><input type="checkbox"><?php echo $tasca->nom ?></label>
			<a href="/tasques/">Tornar a la llista de tasques</a>
		</div>
	
		<dl class="tasca-meta">
			<dt>Creada:</dt>
			<dd><?php echo $tasca->data ?> per <a href="#"><?php echo $tasca->id_usuari ?></a></dd>
		
			<dt>Projecte</dt>
			<dd><?php echo $tasca->id_projecte ?></dd>
		
			<dt>Data límit</dt>
			<dd>15/02</dd>
		</dl>
	
		<div class="tasca-comentaris">
		
			<div class="comentari">
				<div class="meta">
					<a href="/#/usuaris/2">David Torras</a>
					<div>11/02. 11:43h</div>
				</div>
				<div class="text">
					<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam</p>
					<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam</p>
				</div>
			</div>
		
			<div class="comentari">
				<div class="meta">
					<a href="/#/usuaris/2">David Torras</a>
					<div>11/02. 11:43h</div>
				</div>
				<div class="text">
					<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam</p>
					<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam</p>
				</div>
			</div>
		
		</div>
	
		<div class="tasca-afegircomentari">
			<h2>Comentar la tasca</h2>
		
			<form action="#" method="post" id="comentartasca" accept-charset="utf-8">
				<textarea placeholder="Comentari..."></textarea>

				<p><input type="submit" value="Continue &rarr;"></p>
			</form>
		
		</div>
	
	</div>
<?php endif ?>