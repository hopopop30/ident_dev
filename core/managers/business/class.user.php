<?php
	
	class User{
	
		//--Attributs de la classe
		private $id;
		private $login;
		private $password;
		private $nom;
		private $prenom;
		private $email;
		private $site;
		private $departement;
		private $nomDepartement;
		private $dateCreation;
		private $dateModif;
		private $admin;
		private $actif;
		private $abonn_CSS; 
		private $abonn_newsLetter; 
		private $photo_profil;
				
		//--Constructeur
		 function User($id, $log, $pwd, $nom, $prenom, $email, $site, $dpt, $nomDpt, $dateCreation, $dateMod, $actif, $admin, $abonn_CSS, $abonn_newsLetter, $photo_profil){
			//--Initialisation de tous les attributs
			$this->id = $id;
			$this->login = $log;
			$this->password = $pwd;
			$this->nom = $nom;
			$this->prenom = $prenom;
			$this->email = $email;
			$this->site = $site;
			$this->departement = $dpt;
			$this->nomDepartement = $nomDpt;
			$this->dateCreation = $dateCreation;
			$this->dateModif = $dateMod;
			$this->actif = $actif;
			$this->admin = $admin;
			$this->abonn_CSS = $abonn_CSS;
			$this->abonn_newsLetter = $abonn_newsLetter;
			$this->photo_profil = $photo_profil;
		}
		
		//--Accesseur id
		public function getId(){ return $this->id; }
		
		//--Accesseurs / Mutateurs Login
		public function getLogin(){ return $this->login; }
		public function setLogin($log){ $this->login = $log; }
		//--Accesseurs / Mutateurs password
		public function getPassword(){ return $this->password; }
		public function setPassword($pwd){ $this->password = $pwd; }
		
		//--Accesseurs / Mutateurs Nom
		public function getNom(){ return $this->nom; }
		public function setNom($nom){ $this->nom = $nom; }
		
		//--Accesseurs / Mutateurs Prenom
		public function getPrenom(){ return $this->prenom; }
		public function setPrenom($pren){ $this->prenom = $pren; }
		
		//--Accesseurs / Mutateurs Email
		public function getEmail(){ return $this->email; }
		public function setEmail($mail){ $this->email = $mail; }
		
		//--Accesseurs / Mutateurs Site
		public function getSite(){ return $this->site; }
		public function setSite($site){ $this->site = $site; }
		
		//--Accesseurs / Mutateurs Departement
		public function getDepartement(){ return $this->departement; }
		public function setDepartement($dpt){ $this->departement = $dpt; }
		//--Accesseurs / Mutateurs nom Departement
		public function getNomDepartement(){ return $this->nomDepartement; }
		public function setNomDepartement($dpt){ $this->nomDepartement = $dpt; }
		
		//--Accesseurs / Mutateurs dateCreation
		public function getDateCreation(){ return $this->dateCreation; }
		public function setDateCreation($dateCrea){ $this->dateCreation = $dateCrea; }
		//--Accesseurs / Mutateurs dateModif
		public function getDateModif(){ return $this->dateModif; }
		public function setDateModif($dateMod){ $this->dateModif = $dateMod; }
		
		//--Accesseurs / Mutateurs actif
		public function getActif(){ return $this->actif; }
		public function setActif($actif){ $this->actif = $actif; }
		//--Accesseurs / Mutateurs admin
		public function getAdmin(){ return $this->admin; }
		public function setAdmin($admin){ $this->admin = $admin; }
		
		
		//--Accesseurs / Mutateurs abonnement RSS
		public function getAbonnRSS(){ return $this->abonn_CSS; }
		public function setAbonnRSS($RSS){ $this->abonn_CSS = $RSS; }
		//--Accesseurs / Mutateurs newletter
		public function getAbonnNewsLetter(){ return $this->abonn_newsLetter; }
		public function setAbonnNewsLetter($abonn_newsLetter){ $this->abonn_newsLetter = $abonn_newsLetter; }
		//--Accesseurs / Mutateurs admin
		public function getPhotoProfil(){ return $this->photo_profil; }
		public function setPhotoProfil($photo_profil){ $this->photo_profil = $photo_profil; }
		
	}
