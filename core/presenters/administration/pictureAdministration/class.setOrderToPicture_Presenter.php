<?php	
    include_once(dirname(__FILE__). "/../../../managers/class.Picture_Manager.php");
    include_once(dirname(__FILE__). "/../../../managers/class.Parameters_Manager.php");
    include_once(dirname(__FILE__). "/../../../managers/class.Order_Manager.php");
    include_once(dirname(__FILE__). "/../../../treatments/class.Log.php");

    class Admin_SetOrderToPicture_Presenter{

        private $picture_manager;
        private $param_manager;
        private $order_manager;

        public function __construct($userId){
            //--initialisation des attibuts
            $this->picture_manager = new Picture_Manager($userId, "../../");
            $this->order_manager = new Order_Manager($userId, "../../");
            $this->param_manager = new Parameters_Manager();

            Log::ajoutLignePage($userId, "Administration: Set order to picture", "../../");
        }
        
        public function getUserPictureDirectory(){
            return $this->param_manager->getUserPictureDirectory();
        }
        public function getSiteAddress(){
            return $this->param_manager->getAdresseSite();
        }
        public function getPictureDir(){
            return $this->param_manager->getPicturesDirectory();
        }
        
        public function getPicturesWithoutOrder(){
            return $this->picture_manager->getPicturesWithoutOrder();
        }
        
        public function getOrderList(){
            return $this->order_manager->getAllOrders();
        }
        
        public function deletePic($picId, $chem){
            @unlink("../../photos/identification/".$chem);
            return $this->picture_manager->deletePic($picId);
        }
        
        public function newOrder($picId, $orderId){
            return $this->picture_manager->setNewOrder($picId, $orderId);
        }
    }