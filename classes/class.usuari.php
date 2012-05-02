<?php

class Usuari{

	/*
	id_usuari: autogenerat per phpMyAdmin
	email: email usuari
	pass: ve encriptat per javascript
	cookiepass: es genera cada vegada que es fa login per poder comprovar que una galeta és real
	*/

	private $id_usuari,$email,$pass,$cookiepass;
	private $nom,$cognoms;


	/*
	Crea usuari
	Retorna:
	1: OK
	ERRORS:
	2 = No és un email
	3 = Contrasenya amb caracters o mida no acceptables.
	4 = Emaill ja registrat
	*/
	public function nouUsuari($email,$pass,$nom=null,$cognoms=null) {
		
		$email = strtolower(General::cleantext($email));
		$pass = General::cleantext($pass);
		if(isset($nom)) $nom = General::cleantext($nom);
		if(isset($cognoms)) $cognoms = General::cleantext($cognoms);
		
		// Comprovem que és un email correcte
		
		$error = null;

		if (General::esEmail($email)==false)
		{
			return 2;
			die();
		}
		
		// Comprovem que la contrasenya és correcte
		
		if (General::esContrasenya($pass)==false)
		{
			return 3;
			die();
		}

		$sql = mysql_query("SELECT id FROM usuaris WHERE email = '$email'");

		if(mysql_num_rows($sql)>0) {
			return 4;
			die();
		}

		// Afegim l'usuari temporal a la base de dades
		mysql_query("INSERT INTO usuaris (email, pass, nom, cognoms) VALUES ('$email','$pass','$nom','$cognoms')") or die(mysql_error());
		
		//ID del nou usuari
		$nou_id = mysql_insert_id();
		
		return 1;

	}
	
	/*
	Edita usuari
	Retorna:
	1: OK
	ERRORS:
	2 = No és un email
	3 = Contrasenya amb caracters o mida no acceptables.
	*/
	public function editaUsuari($nom,$cognoms,$email,$pass=null) {
		
		if(isset($nom)) $nom = General::cleantext($nom);
		if(isset($cognoms)) $cognoms = General::cleantext($cognoms);
		if(isset($email)) $email = strtolower(General::cleantext($email));
		if(isset($pass)) $pass = General::cleantext($pass);
		$id_usuari = Usuari::entrat();
		
		// Comprovem que és un email correcte

		if (General::esEmail($email)==false) {
			return 2;
			die();
		}
		
		// Comprovem que la contrasenya és correcte
		
		if (General::esContrasenya($pass)==false) {
			return 3;
			die();
		}

		if($pass) {
			mysql_query("UPDATE usuaris SET nom='$nom', cognoms='$cognoms',email='$email',pass='$pass' WHERE id='$id_usuari'");
		} else {
			mysql_query("UPDATE usuaris SET nom='$nom', cognoms='$cognoms',email='$email' WHERE id='$id_usuari'");
		}
		
		return 1;

	}

		/*
	
	Login
	
	Retorna:
	1: OK
	5: email no existeix
	6: password incorrecte
	
	*/
	
	public function login($email,$contrasenya,$recordar=0) {
	
		$email = General::cleantext($email);
		$email = strtolower($email);
		$contrasenya = General::cleantext($contrasenya);
		//$contrasenya = md5($contrasenya);
		$recordar = General::cleantext($recordar);
		
		//Consultem coincidència de mail 
		$sql = mysql_query("SELECT * FROM usuaris WHERE (email='$email') LIMIT 1");
		//Número de files retornades
		$rows = mysql_num_rows($sql);
		
		if ($rows<=0) { //Si no existeix el correu
			return 5;
			exit;
		} else {
			
			$u = mysql_fetch_assoc($sql);
			
			if($contrasenya!=$u['pass']) { // Si pass no coincideix
				return 6;
				exit;
			} else { 

				//Creem la sessio per lusuari
				$_SESSION['usuari'] = $u['id'];
				$id = $u['id'];

				if($recordar) {
					//crear nou cpass
					$string = "";
					$possible = "0123456789bcdfghjkmnpqrstvwxyz";
					$i = 0;
					while ($i < 10) {
						$char = substr($possible, mt_rand(0, strlen($possible)-1), 1);
						$string .= $char;
						$i++;
					}
					$noupassword = $string;
					mysql_query("UPDATE usuaris SET cookiepass='$noupassword' WHERE id='$id'") or die (mysql_error());
					setcookie("usuari", $u['id'], time()+15*24*60*60, "/");
					setcookie("contrasenya", $noupassword, time()+15*24*60*60, "/");
				} else {
					setcookie("usuari","",time() - 42000);
					setcookie("contrasenya","",time() - 42000);
				}
				return 1;
				exit;
			}
		}
	}
		
	/*
	Logout
	*/
	
	public function logout(){
		$user_id = Usuari::entrat();
		$_SESSION['usuari']=0;
		unset($_SESSION["usuari"]);
		//tambe esborrem la cookie
		setcookie("usuari","",time() - 42000,"/");
		setcookie("contrasenya","",time() - 42000,"/");
		return 1;
	}
	
	public function test() {echo "test";}

