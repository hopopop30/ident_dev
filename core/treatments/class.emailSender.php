<?php

include_once(dirname(__FILE__). "/../managers/class.Parameters_Manager.php");

class EmailSender {
//put your code here
    public static function Send($sujet, $mail, $body){
        $param_manager = new Parameters_Manager();
        //--R�cup�rations depuis la base
        $emetteur = $param_manager->getEmailIdentificator();
        /*$adresseSite = $this->param_manager->getAdresseSite();*/

        $boundary = "_".md5 (uniqid (rand())); 

        $headers ="From: ".$emetteur." \r\n"; 
        $headers .= "MIME-Version: 1.0\r\nContent-Type: multipart/mixed; boundary=\"$boundary\"\r\n"; 
        //$sujet = "Identificator: Validation d'inscription";
        $fullbody = "--". $boundary ."\nContent-Type: text/plain; charset=ISO-8859-1\r\n\n".$body;

        ini_set('sendmail_from', $mail);
        mail($mail, $sujet, $fullbody, $headers);
    }
    
    public static function SendWithPJ($sujet, $mail, $body, $urlFichier){
        
        $param_manager = new Parameters_Manager();
        //--R�cup�rations depuis la base
        $emetteur = $param_manager->getEmailIdentificator();
        /*$adresseSite = $this->param_manager->getAdresseSite();*/

        $boundary = "_".md5 (uniqid (rand())); 
        
        //--Attache le fichier
        $file = $urlFichier;
        $fp = fopen($file, "rb");
        $attachment = fread($fp, filesize($file));
        fclose($fp);
        $attachment = chunk_split(base64_encode($attachment));

        $body .= "--$boundary\r\n";
        $body .= "Content-Type: image/gif; name=\"$file\"\r\n";
        $body .= "Content-Transfer-Encoding: base64\r\n";
        $body .= "Content-Disposition: attachment; filename=\"$file\"\r\n";
        $body .= "\r\n";
        $body .= $attachment . "\r\n";
        $body .= "\r\n\r\n";

        $body .= "--$boundary--\r\n";
        //----------------

        $headers ="From: ".$emetteur." \r\n"; 
        $headers .= "MIME-Version: 1.0\r\nContent-Type: multipart/mixed; boundary=\"$boundary\"\r\n"; 
        //$sujet = "Identificator: Validation d'inscription";
        $fullbody = "--". $boundary ."\nContent-Type: text/plain; charset=ISO-8859-1\r\n\n".$body;

        ini_set('sendmail_from', $mail);
        mail($mail, $sujet, $fullbody, $headers);
    }
}
?>
