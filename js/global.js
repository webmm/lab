$(document).ready(function() {

	var paginaactual = window.location.pathname.substring(1, window.location.pathname.lastIndexOf('/'));
	
	midaApp();
	
	$(window).resize(function(){
        midaApp();
    });
	
	/* pàgina calendari */
	
	if(paginaactual=='calendari') {
		
		currentAnchor = document.location.hash;  
        var splits = currentAnchor.substring(1).split('/');
		var mes = splits[1];
		var any = splits[2];
		
		if(!mes) mes = (new Date).getMonth() + 1;
		if(!any) any = (new Date).getFullYear();
		
		carregarCalendari(mes,any);
		
		$(".next-month").click(function(e) {
			e.preventDefault();
			if(mes!=12) mes++;
			else {
				mes = 1;
				any++;
			}
			carregarCalendari(mes,any);
		});
		
		$(".prev-month").click(function(e) {
			e.preventDefault();
			if(mes!=1) mes--;
			else {
				mes = 12;
				any--;
			}
			carregarCalendari(mes,any);
		});

		$(window).resize(function(){
	        midaCalendari(any,mes);
	    });
	}
	
	function carregarCalendari(mes,any) {
		location.hash = "#/"+mes+"/"+any+"/";
		var monthNames = [ "Gener", "Febrer", "Març", "Abril", "Maig", "Juny",
		    "Juliol", "Agost", "Setembre", "Octubre", "Novembre", "Desembre" ];
		
		$.ajax({
			type: 'POST',
			url: "/ajax/calendari.php",
			data: "mes="+mes+"&any="+any,
			success: function(data){
				$('#calendari').html(data);
				$(".current-month").html(monthNames[mes-1]);
				midaCalendari(any,mes);
			}
		});
		
		$("#calendari").fadeIn("slow");
	}

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
	

	
	$( ".llistaitems.tasques li a" ).draggable({ revert: true });
	$("#sidebar-llistaprojectes li").droppable({
		activeClass: "ui-state-hover",
		hoverClass: "ui-state-active",
		tolerance: "pointer",
		drop: function( event, ui ) {
			var pidtasca = ui.draggable.attr("data-id");
			var pidprojecte = $(this).find("a").attr("data-id");
			var nomprojecte = $(this).find("a").text();
			//alert("Afegirem la tasca "+pidtasca+" al projecte "+pidprojecte);
			
			var data = 'pid_tasca='+pidtasca+'&pid_projecte='+pidprojecte;

			$.ajax({
				type: 'POST',
				url: '/ajax/assignarProjecte.php',
				data: data,
				success: function(data){
					ui.draggable.find(".projecte").html(nomprojecte);
				}
			});
			
		}
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
			$('#data').datepicker({ dateFormat: 'yy-mm-dd' });
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
		var deadline = $("#data").val();

		var data = 'nom='+nom+'&projecte='+projecte+"&deadline="+deadline;

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

	/* pàigna de perfil */
	
	$("#perfilForm").submit(function(e) {
		var pass = $("#pass");
		if(pass.val()!='') pass.val(hex_md5(pass.val()));
		return true;
	});

});

function getWeekOfMonth(any,mes) {
	var firstOfMonth = new Date(any, mes-1, 0);
	var lastOfMonth = new Date(any, mes, 0);
	
	var used = firstOfMonth.getDay() + lastOfMonth.getDate();
	//alert(""+firstOfMonth.getDay() +" "+ lastOfMonth.getDate()+" "+Math.ceil( used / 7));
	return Math.ceil( used / 7);
}

function midaCalendari(any,mes) {
	var h = $(window).height();
	var topbar = 40;
	var dies = 22;
	var padding = 10;
	var files = getWeekOfMonth(any, mes);
	//console.log(files);
	var borders = 7;
	
	var midaFila = Math.round(((h-topbar-dies-borders)/files)-2*padding)+"px";
	
	$("#calendari td").css("height",midaFila);
}

function midaApp() {
	var h = $(window).height();
	var topbar = 40;
	
	var midaApp = Math.round(h-topbar)+"px";
	
	$("#sidebar").css("height",midaApp);
}

function tancarNovaTasca() {
	$('body').removeClass('lightbox');
	$('.novatasca').remove();
}

function tancarNouProjecte() {
	$('body').removeClass('lightbox');
	$('.nouprojecte').remove();
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


/* coses md5 */

  /*
* A JavaScript implementation of the RSA Data Security, Inc. MD5 Message
* Digest Algorithm, as defined in RFC 1321.
* Version 2.1 Copyright (C) Paul Johnston 1999 - 2002.
* Other contributors: Greg Holt, Andrew Kepert, Ydnar, Lostinet
* Distributed under the BSD License
* See http://pajhome.org.uk/crypt/md5 for more info.
*/

/*
* Configurable variables. You may need to tweak these to be compatible with
* the server-side, but the defaults work in most cases.
*/
var hexcase = 0;  /* hex output format. 0 - lowercase; 1 - uppercase        */
var b64pad  = ""; /* base-64 pad character. "=" for strict RFC compliance  */
var chrsz  = 8;  /* bits per input character. 8 - ASCII; 16 - Unicode      */

/*
* These are the functions you'll usually want to call
* They take string arguments and return either hex or base-64 encoded strings
*/
function hex_md5(s){ return binl2hex(core_md5(str2binl(s), s.length * chrsz));} // la que hem d'usar
function b64_md5(s){ return binl2b64(core_md5(str2binl(s), s.length * chrsz));}
function str_md5(s){ return binl2str(core_md5(str2binl(s), s.length * chrsz));}
function hex_hmac_md5(key, data) { return binl2hex(core_hmac_md5(key, data)); }
function b64_hmac_md5(key, data) { return binl2b64(core_hmac_md5(key, data)); }
function str_hmac_md5(key, data) { return binl2str(core_hmac_md5(key, data)); }

/*
* Perform a simple self-test to see if the VM is working
*/
function md5_vm_test()
{
  return hex_md5("abc") == "900150983cd24fb0d6963f7d28e17f72";
}

/*
* Calculate the MD5 of an array of little-endian words, and a bit length
*/
function core_md5(x, len)
{
  /* append padding */
  x[len >> 5] |= 0x80 << ((len) % 32);
  x[(((len + 64) >>> 9) << 4) + 14] = len;

  var a =  1732584193;
  var b = -271733879;
  var c = -1732584194;
  var d =  271733878;

  for(var i = 0; i < x.length; i += 16)
  {
    var olda = a;
    var oldb = b;
    var oldc = c;
    var oldd = d;

    a = md5_ff(a, b, c, d, x[i+ 0], 7 , -680876936);
    d = md5_ff(d, a, b, c, x[i+ 1], 12, -389564586);
    c = md5_ff(c, d, a, b, x[i+ 2], 17,  606105819);
    b = md5_ff(b, c, d, a, x[i+ 3], 22, -1044525330);
    a = md5_ff(a, b, c, d, x[i+ 4], 7 , -176418897);
    d = md5_ff(d, a, b, c, x[i+ 5], 12,  1200080426);
    c = md5_ff(c, d, a, b, x[i+ 6], 17, -1473231341);
    b = md5_ff(b, c, d, a, x[i+ 7], 22, -45705983);
    a = md5_ff(a, b, c, d, x[i+ 8], 7 ,  1770035416);
    d = md5_ff(d, a, b, c, x[i+ 9], 12, -1958414417);
    c = md5_ff(c, d, a, b, x[i+10], 17, -42063);
    b = md5_ff(b, c, d, a, x[i+11], 22, -1990404162);
    a = md5_ff(a, b, c, d, x[i+12], 7 ,  1804603682);
    d = md5_ff(d, a, b, c, x[i+13], 12, -40341101);
    c = md5_ff(c, d, a, b, x[i+14], 17, -1502002290);
    b = md5_ff(b, c, d, a, x[i+15], 22,  1236535329);

    a = md5_gg(a, b, c, d, x[i+ 1], 5 , -165796510);
    d = md5_gg(d, a, b, c, x[i+ 6], 9 , -1069501632);
    c = md5_gg(c, d, a, b, x[i+11], 14,  643717713);
    b = md5_gg(b, c, d, a, x[i+ 0], 20, -373897302);
    a = md5_gg(a, b, c, d, x[i+ 5], 5 , -701558691);
    d = md5_gg(d, a, b, c, x[i+10], 9 ,  38016083);
    c = md5_gg(c, d, a, b, x[i+15], 14, -660478335);
    b = md5_gg(b, c, d, a, x[i+ 4], 20, -405537848);
    a = md5_gg(a, b, c, d, x[i+ 9], 5 ,  568446438);
    d = md5_gg(d, a, b, c, x[i+14], 9 , -1019803690);
    c = md5_gg(c, d, a, b, x[i+ 3], 14, -187363961);
    b = md5_gg(b, c, d, a, x[i+ 8], 20,  1163531501);
    a = md5_gg(a, b, c, d, x[i+13], 5 , -1444681467);
    d = md5_gg(d, a, b, c, x[i+ 2], 9 , -51403784);
    c = md5_gg(c, d, a, b, x[i+ 7], 14,  1735328473);
    b = md5_gg(b, c, d, a, x[i+12], 20, -1926607734);

    a = md5_hh(a, b, c, d, x[i+ 5], 4 , -378558);
    d = md5_hh(d, a, b, c, x[i+ 8], 11, -2022574463);
    c = md5_hh(c, d, a, b, x[i+11], 16,  1839030562);
    b = md5_hh(b, c, d, a, x[i+14], 23, -35309556);
    a = md5_hh(a, b, c, d, x[i+ 1], 4 , -1530992060);
    d = md5_hh(d, a, b, c, x[i+ 4], 11,  1272893353);
    c = md5_hh(c, d, a, b, x[i+ 7], 16, -155497632);
    b = md5_hh(b, c, d, a, x[i+10], 23, -1094730640);
    a = md5_hh(a, b, c, d, x[i+13], 4 ,  681279174);
    d = md5_hh(d, a, b, c, x[i+ 0], 11, -358537222);
    c = md5_hh(c, d, a, b, x[i+ 3], 16, -722521979);
    b = md5_hh(b, c, d, a, x[i+ 6], 23,  76029189);
    a = md5_hh(a, b, c, d, x[i+ 9], 4 , -640364487);
    d = md5_hh(d, a, b, c, x[i+12], 11, -421815835);
    c = md5_hh(c, d, a, b, x[i+15], 16,  530742520);
    b = md5_hh(b, c, d, a, x[i+ 2], 23, -995338651);

    a = md5_ii(a, b, c, d, x[i+ 0], 6 , -198630844);
    d = md5_ii(d, a, b, c, x[i+ 7], 10,  1126891415);
    c = md5_ii(c, d, a, b, x[i+14], 15, -1416354905);
    b = md5_ii(b, c, d, a, x[i+ 5], 21, -57434055);
    a = md5_ii(a, b, c, d, x[i+12], 6 ,  1700485571);
    d = md5_ii(d, a, b, c, x[i+ 3], 10, -1894986606);
    c = md5_ii(c, d, a, b, x[i+10], 15, -1051523);
    b = md5_ii(b, c, d, a, x[i+ 1], 21, -2054922799);
    a = md5_ii(a, b, c, d, x[i+ 8], 6 ,  1873313359);
    d = md5_ii(d, a, b, c, x[i+15], 10, -30611744);
    c = md5_ii(c, d, a, b, x[i+ 6], 15, -1560198380);
    b = md5_ii(b, c, d, a, x[i+13], 21,  1309151649);
    a = md5_ii(a, b, c, d, x[i+ 4], 6 , -145523070);
    d = md5_ii(d, a, b, c, x[i+11], 10, -1120210379);
    c = md5_ii(c, d, a, b, x[i+ 2], 15,  718787259);
    b = md5_ii(b, c, d, a, x[i+ 9], 21, -343485551);

    a = safe_add(a, olda);
    b = safe_add(b, oldb);
    c = safe_add(c, oldc);
    d = safe_add(d, oldd);
  }
  return Array(a, b, c, d);

}

/*
* These functions implement the four basic operations the algorithm uses.
*/
function md5_cmn(q, a, b, x, s, t)
{
  return safe_add(bit_rol(safe_add(safe_add(a, q), safe_add(x, t)), s),b);
}
function md5_ff(a, b, c, d, x, s, t)
{
  return md5_cmn((b & c) | ((~b) & d), a, b, x, s, t);
}
function md5_gg(a, b, c, d, x, s, t)
{
  return md5_cmn((b & d) | (c & (~d)), a, b, x, s, t);
}
function md5_hh(a, b, c, d, x, s, t)
{
  return md5_cmn(b ^ c ^ d, a, b, x, s, t);
}
function md5_ii(a, b, c, d, x, s, t)
{
  return md5_cmn(c ^ (b | (~d)), a, b, x, s, t);
}

/*
* Calculate the HMAC-MD5, of a key and some data
*/
function core_hmac_md5(key, data)
{
  var bkey = str2binl(key);
  if(bkey.length > 16) bkey = core_md5(bkey, key.length * chrsz);

  var ipad = Array(16), opad = Array(16);
  for(var i = 0; i < 16; i++)
  {
    ipad[i] = bkey[i] ^ 0x36363636;
    opad[i] = bkey[i] ^ 0x5C5C5C5C;
  }

  var hash = core_md5(ipad.concat(str2binl(data)), 512 + data.length * chrsz);
  return core_md5(opad.concat(hash), 512 + 128);
}

/*
* Add integers, wrapping at 2^32. This uses 16-bit operations internally
* to work around bugs in some JS interpreters.
*/
function safe_add(x, y)
{
  var lsw = (x & 0xFFFF) + (y & 0xFFFF);
  var msw = (x >> 16) + (y >> 16) + (lsw >> 16);
  return (msw << 16) | (lsw & 0xFFFF);
}

/*
* Bitwise rotate a 32-bit number to the left.
*/
function bit_rol(num, cnt)
{
  return (num << cnt) | (num >>> (32 - cnt));
}

/*
* Convert a string to an array of little-endian words
* If chrsz is ASCII, characters >255 have their hi-byte silently ignored.
*/
function str2binl(str)
{
  var bin = Array();
  var mask = (1 << chrsz) - 1;
  for(var i = 0; i < str.length * chrsz; i += chrsz)
    bin[i>>5] |= (str.charCodeAt(i / chrsz) & mask) << (i%32);
  return bin;
}

/*
* Convert an array of little-endian words to a string
*/
function binl2str(bin)
{
  var str = "";
  var mask = (1 << chrsz) - 1;
  for(var i = 0; i < bin.length * 32; i += chrsz)
    str += String.fromCharCode((bin[i>>5] >>> (i % 32)) & mask);
  return str;
}

/*
* Convert an array of little-endian words to a hex string.
*/
function binl2hex(binarray)
{
  var hex_tab = hexcase ? "0123456789ABCDEF" : "0123456789abcdef";
  var str = "";
  for(var i = 0; i < binarray.length * 4; i++)
  {
    str += hex_tab.charAt((binarray[i>>2] >> ((i%4)*8+4)) & 0xF) +
          hex_tab.charAt((binarray[i>>2] >> ((i%4)*8  )) & 0xF);
  }
  return str;
}

/*
* Convert an array of little-endian words to a base-64 string
*/
function binl2b64(binarray)
{
  var tab = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/";
  var str = "";
  for(var i = 0; i < binarray.length * 4; i += 3)
  {
    var triplet = (((binarray[i  >> 2] >> 8 * ( i  %4)) & 0xFF) << 16)
                | (((binarray[i+1 >> 2] >> 8 * ((i+1)%4)) & 0xFF) << 8 )
                |  ((binarray[i+2 >> 2] >> 8 * ((i+2)%4)) & 0xFF);
    for(var j = 0; j < 4; j++)
    {
      if(i * 8 + j * 6 > binarray.length * 32) str += b64pad;
      else str += tab.charAt((triplet >> 6*(3-j)) & 0x3F);
    }
  }
  return str;
}
