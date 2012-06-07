<?php	
	include_once(dirname(__FILE__). "/../../managers/class.User_Manager.php");
	include_once(dirname(__FILE__). "/../../managers/class.Parameters_Manager.php");
	include_once(dirname(__FILE__). "/../../managers/business/class.user.php");
	include_once(dirname(__FILE__). "/../../treatments/class.Log.php");
	
	class Home_Presenter{
		
		private $user_manager;
		private $param_manager;
		
		public function __construct(){
                    //--initialisation des attibuts
                    $this->user_manager = new User_Manager("inconnu", "");
                    $this->param_manager = new Parameters_Manager();

                    Log::ajoutLignePage("Inconnu", "Home", "");
		}
		
		//--R�cup�re le texte promotionnel
		public function getTextPromo(){
                    return $this->param_manager->getTextPromo();
		}
		
		//--R�cup�re le texte promotionnel
		public function connexion($login, $password){
                    //--R�cup�ration de l'utilisateur en fonction de son login
                    $user = $this->user_manager->getUser($login);

                    //--Si l'utilisateur existe
                    if($user != "badLog"){
                        //--Comparaison de mots de passes
                        if(md5($password) != $user->getPassword()){
                            $user = "badPass";
                        }else{
                            Log::ajoutLigneLog($user->getId(), $user->getlogin(), $user->getNom(), $user->getPrenom(), $user->getEmail(), $user->getAdmin());
                        }			
                    }
                    return $user;
		}
	}