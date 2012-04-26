<?php 
include $_SERVER['DOCUMENT_ROOT'].'/includes/init.php';
?>

<div class="modal novatasca">
	<a class="close novatasca-tancar">×</a>
	<form id="novatascaform" enctype="multipart/form-data">
	<div class="modal-body">
			<label for="nom">Nom</label>
			<input type="text" name="nom" id="nom">
	
			<select name="projecte" id="projecte">
				<?php 
					$projectes = Projecte::getList();
					foreach ($projectes as $projecte) {
						echo '<option value="'.$projecte->pid.'">'.$projecte->nom.'</option>';
					}
				?>	
			</select>
	
			<select name="responsable" id="responsable">
				<option value="0">Responsable 0</option>
				<option value="1">Responsable 1</option>
				<option value="2">Responsable 2</option>
				<option value="3">Responsable 3</option>
			</select>
	
			<input type="text" name="data" placeholder="Data entrega" id="data">

			<input id="address" name="loc" type="text" value="" placeholder="Localització...">
			<input id="novatasca-coord" name="coor" type="text" value="" readonly="readonly">
			<input type="button" value="Mostrar al mapa" onclick="codeAddress()">
			<div id="map_canvas" style="height:150px;width:500px"></div>
	
			<label for="adjunt">Fitxer adjunt</label>
			
			<div id="filedrag">Fitxer adjunt. <input type="file" id="fileselect" name="fileselect[]" multiple="multiple" /></div>
			
			<div id="messages"></div>
			
			<input id="files" name="files" type="hidden" value="">

		
	</div>
	<div class="modal-footer">
		<input type="submit" class="btn btn-primary" value="Crear tasca" />
		<a href="#" class="btn novatasca-tancar">Close</a>
	</div>
	</form>
</div>