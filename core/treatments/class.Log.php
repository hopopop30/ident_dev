<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of class
 *
 * @author Marie-Lou
 */
class Log {
    public static function ajoutLigneLog($id, $login, $nom, $prenom, $email, $admin){
		
        //--Nom du fichier
        $filename = "traces/logs.txt";

        //Construction de la ligne
        $nvLigne = "id:".$id."; log:".$login."; nom:".$nom."; prenom:".$prenom."; email:".$email."; admin:".$admin."; date:".date('l dS \of F Y h:i:s A')."\n";

        // ouverture du fichier en mode lecture- écriture : le pointeur est à la fin du fichier
        $fichier=fopen($filename, 'a+');

        // écriture de la ligne
        fwrite($fichier,$nvLigne);

        // fermeture du fichier
        fclose ($fichier);
    }
    
    public static function ajoutLigneBDD($id, $category, $requete, $dossierParent){
        //--Nom du fichier
        $filename = $dossierParent."traces/bdd/bdd_".date("Y-m-d").".txt";

        //Construction de la ligne
        $nvLigne = "id:".$id."; catgorie : ".$category."; requete : ".$requete."; heure: ".date('h:i:s A')."\n";

        // ouverture du fichier en mode lecture- écriture : le pointeur est à la fin du fichier
        $fichier=fopen($filename, 'a+');

        // écriture de la ligne
        fwrite($fichier,$nvLigne);

        // fermeture du fichier
        fclose ($fichier);
    }
    
    public static function ajoutLignePage($id, $page, $dossierParent){
		
        //--Nom du fichier
        $filename = $dossierParent."traces/navigation/nav_".date("Y-m-d").".txt";
        
        //Construction de la ligne
        $nvLigne = "id:".$id."; page : ".$page."; heure: ".date('h:i:s A')."\n";

        // ouverture du fichier en mode lecture- écriture : le pointeur est à la fin du fichier
        $fichier=fopen($filename, 'a+');

        // écriture de la ligne
        fwrite($fichier,$nvLigne);

        // fermeture du fichier
        fclose ($fichier);
    }
}
?>
