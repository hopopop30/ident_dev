<?php	
	include_once(dirname(__FILE__). "/../managers/class.User_Manager.php");
	include_once(dirname(__FILE__). "/../managers/class.Parameters_Manager.php");
	//include_once(dirname(__FILE__). "/../../managers/business/class.user.php");
	
	class Default_Presenter{
		
           /* private $user_manager;*/
            private $param_manager;

            public function __construct($userId){
                
                    //--initialisation des attibuts
                    /*$this->user_manager = new User_Manager();*/
                    $this->param_manager = new Parameters_Manager();
            }
            
            public function getUserPictureDirectory(){
                return $this->param_manager->getUserPictureDirectory();
            }
            
            public function getVersionAndEnvironment(){
                $retour['version'] = $this->param_manager->getVersion();
                $retour['env'] = $this->param_manager->getEnvironment();
                return $retour;
            }
	}