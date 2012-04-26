<!doctype html>
<!--
       ___               
      /\_ \              
      \//\ \      __     
        \ \ \   /'__`\   
         \_\ \_/\ \L\.\_ 
         /\____\ \__/.\_\
         \/____/\/__/\/_/               
       __                                    __                            
      /\ \                                  /\ \__  __                     
      \ \ \____     __     _ __   _ __    __\ \ ,_\/\_\    ___      __     
       \ \ '__`\  /'__`\  /\`'__\/\`'__\/'__`\ \ \/\/\ \ /' _ `\  /'__`\   
        \ \ \L\ \/\ \L\.\_\ \ \/ \ \ \//\  __/\ \ \_\ \ \/\ \/\ \/\ \L\.\_ 
         \ \_,__/\ \__/.\_\\ \_\  \ \_\\ \____\\ \__\\ \_\ \_\ \_\ \__/.\_\
          \/___/  \/__/\/_/ \/_/   \/_/ \/____/ \/__/ \/_/\/_/\/_/\/__/\/_/


                    /) /)               ,     /)         ,   /) 
               _   // (/_  _  __ _/_        _(/ _  _ _     _(/  
              (_(_(/_/_) _(/_/ (_(__  _(_  (_(_(_(_(/___(_(_(_  
-->
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title>La Barretina</title>
  <meta name="description" content="">

  <meta name="viewport" content="width=device-width">
  <link rel="stylesheet" href="/css/bootstrap.min.css" type="text/css" />
  <link rel="stylesheet" href="/js/libs/filedrag.css">
  <link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/css/style.css">


  <script src="/js/libs/modernizr-2.5.3.min.js"></script>
</head>
<body>
  <!--[if lt IE 7]><p class=chromeframe>Your browser is <em>ancient!</em> <a href="http://browsehappy.com/">Upgrade to a different browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to experience this site.</p><![endif]-->

	<div id="notification-center">
		<div class="info" id="notificacio-carregant" style="display:none">Carregant...</div>
		<div class="error" id="notificacio-error" style="display:none">Error al carregar</div>
	</div>

  <div id="top_bar">
    <div id="top_bar_inner">
		<div class="btn-group">
			<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
				El meu perfil
				<span class="caret"></span>
			</a>
			<ul class="dropdown-menu">
				<li><a href="/perfil/">Editar el meu perfil</a></li>
				<li class="sortir"><a href="/logout/">Sortir</a></li>
			</ul>
		</div>
		
		<a href="#" class="afegir-tasca btn">Crear tasca</a>
	</div>
  </div>