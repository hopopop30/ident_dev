<?php
	
	class Region{
	
		//--Attributs de la classe
		private $id;
		private $nom;
				
		//--Constructeur
		 function Region($id, $nom){
			//--Initialisation de tous les attributs
			$this->id = $id;
			$this->nom = $nom;
		}
		
		//--Accesseur id
		public function getId(){ return $this->id; }
		
		//--Accesseurs / Mutateurs Login
		public function getName(){ return $this->nom; }
		public function setName($nom){ $this->nom = $nom; }
		
	}
