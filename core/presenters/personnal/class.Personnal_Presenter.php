<?php	
	include_once(dirname(__FILE__). "/../../managers/class.User_Manager.php");
	include_once(dirname(__FILE__). "/../../managers/class.Parameters_Manager.php");
	include_once(dirname(__FILE__). "/../../managers/class.Region_Manager.php");
	include_once(dirname(__FILE__). "/../../managers/business/class.user.php");
	include_once(dirname(__FILE__). "/../../managers/business/class.region.php");
        include_once(dirname(__FILE__). "/../../treatments/class.Log.php");
	
	class Personnal_Presenter{
		
		private $user_manager;
		private $param_manager;
		private $region_manager;
                
                private $user;
		
		public function __construct($userId, $userLogin){
			//--initialisation des attibuts
			$this->user_manager = new User_Manager($userId, "../");
			$this->region_manager = new Region_Manager($userId, "../");
			$this->param_manager = new Parameters_Manager();
                        
                        $this->user = $this->user_manager->getUser($userLogin);
                        
                        Log::ajoutLignePage($this->user->getId(), "Personnal", "../");
		}
                
                public function getUser(){ return $this->user; }
		
		//--R�cup�re la liste des d�partements
		public function getRegionList(){
			return $this->region_manager->getRegionList();
		}
                
                /*public function changeUser($nom, $prenom, $site, $dpt, $photo){
                    
                    return $this->user_manager->updateUser($this->user->getId(), $nom, $prenom, $site, $dpt, $photo);
                }*/
		
		//--Ajoute l'utilisateur
		public function userModification($nom, $prenom, $site, $dpt, $photo){
                    //--Si l'utilisateur a envoyé une photo
                    if($photo != "../content/images/Default_Black.png"){
			//--Renommage de la photo
			$new_photo_name = "profil_".$this->user->getLogin();
			
			//--R�cup�re l'extension
			$spliter = explode('.', $photo);
			$extension = $spliter[count($spliter)-1];
			$new_photo_name = $new_photo_name.".".$extension;
			
			//--Copie de la photo dans le r�pertoire
			$rep_user_picture = "../".$this->param_manager->getUserPictureDirectory();
			$rep_temporaire = "../".$this->getDirTemp();
			
			$photo_ok = false;
			if(@copy($rep_temporaire.$photo, $rep_user_picture.$new_photo_name)){
				$photo_ok = true;
			}
                    }
                    //--Sinon, si pas de photo envoyé
                    else{
                        $new_photo_name = "content/images/Default_Black.png";
                    }
                    /*print_r($photo);
                    print_r($new_photo_name);*/
                    //--Enregistrement
                    return $this->user_manager->updateUser($this->user->getId(), $nom, $prenom, $site, $dpt, $new_photo_name);
		}
		
		public function getDirTemp(){
			return $this->param_manager->getTempDirectory();
		}
                
                public function getUserPictureDirectory(){
                    return $this->param_manager->getUserPictureDirectory();
                }
                
		/*
		//--V�rifie l'inscription d'un utilisateur
		public function verifyUserModification($login, $mail, $photo){
			
			if(!preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/" , $mail)){	//--V�rifie addresse email
				return "mailInvalide";
			}
			else if($this->user_manager->loginExist($login) == 'erreurLogin'){	//--v�rifie login disponible
				return 'erreurLogin';
			}
			else if($this->user_manager->emailExist($mail) == 'erreurMail'){	//--V�rifie email disponible
				return 'erreurMail';
			}
			else return 'Ok';
		}
		
		//--Effectue l'envoi du mail � l'utilisateur
		public function sendConfirmMail($log, $mdp, $mail, $nom, $prenom){
			
			//--R�cup�rations depuis la base
			$emetteur = $this->param_manager->getEmailIdentificator();
			$adresseSite = $this->param_manager->getAdresseSite();
			
			$boundary = "_".md5 (uniqid (rand())); 
			
			$headers ="From: ".$emetteur." \r\n"; 
			$headers .= "MIME-Version: 1.0\r\nContent-Type: multipart/mixed; boundary=\"$boundary\"\r\n"; 
			$sujet = "Identificator: Validation d'inscription";
			$body = "--". $boundary ."\nContent-Type: text/plain; charset=ISO-8859-1\r\n\n
					Bonjour ".$prenom." ".$nom."  
					Veuillez confirmer votre inscription � identificator.fr en cliquant sur ce lien:
					".$adresseSite."subscription/confirm.php?confirm=confirm&param=".md5($log)."&param2=".md5($mdp)."
					Merci.
					L'équipe d'Identificator";
			
			ini_set('sendmail_from', $mail);
			mail($mail, $sujet, $body, $headers);
		}	*/
	}