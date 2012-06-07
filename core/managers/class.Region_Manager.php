<?php	
	include_once(dirname(__FILE__). "/class.DB_Acces.php");
	include_once(dirname(__FILE__). "/business/class.region.php");
	
	class Region_Manager{
		
		private $DB_acces;
                private $userId;
                private $arborescence;
		
		public function __construct($arborescence){
			//--initialisation des attibuts
			$this->DB_acces = new DB_Acces();
                        $this->userId = $userId;
                        $this->arborescence = $arborescence;
		}
		
		public function getRegionList(){
			//--Connexion � la base
			$this->DB_acces->connexion();
			
			//--Tableau de retour
			$retour = array();
		
			//--Construction de la requete
			$sql = "SELECT dep.IdDept, dep.NomDept ".
					"FROM ".$this->DB_acces->getPrefixTables()."ParamDept dep ".
					"ORDER BY dep.IdDept";
			
			//--Ex�cution
			$req = mysql_query($sql);	
			$i = 0;
			
			//--R�cup�ration et tri
			while($res = mysql_fetch_array($req, MYSQL_ASSOC)){
				if($res != null){
					$retour[$i] = new Region(utf8_encode($res['IdDept']), utf8_encode($res['NomDept']));
					$i++;
				}
			}
			
			//--Fermeture de la base
			$this->DB_acces->deconnexion();
			
			//--Retour du tableau
			return $retour;
		}
	}