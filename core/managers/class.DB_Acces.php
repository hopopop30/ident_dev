<?php	
	class DB_Acces{
	
		//Paramètres d'accès à la base
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
		
		//--Permet une connexion vers la base de données
		public function connexion(){
			//--Connexion à la base de données
			$this->db = mysql_connect($this->db_server, $this->db_user, $this->db_pass);
			if (!$this->db) {
				die('Connexion impossible : ' . mysql_error());
			}
			
			/*--Selection de la base de données--*/
			$select = mysql_select_db($this->db_name, $this->db);
		}
		
		//--Permet une deconnexion de la base de données
		public function deconnexion(){
			mysql_close($this->db);
		}
		
		//--Récupère le préfix des tables de la base de données
		public function getPrefixTables(){
			//--Récupération du préfix des tables
			return $this->PT = 'identV2_';
		}		
	}