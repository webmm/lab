<div id="sidebar">
	<a href="#" id="logo-app">Logo placeholder</a>

	<ul>
		<li<?php General::activarSidebar("") ?>><a href="/" id="sidebar-home"><i class="icon-home"></i><span>Inici</span></a></li>
		<li<?php General::activarSidebar("tasques") ?>><a href="/tasques/" id="sidebar-tasques"><i class="icon-ok"></i><span>Tasques</span> <div>1</div></a></li>
		<li<?php General::activarSidebar("calendari") ?>><a href="/calendari/" id="sidebar-calendari"><i class="icon-calendar"></i><span>Calendari</span></a></li>
		<li<?php General::activarSidebar("projectes") ?>><a href="/projectes/" id="sidebar-projectes"><i class="icon-th-list"></i><span>Projectes</span></a></li>
		<!--<li><a href="/#/contactes" id="sidebar-contactes"><i class="icon-user"></i><span>Contactes</span></a></li>-->
	</ul>

	<div class="separador"></div>

	<ul id="sidebar-llistaprojectes">
		<?php 
			$projectes = Projecte::getList();
			foreach ($projectes as $projecte) {
				echo '<li><a href="/projectes/'.$projecte->pid.'/" id="sidebar-projecte5"><span>'.$projecte->nom.'</span></a></li>';
			}
		?>		
	</ul>
</div>