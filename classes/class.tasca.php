<?php

class Tasca{

	public function nova($ip,$n,$deadline) {
		$id_usuari = Usuari::entrat();
		$pid_projecte = General::cleantext($ip);
		$nom = General::cleantext($n);
		$deadline = General::cleantext($deadline);

		if(!$pid_projecte||!$nom||!$id_usuari) {
			return 0;
			die();
		}

		// Crear ID publica

		$valid = false;

		while(!$valid) {
			$string = "";
			$possible = "0123456789";
			$i = 0;
			while ($i <= 10) {
				$char = substr($possible, mt_rand(0, strlen($possible)-1), 1);
				$string .= $char;
				$i++;
			}
			
			$sql = mysql_query("SELECT pid FROM tasques WHERE pid = '$string'");
			if(mysql_num_rows($sql)>0) $valid = false;
			else $valid = true;
		}

		$projecte = Projecte::getFromPid($pid_projecte);
		$id_projecte = $projecte->id;
		
		if(!$deadline) mysql_query("INSERT INTO tasques (pid,nom,id_usuari,id_projecte) VALUES ('$string','$nom','$id_usuari','$id_projecte')") or die(0);
		else mysql_query("INSERT INTO tasques (pid,nom,id_usuari,id_projecte,deadline) VALUES ('$string','$nom','$id_usuari','$id_projecte','$deadline')") or die(0);
		return 1;
	}

	public function edit($id,$n) {
		$nom = General::cleantext($n);
		mysql_query("UPDATE tasques SET nom = '$nom' WHERE id = '$id'");
	}
	
	public function delete($pid) {
		
		mysql_query("DELETE from tasques WHERE pid = '$pid'");
	}

	public function get($id) {
		$sql = mysql_query("SELECT * FROM tasques WHERE id = '$id'");
		if(mysql_num_rows($sql)<1) return false;
		else return mysql_fetch_object($sql);
	}

	public function getFromPid($pid) {
		$sql = mysql_query("SELECT * FROM tasques WHERE pid = '$pid'");
		if(mysql_num_rows($sql)<1) return false;
		else return mysql_fetch_object($sql);
	}
	
	public function assignarProjecte($pidtasca,$pidprojecte) {
		$tasca = Tasca::getFromPid($pidtasca);
		$projecte = Projecte::getFromPid($pidprojecte);
		$id = $tasca->id;
		$id_projecte = $projecte->id;
		
		mysql_query("UPDATE tasques SET id_projecte = '$id_projecte' WHERE id = '$id'");
	}

	public function getList($id_projecte) {
		$sql = mysql_query("SELECT * FROM tasques WHERE id_projecte = '$id_projecte' ORDER BY CASE WHEN deadline IS NULL THEN 1 ELSE 0 END, deadline");
		if(mysql_num_rows($sql)>0) {
			while($row = mysql_fetch_object($sql)) {
				$resultat[] = $row;
			}
			return $resultat;
		} else {
			return false;
		}
	}
	
	public function getListAll() {
		$sql = mysql_query("SELECT * FROM tasques ORDER BY CASE WHEN deadline IS NULL THEN 1 ELSE 0 END, deadline");
		if(mysql_num_rows($sql)>0) {
			while($row = mysql_fetch_object($sql)) {
				$resultat[] = $row;
			}
			return $resultat;
		} else {
			return false;
		}
	}
	
	public function getListMes($mes,$projecte=null) {
		if(!$projecte) $sql = mysql_query("SELECT * FROM tasques WHERE deadline IS NOT NULL AND MONTH(deadline) = $mes");
		else $sql = mysql_query("SELECT * FROM tasques WHERE deadline IS NOT NULL AND MONTH(deadline) = $mes AND id_projecte = '$id_projecte'");
		
		if(mysql_num_rows($sql)>0) {
			while($row = mysql_fetch_object($sql)) {
				$resultat[] = $row;
			}
			return $resultat;
		} else {
			return false;
		}
	}
	
	public function getListDia($dia,$mes,$any,$projecte=null) {
		if(!$projecte) $sql = mysql_query("SELECT * FROM tasques WHERE deadline IS NOT NULL AND MONTH(deadline) = $mes AND YEAR(deadline) = $any AND DAY(deadline) = $dia");
		else $sql = mysql_query("SELECT * FROM tasques WHERE deadline IS NOT NULL AND MONTH(deadline) = $mes AND YEAR(deadline) = $any AND DAY(deadline) = $dia AND id_projecte = '$id_projecte'");
		
		if(mysql_num_rows($sql)>0) {
			while($row = mysql_fetch_object($sql)) {
				$resultat[] = $row;
			}
			return $resultat;
		} else {
			return false;
		}
	}

}

?>