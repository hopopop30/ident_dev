<?php	
	include_once(dirname(__FILE__). "/../../managers/class.User_Manager.php");
	include_once(dirname(__FILE__). "/../../managers/class.Parameters_Manager.php");
	include_once(dirname(__FILE__). "/../../treatments/class.emailSender.php");
	
	class BugReport_Presenter{
		
            private $user_manager;
            private $param_manager;
            
            private $user;

            public function __construct($user){
                //--initialisation des attibuts
                $this->user_manager = new User_Manager($user, "../");
                $this->param_manager = new Parameters_Manager();
                
                $this->user = $user;
            }
            public function sendReport($page, $desc){
                if(isset($this->user)){
                $body = "Bonjour, l'utilisateur ".$this->user->getNom()." ".$this->user->getPrenom()." \n".
                        "A déclaré un bug sur la page ".$page."\n".
                        "Avec la description suivante : ".$desc."\n\n".
                        "Cordialement";
                }
                else{
                    $body = "Bonjour, un utilisateur anonyme \n".
                        "A déclaré un bug sur la page ".$page."\n".
                        "Avec la description suivante : ".$desc."\n\n".
                        "Cordialement";
                }
                EmailSender::Send("Déclaration de bug", "nicolasp.30@gmail.com", $body);
                
                return "ok";
            }
		
		
	}