<?php
	
	class Picture{
	
		//--Attributs de la classe
		private $id;
		private $idLieu;
		private $idOrdre;
		private $idUtilisateur;
		private $nomFichier;
		private $dateDepot;
		private $datePriseVue;
		private $nomUtilisateur;
		private $nomLieu;
		private $coordonneesGeo;
		private $nomOrdre;
		private $imageOrdre;
                private $identifiee;
				
		//--Constructeur
		public function Picture($id, $idLieu, $idOrdre, $idUtilisateur, $nomFichier, $dateDepot, $datePriseVue, $utilisateur, $lieu, $coordonneesGeo, $ordre, $imageordre, $identifiee){
			//--Initialisation de tous les attributs
			$this->id = $id;
			$this->idLieu = $idLieu;
			$this->idOrdre = $idOrdre;
			$this->idUtilisateur = $idUtilisateur;
			$this->nomFichier = $nomFichier;
			$this->dateDepot = $dateDepot;
			$this->datePriseVue = $datePriseVue;
			$this->nomUtilisateur = $utilisateur;
			$this->nomLieu = $lieu;
			$this->coordonneesGeo = $coordonneesGeo;
			$this->nomOrdre = $ordre;
			$this->imageOrdre = $imageordre;
			$this->identifiee = $identifiee;
		}
		
		//--Accesseur id
		public function getId(){ return $this->id; }
		public function getIdLieu(){ return $this->idLieu; }
		public function getIdOrdre(){ return $this->idOrdre; }
		public function getIdUtilisateur(){ return $this->idUtilisateur; }
		
		//--Accesseurs / Mutateurs nomFichier
		public function getNomFichier(){ return $this->nomFichier; }
		public function setNomFichier($nomFichier){ $this->nomFichier = $nomFichier; }
		
		//--Accesseurs / Mutateurs dateDepot
		public function getDateDepot(){ return $this->dateDepot; }
		public function setDateDepot($dateDepot){ $this->dateDepot = $dateDepot; }
		
		//--Accesseurs / Mutateurs datePriseVue
		public function getDatePriseVue(){ return $this->datePriseVue; }
		public function setDatePriseVue($datePriseVue){ $this->datePriseVue = $datePriseVue; }
		
		//--Accesseurs / Mutateurs utilisateur
		public function getUtilisateur(){ return $this->nomUtilisateur; }
		public function setUtilisateur($utilisateur){ $this->nomUtilisateur = $utilisateur; }
		
		//--Accesseurs / Mutateurs lieu
		public function getLieu(){ return $this->nomLieu; }
		public function setLieu($lieu){ $this->nomLieu = $lieu; }
		public function getCoordonneesGeo(){ return $this->coordonneesGeo; }
		public function setCoordonneesGeo($Geo){ $this->coordonneesGeo = $Geo; }
		
		//--Accesseurs / Mutateurs ordre
		public function getOrdre(){ return $this->nomOrdre; }
		public function setOrdre($ordre){ $this->nomOrdre = $ordre; }
		public function getImageOrdre(){ return $this->imageOrdre; }
		public function setImageOrdre($imgordre){ $this->imageOrdre = $imgordre; }
                
		public function getIdentifiee(){ return $this->identifiee; }
		public function setIdentifiee($ident){ $this->identifiee = $ident; }
	}
