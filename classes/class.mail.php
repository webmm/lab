<?php

class Mail{

	public function sendMail($to,$subject,$path,$opt=null,$from = 'info@labarretina.hostagia.com',$fromname = 'La Barretina') {
		
		require_once('class.phpmailer-lite.php');
		
		$to = strtolower(General::cleantext($to));
		$from = strtolower(General::cleantext($from));
		
		if((!General::esEmail($to))&&(!General::esEmail($from))) {
			return false;
		}
		
		$mail             = new PHPMailerLite();
		$mail->IsMail();
		$body             = file_get_contents('http://'.General::base_url.$path);
		$body             = eregi_replace("[\]",'',$body);
		
		if($opt) {
			foreach ($opt as $k => $v) {
				$var = utf8_decode(General::cleantext($v));
				$key = General::cleantext($k);
				$body = str_replace("%".$key."%", $var, $body);
			}
		}
		
		$mail->From = $from;
		$mail->FromName = '=?UTF-8?B?'.base64_encode($fromname).'?=';
		$mail->AddAddress($to);
		$mail->Subject    = '=?UTF-8?B?'.base64_encode($subject).'?=';
		$mail->AltBody    = "Per veure aquest missatge necessites un programa compatible amb HTML!"; 
		$mail->MsgHTML($body);
		
		if(!$mail->Send()) {
		  return false;
		} else {
		  return true;
		}
	}
}

?>