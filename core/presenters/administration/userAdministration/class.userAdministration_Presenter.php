<?php	
    include_once(dirname(__FILE__). "/../../../managers/class.User_Manager.php");
    include_once(dirname(__FILE__). "/../../../managers/class.Region_Manager.php");
    include_once(dirname(__FILE__). "/../../../managers/class.Parameters_Manager.php");
    include_once(dirname(__FILE__). "/../../../treatments/class.Log.php");

    class UserAdministration_Presenter{

        private $user_manager;
        private $region_manager;
        private $param_manager;

        public function __construct($userId){
            //--initialisation des attibuts
            $this->user_manager = new User_Manager($userId, "../../");
            $this->region_manager = new Region_Manager($userId, "../../");
            $this->param_manager = new Parameters_Manager();

            Log::ajoutLignePage($userId, "Administration: Users", "../../");
        }
        
        public function getUserPictureDirectory(){
            return $this->param_manager->getUserPictureDirectory();
        }
        
        public function getAllUser(){
            return $this->user_manager->getAllUser();
        }
        
        public function getRegionList(){
            return $this->region_manager->getRegionList();
        }
        
        public function modifyUser($id, $login, $email, $nom, $prenom, $site, $dpt, $actif, $admin){
            $this->user_manager->updateUserWithActif($id, $login, $email, $nom, $prenom, $site, $dpt, $actif, $admin);
        } 
        
        public function deleteUser($id){
           $this->user_manager->deleteUser($id);
        }
    }