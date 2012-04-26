$(document).ready(function() {
	/* gestió ajax de les pàgines *//*
	$.ajaxSetup ({
	    cache: false
	});
	
	carregarSidebar();
	setInterval("checkAnchor()", 300);*/

	/* pàgina projectes */

	$(".afegir-projecte").click(function(e) {
		$.ajax({
		  url: "/pagines/nouprojecte.php",
		  context: document.body,
		  success: function(data){
			$('body').toggleClass('lightbox');
		    $('body').prepend(data);
		  }
		});
		e.preventDefault();
	});
	
	$(".nouprojecte-tancar").live("click", function(e) {
		tancarNouProjecte();
		e.preventDefault();
	});
	
	$("#nouprojecteform").live("submit", function(e) {
		e.preventDefault();

		var nom = $("#nom").val();
		var comentaris = $("#comentaris").val();
		var data = 'nom='+nom+'&descripcio='+comentaris;

		$.ajax({
			type: 'POST',
			url: '/ajax/nouprojecte.php',
			data: data,
			success: function(data){
				if(data==1) {
					window.location = "/projectes/";
				} else {
					alert("Algun error... Properament gestió d'errors");
				}
			}
		});
	});

	/* pàgina projecte */

	$(".afegir-tasca").click(function(e) {
		$.ajax({
		  url: "/pagines/novatasca.php",
		  context: document.body,
		  success: function(data){
			$('body').toggleClass('lightbox');
		    $('body').prepend(data);
			formularis();
			carregarGMaps();
			$('#data').datepicker({ dateFormat: 'dd-mm-yy' });
		  }
		});
		e.preventDefault();
	});
	
	$(".novatasca-tancar").live("click", function(e) {
		tancarNovaTasca();
		e.preventDefault();
	});
	
	$("#novatascaform").live("submit", function(e) {
		e.preventDefault();

		var nom = $("#nom").val();
		var projecte = $("#projecte").val();

		var data = 'nom='+nom+'&projecte='+projecte;

		$.ajax({
			type: 'POST',
			url: '/ajax/novatasca.php',
			data: data,
			success: function(data){
				if(data==1) {
					window.location = "/projectes/"+projecte+"/";
				} else {
					alert("Algun error... Properament gestió d'errors");
				}
			}
		});
	});

})

function tot() {
	
	console.log(apartat);
	
	//llistarProjectesSidebar();
	
	//if(apartat=='projectes') llistarProjectesApartat();
	
	
	
	$("#comentartasca").live("submit", function(e) {
		var dades = $('#comentartasca').serialize();
		alert(dades);
		/* todo: fer que es mostri a sota els altres */
	
		e.preventDefault();
	})
	
}

function llistarProjectesApartat() {
	var html = "";
	for (var i = projectes.length - 1; i >= 0; i--){
		html += '<li><a href="/#/projecte/'+i+'">'+projectes[i].getNom()+'</a></li>'
	};
	
	$('#portada-llistatasques').html(html);
}

function llistarProjectesSidebar() {
	var html = "";
	for (var i = projectes.length - 1; i >= 0; i--){
		html += '<li><a href="/#/projecte/'+i+'">'+projectes[i].getNom()+'</a></li>'
	};
	
	$('#sidebar-llistaprojectes').html(html);
}

function tancarNovaTasca() {
	$('body').removeClass('lightbox');
	$('.novatasca').remove();
}

function tancarNouProjecte() {
	$('body').removeClass('lightbox');
	$('.nouprojecte').remove();
}

function carregarSidebar() {
	$("#sidebar").load("includes/sidebar.html");
}

var currentAnchor = null;  
var apartat = null;

function checkAnchor(){  
    if(currentAnchor != document.location.hash){  
        currentAnchor = document.location.hash;  
        if(!currentAnchor)  {
			apartat = "home";
		}
        else  
        {  
            var splits = currentAnchor.substring(1).split('/');  
            apartat = splits[1];  

			// todo: fer que segons sigui la secció que carregui amb els paràmetres la pàgina
        }  

		var pagina = "pagines/"+apartat+".html"; 
		
		$("#notificacio-carregant").show();
		$('#app').load(pagina, function(response, status) {
			if (status == "error") {
			    $("#notificacio-carregant").fadeOut();
				$("#notificacio-error").show().delay(1000).fadeOut();
			} else {
				$("#sidebar").find("li").removeClass('actiu').find("i").removeClass('icon-white');
				$("#sidebar-"+apartat).find("i").addClass('icon-white').parent().parent().addClass('actiu');
				$("#notificacio-carregant").fadeOut();
				
				tot();
			}
		});
    }  
};

