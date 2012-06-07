<?php	
	include_once(dirname(__FILE__). "/../../managers/class.User_Manager.php");
	include_once(dirname(__FILE__). "/../../managers/class.Parameters_Manager.php");
	include_once(dirname(__FILE__). "/../../managers/business/class.user.php");
	include_once(dirname(__FILE__). "/../../treatments/class.Log.php");
	
	class Confirm_Presenter{
		
		private $user_manager;
		private $param_manager;
		
		public function __construct(){
			//--initialisation des attibuts
			$this->user_manager = new User_Manager("inconnu", "../");
			$this->param_manager = new Parameters_Manager();
                        
                        Log::ajoutLignePage("Inconnu", "Confirm", "../");
		}
		
		public function confirm($md5Login, $md5Pass){
		
			$retour = $this->user_manager->valideCompte($md5Login, $md5Pass);
			
			if(isset($retour)){
				return $retour;
			}
			else return "_noLogin_";
		}
		
	}