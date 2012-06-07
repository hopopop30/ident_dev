<?php	
	include_once(dirname(__FILE__). "/../../treatments/class.emailSender.php");
	include_once(dirname(__FILE__). "/../../managers/class.User_Manager.php");
	include_once(dirname(__FILE__). "/../../managers/class.Parameters_Manager.php");
	include_once(dirname(__FILE__). "/../../managers/class.Region_Manager.php");
	include_once(dirname(__FILE__). "/../../managers/business/class.user.php");
	include_once(dirname(__FILE__). "/../../managers/business/class.region.php");
	include_once(dirname(__FILE__). "/../../treatments/class.Log.php");
	
	class NewUser_Presenter{
		
		private $user_manager;
		private $param_manager;
		
		public function __construct(){
			//--initialisation des attibuts
			$this->user_manager = new User_Manager("inconnu", "../");
			$this->region_manager = new Region_Manager("inconnu", "../");
			$this->param_manager = new Parameters_Manager();
                        
                        Log::ajoutLignePage("Inconnu", "New_User", "../");
		}
		
		//--R�cup�re la liste des d�partements
		public function getRegionList(){
			return $this->region_manager->getRegionList();
		}
		
		//--V�rifie l'inscription d'un utilisateur
		public function verifyNewUser($login, $mail, $photo){
			
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
		
		//--Ajoute l'utilisateur
		public function addUser($login, $mdp, $nom, $prenom, $mail, $site, $dpt, $photo){
                    //--Si l'utilisateur a envoyé une photo
                    if($photo != "../content/images/Default_Black.png"){
			//--Renommage de la photo
			$new_photo_name = "profil_".$login;
			
			//--R�cup�re l'extension
			$spliter = explode('.', $photo);
			$extension = $spliter[count($spliter)-1];
			$new_photo_name = $new_photo_name.".".$extension;
			
			//--Copie de la photo dans le r�pertoire
			$rep_user_picture = "../".$this->param_manager->getUserPictureDirectory();
			$rep_temporaire = "../".$this->getDirTemp();
			
			$photo_ok = false;
			if(copy($rep_temporaire.$photo, $rep_user_picture.$new_photo_name)){
				$photo_ok = true;
			}
                    }
                    //--Sinon, si pas de photo envoyé
                    else{
                        $new_photo_name = "content/images/Default_Black.png";
                    }
			
			//--Enregistrement
			$this->user_manager->addUser($login, $mdp, $nom, $prenom, $mail, $site, $dpt, $new_photo_name);
		}
		
		public function getDirTemp(){
			return $this->param_manager->getTempDirectory();
		}
		
		//--Effectue l'envoi du mail � l'utilisateur
		public function sendConfirmMail($log, $mdp, $mail, $nom, $prenom){
			$adresseSite = $this->param_manager->getAdresseSite();
                        
			$body = "Bonjour ".$prenom." ".$nom.",\n".  
                                "Veuillez confirmer votre inscription à identificator.fr en cliquant sur ce lien: \n".
                                $adresseSite."subscription/confirm.php?confirm=confirm&param=".md5($log)."&param2=".md5($mdp)." \n".
                                "Merci. \n".
                                "L'équipe d'Identificator";
                        
                        EmailSender::Send("Identificator: Validation d'inscription", $mail, $body);
		}	
	}