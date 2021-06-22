<?php

require_once($_SERVER['DOCUMENT_ROOT']."/website/Modele/Equipe.php");

class ControleurEquipe {

    private $equipe;

    public function __construct() {
        $this->equipe = new Equipe();
    }


    public function getEquipes(){
        $equipes =  $this->equipe->getEquipes();
        echo json_encode($equipes);
    }

    public function getEquipesAdverses($id_equipe){
        $equipes =  $this->equipe->getEquipesAdverses($id_equipe);
        echo json_encode($equipes);
    }



}
