<?php	
	include_once(dirname(__FILE__). "/class.DB_Acces.php");
	include_once(dirname(__FILE__). "/business/class.user.php");
        include_once(dirname(__FILE__). "/../treatments/class.Log.php");
	
	class User_Manager{
		
		private $DB_acces;
                private $userId;
                private $arborescence;
		
		public function __construct($userId, $arborescence){
			//--initialisation des attibuts
			$this->DB_acces = new DB_Acces();
                        $this->userId = $userId;
                        $this->arborescence = $arborescence;
		}
		
		public function getUser($login){
			//--Connexion � la base
			$this->DB_acces->connexion();
			
			//--Tableau de retour
			//$retour = 'nonInit';
		
			//--Construction de la requete
			$sql = "SELECT ut.IdUtilisateur, ut.Login, ut.Nom, ut.Prenom, ut.Email, ut.Site, ut.IdDept, dep.NomDept, ut.DateCreation, ut.DateModif, ".
					"ut.Actif, ut.Admin, ut.Abonn_RSS, ut.abonn_NewsLetter, ut.Photo, ut.Mdp ".
					"FROM ".$this->DB_acces->getPrefixTables()."Utilisateur ut ".
					"INNER JOIN ".$this->DB_acces->getPrefixTables()."ParamDept dep ON dep.IdDept = ut.IdDept ".
					"WHERE ut.Login = '".utf8_decode($login)."'";
			
			//--Ex�cution
			$req = mysql_query($sql);	
			
			//--R�cup�ration et tri
			while($res = mysql_fetch_array($req, MYSQL_ASSOC)){
				if($res != null){
					$retour = new User(utf8_encode($res['IdUtilisateur']),
									utf8_encode($res['Login']),
									utf8_encode($res['Mdp']),
									utf8_encode($res['Nom']),
									utf8_encode($res['Prenom']), 
									utf8_encode($res['Email']),
									utf8_encode($res['Site']), 
									utf8_encode($res['IdDept']),
									utf8_encode($res['NomDept']),
									utf8_encode($res['DateCreation']), 
									utf8_encode($res['DateModif']),
									utf8_encode($res['Actif']),
									utf8_encode($res['Admin']), 
									utf8_encode($res['Abonn_RSS']), 
									utf8_encode($res['abonn_NewsLetter']), 
									utf8_encode($res['Photo']));
				}
			}
			
			//--Fermeture de la base
			$this->DB_acces->deconnexion();
			
			if(!isset($retour)){
				$retour = "badLog";
			}
			//--Retour du tableau
			return $retour;
		}
                
                public function getUserById($id){
			//--Connexion � la base
			$this->DB_acces->connexion();
			
			//--Tableau de retour
			//$retour = 'nonInit';
		
			//--Construction de la requete
			$sql = "SELECT ut.IdUtilisateur, ut.Login, ut.Nom, ut.Prenom, ut.Email, ut.Site, ut.IdDept, dep.NomDept, ut.DateCreation, ut.DateModif, ".
					"ut.Actif, ut.Admin, ut.Abonn_RSS, ut.abonn_NewsLetter, ut.Photo, ut.Mdp ".
					"FROM ".$this->DB_acces->getPrefixTables()."Utilisateur ut ".
					"INNER JOIN ".$this->DB_acces->getPrefixTables()."ParamDept dep ON dep.IdDept = ut.IdDept ".
					"WHERE ut.IdUtilisateur = ".$id." ";
			
			//--Ex�cution
			$req = mysql_query($sql);	
			
			//--R�cup�ration et tri
			while($res = mysql_fetch_array($req, MYSQL_ASSOC)){
				if($res != null){
					$retour = new User(utf8_encode($res['IdUtilisateur']),
									utf8_encode($res['Login']),
									utf8_encode($res['Mdp']),
									utf8_encode($res['Nom']),
									utf8_encode($res['Prenom']), 
									utf8_encode($res['Email']),
									utf8_encode($res['Site']), 
									utf8_encode($res['IdDept']),
									utf8_encode($res['NomDept']),
									utf8_encode($res['DateCreation']), 
									utf8_encode($res['DateModif']),
									utf8_encode($res['Actif']),
									utf8_encode($res['Admin']), 
									utf8_encode($res['Abonn_RSS']), 
									utf8_encode($res['abonn_NewsLetter']), 
									utf8_encode($res['Photo']));
				}
			}
			
			//--Fermeture de la base
			$this->DB_acces->deconnexion();
			
			if(!isset($retour)){
				$retour = "badLog";
			}
			//--Retour du tableau
			return $retour;
		}
		
		public function loginExist($login){
			//--Connexion � la base
			$this->DB_acces->connexion();
			
			//--Tableau de retour
			$retour = 'erreurLogin';
		
			//--Construction de la requete
			$sql  = "select count(ut.Login) as retour ".
					"from ".$this->DB_acces->getPrefixTables()."Utilisateur ut ".
					"where ut.Login = '".$login."'";
			//--Ex�cution
			$req = mysql_query($sql);
			
			//--R�cup�ration et tri
			while($res = mysql_fetch_array($req, MYSQL_ASSOC)){
				if($res != null){
					if(utf8_encode($res['retour'] == '0')){
						$retour = 'Ok';
					}
				}
			}
			//--Fermeture de la base
			$this->DB_acces->deconnexion();
				
			//--Retour du tableau
			return $retour;
		}
		
		public function emailExist($email){
			//--Connexion � la base
			$this->DB_acces->connexion();
			
			//--Tableau de retour
			$retour = 'erreurMail';
		
			//--Construction de la requete
			$sql  = "select count(ut.Email) as retour ".
					"from ".$this->DB_acces->getPrefixTables()."Utilisateur ut ".
					"where ut.Email = '".$email."'";
			//--Ex�cution
			$req = mysql_query($sql);	
			
			//--R�cup�ration et tri
			while($res = mysql_fetch_array($req, MYSQL_ASSOC)){
				if($res != null){
					if(utf8_encode($res['retour'] == '0')){
						$retour = 'Ok';
					}
				}
			}
			//--Fermeture de la base
			$this->DB_acces->deconnexion();
			
			//--Retour du tableau
			return $retour;
		}
		
		public function addUser($login, $mdp, $nom, $prenom, $mail, $site, $dpt, $photo){
			//--Connexion � la base
			$this->DB_acces->connexion();
			
			//--Construction de la requete
			$sql = "INSERT INTO ".$this->DB_acces->getPrefixTables()."Utilisateur (IdUtilisateur, Login, Mdp, Nom, Prenom, Email, Site, IdDept, DateCreation, DateModif, Actif, Admin, Abonn_RSS, Abonn_NewsLetter, Photo) ".
					"VALUES('', '".utf8_decode($login)."', '".md5($mdp)."', '".utf8_decode($nom)."', '".utf8_decode($prenom)."', '".utf8_decode($mail)."', '".utf8_decode($site)."', '".$dpt."', now(), now(), '0', '0', '0', '0', '".utf8_decode($photo)."')";
			//--Ex�cution
			$req = mysql_query($sql);
			if($req == '1'){
				$retour = "insertionOk";
                                Log::ajoutLigneBDD($this->userId, "Ajout utilisateur", $sql, $this->arborescence);
			}
			else {
                            $retour = "insertionKo";
                            Log::ajoutLigneBDD($this->userId, "Erreur Ajout utilisateur", $sql, $this->arborescence);
                        }
			
			//--Fermeture de la base
			$this->DB_acces->deconnexion();
			
			return $retour;
		}
                
                public function updateUser($id, $nom, $prenom, $site, $dpt, $photo){
                    //--Connexion � la base
			$this->DB_acces->connexion();
			
                        $sql = "update ".$this->DB_acces->getPrefixTables()."Utilisateur set Nom = '".utf8_decode($nom)."', ".
                                                                                            "Prenom = '".utf8_decode($prenom)."', ".
                                                                                            "Site = '".utf8_decode($site)."', ".
                                                                                            "IdDept = '".$dpt."', ".
                                                                                            "Photo = '".utf8_decode($photo)."' ".   
                                                                                            "where idUtilisateur = ".$id.";";
                        
                        //--Ex�cution
			$req = mysql_query($sql);
			if($req == '1'){
				$retour = "Ok";
                                Log::ajoutLigneBDD($this->userId, "Modification utilisateur", $sql, $this->arborescence);
			}
			else {
                            $retour = "Ko";
                                Log::ajoutLigneBDD($this->userId, "Erreur Modification utilisateur", $sql, $this->arborescence);
                        }
			
			//--Fermeture de la base
			$this->DB_acces->deconnexion();
			
			return $retour;
                }
		
		//--Valide le compte utilisateur en param
		public function valideCompte($logMd5, $mdpMd5){
			//--Connexion � la base
			$this->DB_acces->connexion();
			
			//--Construction de la requete
			$sql = "UPDATE ".$this->DB_acces->getPrefixTables()."Utilisateur SET Actif =1, DateModif = now() ".
					"WHERE MD5(Login)= '".$logMd5."' AND ".
					"'".$mdpMd5."' = Mdp";
			
			//--Ex�cution
			$req = mysql_query($sql);
                        Log::ajoutLigneBDD($this->userId, "Validation compte utilisateur", $sql, $this->arborescence);	
			
			//--Retour du login
			$sql  = "select ut.Login ".
					"from ".$this->DB_acces->getPrefixTables()."Utilisateur ut ".
					"where MD5(ut.Login) = '".$logMd5."'";
			//--Ex�cution
			$req = mysql_query($sql);
			
			//--R�cup�ration et tri
			while($res = mysql_fetch_array($req, MYSQL_ASSOC)){
				if($res != null){
					$retour = $res['Login'];
				}
			}
			
			//--Fermeture de la base
			$this->DB_acces->deconnexion();
			
			return $retour;
		}
	}