<?php	
	class DB_Acces{
	
		//Param�tres d'acc�s � la base
		private $db_server = "db1161.1and1.fr";
		private $db_name = "db354151741";
		private $db_user = "dbo354151741";
		private $db_pass = "lepetit";
		//private $PT = '';
		
		private $db = '';
		
		public function __construct(){
			//--initialisation des attibuts
			//$this->getPrefixTables();
		}
		
		//--Permet une connexion vers la base de donn�es
		public function connexion(){
			//--Connexion � la base de donn�es
			$this->db = mysql_connect($this->db_server, $this->db_user, $this->db_pass);
			if (!$this->db) {
				die('Connexion impossible : ' . mysql_error());
			}
			
			/*--Selection de la base de donn�es--*/
			$select = mysql_select_db($this->db_name, $this->db);
		}
		
		//--Permet une deconnexion de la base de donn�es
		public function deconnexion(){
			mysql_close($this->db);
		}
		
		//--R�cup�re le pr�fix des tables de la base de donn�es
		public function getPrefixTables(){
			//--R�cup�ration du pr�fix des tables
			return $this->PT = 'identV2_';
		}		
	}