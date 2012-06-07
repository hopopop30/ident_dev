<?php
	
    class Place{

        //--Attributs de la classe
        private $id;
        private $nom;
        private $geo;

        //--Constructeur
        public function __construct($id, $nom, $geo){
                //--Initialisation de tous les attributs
                $this->id = $id;
                $this->nom = $nom;
                $this->geo = $geo;
        }

        public function getId(){ return $this->id; }

        //--Accesseurs / Mutateurs Nom
        public function getNom(){ return $this->nom; }
        public function setNom($nom){ $this->nom = $nom; }

        //--Accesseurs / Mutateurs nom de l'ordre
        public function getCoordonnees(){ return $this->geo; }
        public function setCoordonnees($geo){ $this->geo = $geo; }
    }
