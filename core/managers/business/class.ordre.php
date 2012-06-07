<?php
	
    class Ordre{

        //--Attributs de la classe
        private $id;
        private $nom;
        private $lienImage;
        private $idAdministrateurs;

        //--Constructeur
        public function Ordre($id, $nom, $img){
            //--Initialisation de tous les attributs
            $this->id = $id;
            $this->nom = $nom;
            $this->lienImage = $img;
            $this->idAdministrateurs = array();
        }

        public function getId(){ return $this->id; }

        //--Accesseurs / Mutateurs Nom
        public function getNom(){ return $this->nom; }
        public function setNom($nom){ $this->nom = $nom; }

        //--Accesseurs / Mutateurs nom de l'ordre
        public function getLienImage(){ return $this->lienImage; }
        public function setLienImage($img){ $this->lienImage = $img; }
        //--Accesseurs / Mutateurs nom des administrateurs
        public function getIdAdministrateurs(){ return $this->idAdministrateurs; }
        public function setIdAdminitstrateurs($adm){ $this->idAdministrateurs = $adm; }
    }
