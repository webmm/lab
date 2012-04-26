<?php

class Projecte{

	public function nou($n,$d) {
		$id_usuari = Usuari::entrat();
		$nom = General::cleantext($n);
		$descripcio = General::cleantext($d);

		if(!$nom||!$descripcio||!$id_usuari) {
			return 0;
			die();
		}

		// Crear ID publica

		$valid = false;

		while(!$valid) {
			$string = "";
			$possible = "0123456789";
			$i = 0;
			while ($i < 10) {
				$char = substr($possible, mt_rand(0, strlen($possible)-1), 1);
				$string .= $char;
				$i++;
			}
			
			$sql = mysql_query("SELECT pid FROM projectes WHERE pid = '$string'");
			if(mysql_num_rows($sql)>0) $valid = false;
			else $valid = true;
		}

		mysql_query("INSERT INTO projectes (pid,nom,descripcio,id_usuari) VALUES ('$string','$nom','$descripcio','$id_usuari')") or die(0);
		return 1;
	}

	public function edit($id,$n,$d) {
		$nom = General::cleantext($n);
		$descripcio = General::cleantext($d);
		mysql_query("UPDATE projectes SET nom = '$nom', descripcio = '$descripcio' WHERE id = '$id'");
	}

	public function get($id) {
		$sql = mysql_query("SELECT * FROM projectes WHERE id = '$id'");
		if(mysql_num_rows($sql)<1) return false;
		else return mysql_fetch_object($sql);
	}

	public function getFromPid($pid) {
		$sql = mysql_query("SELECT * FROM projectes WHERE pid = '$pid'");
		if(mysql_num_rows($sql)<1) return false;
		else return mysql_fetch_object($sql);
	}

	public function getList() {
		$sql = mysql_query("SELECT * FROM projectes");
		while($row = mysql_fetch_object($sql)) {
			$resultat[] = $row;
		}
		return $resultat;
	}

}

?>