	/*
	
	Autologin
	Comprova que si hi ha les cookies creades es creï la sessió
	
	*/
	
	public function autoLogin(){
		if(isset($_COOKIE['usuari'])&&isset($_COOKIE['contrasenya'])) {
			//busquem la cookie pass de la base de dades de user
			$user = $_COOKIE['usuari'];
			$u = mysql_query("SELECT * FROM usuaris WHERE (id='$user') LIMIT 1") or die (mysql_error());
			$u = mysql_fetch_assoc($u);
			$cpass = $u['cookiepass'];
			$coopass=$_COOKIE['contrasenya'];
			if($coopass==$cpass) //Si la cookie es igual a la bd
			{
				$_SESSION['usuari'] = $user;
			} else {
				// eliminem totes les dades
				$_COOKIE['usuari']=0;
				$_COOKIE['contrasenya']=0;
				setcookie("usuari","",time() - 42000);
				setcookie("contrasenya","",time() - 42000);
				$_SESSION['usuari']=0;
				unset($_SESSION["usuari"]);
			}
		}
	}
	
	/*

	Retorna la id d'usuari si ha iniciat sessió i 0 si no ha iniciat sessió

	*/

	public function entrat() {
		return (isset($_SESSION['usuari'])) ? $_SESSION['usuari'] : 0;
	}


	/*
	Solicitar nou password
	Retorna:
	1: OK
	7: no és email correcte

	*/
	public function enviarNouPsw($email) {
		$email = strtolower(General::cleantext($email));
		// Comprovem que és un email correcte
		if (General::esEmail($email)==false)
		{	
			return 7;
		}

		//ESBORREM SOLICITUDS ANTIGUES DE NOU PASSWORD
		$sql = mysql_query("SELECT * FROM usuaris WHERE email = '$email'");
		$u = mysql_fetch_assoc($sql);
		$user_id = $u['id'];
		$email = $u['email'];
		$nom = $u['nom'];
		mysql_query("DELETE FROM usuaris_recpsw WHERE user_id = '$user_id'") or die(mysql_error());

		// GENEREM NOU PASSWORD
		//crear noupassword
			$string = "";
  			$possible = "0123456789bcdfghjkmnpqrstvwxyz";
			$i = 0;
			while ($i < 8) {
			$char = substr($possible, mt_rand(0, strlen($possible)-1), 1);
			$string .= $char;
			$i++;
			}
			$nou_psw = $string;
			//encriptar nou password
			$nou_psw_cod = md5($nou_psw); 
			//crear codi confirmacio
			$codi = rand(10000,99999);
			//introduir base dades
			mysql_query("INSERT INTO usuaris_recpsw (user_id, new_psw, codi) VALUES ('$user_id', '$nou_psw_cod', '$codi')") or die(mysql_error());
			
			//Enviar e-mail de confirmamacio
		
			$subject = 'Confirma la teva nova contrasenya';
			$path = '/mail/recuperar.php';
			$opt = array(
				'nom' => $nom,
				'link' => "http://".General::base_url."/recuperar-activar/?code=".$codi."&email=".urlencode($email),
				'pass' => $nou_psw,
			);
			
			if(Mail::sendMail($email,$subject,$path,$opt)) {
				// mail ok
			} else {
				// mail ko
			}
			
		return 1;
	}
	
	
	/*
	Activar Nou Password
	Retorna:
	1: OK
	8: ERROR
	*/
	public function activarNouPsw($email,$code) {
		
		$email = strtolower(General::cleantext($email));
		$code = General::cleantext($code);
		
		$user = Usuari::getFromEmail($email);
		$id = $user->id;
	
		//Comprovar codi i email
		$sql = mysql_query("SELECT * FROM usuaris_recpsw WHERE user_id = '$id' AND codi = '$code'");
		if (mysql_num_rows($sql)<1) 
		{
			mysql_query("DELETE FROM usuaris_recpsw WHERE user_id = '$id'") or die(mysql_error());
			//ko
			return 8;
		}
				$u = mysql_fetch_assoc($sql);
				$new_psw = $u['new_psw'];
			// Actualitzem la nova contrasenya
			mysql_query("UPDATE usuaris SET pass = '$new_psw' WHERE id = '$id'") or die(mysql_error());
			//ESBORREM DE LA LLISTA DE TEMPORALS
			mysql_query("DELETE FROM usuaris_recpsw WHERE user_id = '$id'") or die(mysql_error());

			// ok
			return 1;
	}

	/*
	Retorna objecte amb totes les dades de l'usuari
	*/

	public function get($id){
		$sql = mysql_query("SELECT * FROM usuaris WHERE id = '$id'") or die(mysql_error());
		return mysql_fetch_object($sql);
	}
	
	/*
	Retorna objecte amb totes les dades de l'usuari
	*/

	public function getFromEmail($email){
		$sql = mysql_query("SELECT * FROM usuaris WHERE email = '$email'") or die(mysql_error());
		return mysql_fetch_object($sql);
	}	
	
	public function getList() {
		$sql = mysql_query("SELECT * FROM usuaris");
		while($row = mysql_fetch_object($sql)) {
			$resultat[] = $row;
		}
		return $resultat;
	}

}

?>