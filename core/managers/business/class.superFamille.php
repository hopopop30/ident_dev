<?php
	
    class SuperFamille{

        //--Attributs de la classe
        private $id;
        private $nom;

        //--Constructeur
        public function SuperFamille($id, $nom){
            //--Initialisation de tous les attributs
            $this->id = $id;
            $this->nom = $nom;
        }

        public function getId(){ return $this->id; }

        //--Accesseurs / Mutateurs Nom
        public function getNom(){ return $this->nom; }
        public function setNom($nom){ $this->nom = $nom; }
    }