function recarregarPagina() {
	
	currentAnchor = document.location.hash; 
	var splits = currentAnchor.substring(1).split('/');  
    apartat = splits[1];
	var pagina = "pagines/"+apartat+".html"; 
	
	$("#notificacio-carregant").show();
	$('#app').load(pagina, function(response, status) {
		if (status == "error") {
		    $("#notificacio-carregant").fadeOut();
			$("#notificacio-error").show().delay(1000).fadeOut();
		} else {
			$("#sidebar").find("li").removeClass('actiu').find("i").removeClass('icon-white');
			$("#sidebar-"+apartat).find("i").addClass('icon-white').parent().parent().addClass('actiu');
			$("#notificacio-carregant").fadeOut();
			
			tot();
		}
	});
}

function formularis() {

	// getElementById
	function $id(id) {
		return document.getElementById(id);
	}


	// output information
	function Output(msg) {
		var m = $id("messages");
		m.innerHTML = msg + m.innerHTML;
	}


	// file drag hover
	function FileDragHover(e) {
		e.stopPropagation();
		e.preventDefault();
		e.target.className = (e.type == "dragover" ? "hover" : "");
	}


	// file selection
	function FileSelectHandler(e) {

		// cancel event and hover styling
		FileDragHover(e);

		// fetch FileList object
		var files = e.target.files || e.dataTransfer.files;

		// process all File objects
		for (var i = 0, f; f = files[i]; i++) {
			ParseFile(f);
		}

	}
	
	// output file information
	function ParseFile(file) {

		/* todo: fer que es carreguin els fitxer a una carpeta temp */
		
		var m = document.getElementById("files");
		if(m.value) m.value = m.value + "," + file.name;
		else m.value = file.name;
		
		
		Output(
			"<p>File information: <strong>" + file.name +
			"</strong> type: <strong>" + file.type +
			"</strong> size: <strong>" + file.size +
			"</strong> bytes</p>"
		);

	}


	// initialize
	function Init() {

		var fileselect = $id("fileselect"),
			filedrag = $id("filedrag"),
			submitbutton = $id("submitbutton");

		// file select
		fileselect.addEventListener("change", FileSelectHandler, false);

		// is XHR2 available?
		var xhr = new XMLHttpRequest();
		if (xhr.upload) {

			// file drop
			filedrag.addEventListener("dragover", FileDragHover, false);
			filedrag.addEventListener("dragleave", FileDragHover, false);
			filedrag.addEventListener("drop", FileSelectHandler, false);
			filedrag.style.display = "block";

			// remove submit button
			//submitbutton.style.display = "none";
		}
		
	}

	// call initialization file
	if (window.File && window.FileList && window.FileReader) {
		Init();
	}


};

// google maps

function carregarGMaps() {
  var script = document.createElement("script");
  script.type = "text/javascript";
  script.src = "http://maps.googleapis.com/maps/api/js?key=AIzaSyAlzuZEwOQyzQ-8yucxDm-FtgGxcgi2p-g&sensor=false&callback=initialize";
  document.body.appendChild(script);
}

var geocoder;
  var map;
	var marker;
  function initialize() {
    geocoder = new google.maps.Geocoder();
    var latlng = new google.maps.LatLng(41.47186380000001, 2.0821392000000287);
    var myOptions = {
      zoom: 13,
      center: latlng,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    }
    map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
	marker = new google.maps.Marker({
            map: map
    });
  }

  function codeAddress() {
    var address = document.getElementById("address").value;
    geocoder.geocode( { 'address': address}, function(results, status) {
      if (status == google.maps.GeocoderStatus.OK) {
        map.setCenter(results[0].geometry.location);
		map.setZoom(13);
      	document.getElementById("novatasca-coord").value = results[0].geometry.location;
		
      } else {
        alert("Geocode was not successful for the following reason: " + status);
      }
    });
  }
