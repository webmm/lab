<?php 

Usuari::autoLogin();

if(Usuari::entrat()) {
	$usuari = Usuari::get(Usuari::entrat());
} else {
	General::redirigir("/login/");
}

 ?>