<?php
	
    class Espece{

        //--Attributs de la classe
        private $id;
        private $nomEspece;
        private $nomDescripteur;
        private $annee;
        private $nomVernacuaire;

        //--Constructeur
        public function Espece($id, $nomEspece, $nomDescripteur, $annee, $nomVernacuaire){
            //--Initialisation de tous les attributs
            $this->id = $id;
            $this->nomEspece = $nomEspece;
            $this->nomDescripteur = $nomDescripteur;
            $this->annee = $annee;
            $this->nomVernacuaire = $nomVernacuaire;
        }

        public function getId(){ return $this->id; }

        //--Accesseurs / Mutateurs Nom
        public function getNomEspece(){ return $this->nomEspece; }
        public function setNomEspece($nom){ $this->nomEspece = $nom; }
        //--Accesseurs / Mutateurs Nom
        public function getNomDescripteur(){ return $this->nomDescripteur; }
        public function setNomDescripteur($nom){ $this->nomDescripteur = $nom; }
        //--Accesseurs / Mutateurs Nom
        public function getAnnee(){ return $this->annee; }
        public function setAnnee($an){ $this->annee = $an; }
        //--Accesseurs / Mutateurs Nom
        public function getNomVernaculaire(){ return $this->nomVernacuaire; }
        public function setNomVernaculaire($nom){ $this->nomVernacuaire = $nom; }
    }
