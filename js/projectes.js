$(document).ready(function() {

});

function projecte(nom,comentaris) {
	this.nom = nom;
	this.comentaris = comentaris;
	
	/* exemple de funció */
	
	this.getNom = function() {
		return this.nom;
	}
} 

proj1 = new projecte("Apple","Comentaris Apple");
proj2 = new projecte("Microsoft","Comentaris Microsoft");
proj3 = new projecte("Samsung","Comentaris Samsung");
proj4 = new projecte("HTC","Comentaris HTC");

var projectes = [proj1,proj2,proj3,proj4];