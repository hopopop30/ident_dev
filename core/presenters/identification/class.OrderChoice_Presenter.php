<?php	
    include_once(dirname(__FILE__). "/../../managers/class.Order_Manager.php");
    include_once(dirname(__FILE__). "/../../managers/class.Parameters_Manager.php");
    include_once(dirname(__FILE__). "/../../treatments/class.Log.php");

    class OrderChoice_Presenter{

        private $order_manager;
        private $param_manager;

        public function __construct($userId){
                //--initialisation des attibuts
                $this->order_manager = new Order_Manager($userId, "../");
                $this->param_manager = new Parameters_Manager();
                
                Log::ajoutLignePage($userId, "Order Choice", "../");
        }
        
        public function getUserPictureDirectory(){
            return $this->param_manager->getUserPictureDirectory();
        }
                
        public function getAllOrders(){
            return $this->order_manager->getAllOrders();
        }

    }