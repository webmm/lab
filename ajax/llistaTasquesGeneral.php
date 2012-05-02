<?php
if(isset($_GET['ajax'])) {
	$nosession = true;
	include $_SERVER['DOCUMENT_ROOT'].'/includes/init.php';	
}
?>
<li><a href="#" class="afegir afegir-tasca li-btn">+ Afegir tasca</a></li>
<?php 
	$tasques = Tasca::getListAll();
	foreach ($tasques as $tasca) {
		$projecte = Projecte::get($tasca->id_projecte);
		echo '<li><a data-id="'.$tasca->pid.'" href="/tasques/'.$tasca->pid.'/"><span class="handler">::</span> '.$tasca->nom.' <span class="projecte">'.$projecte->nom.'</span></a></li>';
	}
?>