<?php if (!isset($_GET['id'])): ?>
<ul class="llistaitems">
	<li><a href="#" class="afegir afegir-projecte li-btn">+ Afegir projecte</a></li>
	<?php 
		$projectes = Projecte::getList();
		foreach ($projectes as $projecte) {
			echo '<li><a href="/projectes/'.$projecte->pid.'/"><span>'.$projecte->nom.'</span></a></li>';
		}
	?>	
</ul>
<?php else: ?>
<?php $projecte = Projecte::getFromPid($_GET['id']) ?>
<ul class="llistaitems">
	<li><a href="#" class="afegir afegir-tasca li-btn">+ Afegir tasca</a></li>
	<?php 
		$tasques = Tasca::getList($projecte->id);
		if($tasques) {
			foreach ($tasques as $tasca) {
				echo '<li><a href="/tasques/'.$tasca->pid.'/"><span>'.$tasca->nom.'</span></a></li>';
			}
		} else {
			echo "<li><a>No hi ha tasques</a></li>";
		}
	?>
<?php endif ?>