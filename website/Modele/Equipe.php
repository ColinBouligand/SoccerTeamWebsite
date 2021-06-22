<?php

require_once($_SERVER['DOCUMENT_ROOT']."/website/Modele/Modele.php");

class Equipe extends Modele
{


    public function getEquipes(){
        $sql = 'SELECT * FROM EQUIPE ORDER BY libelle ASC';
        $equipes = $this->executerRequete($sql);
        return $equipes->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getEquipesAdverses($id_equipe){
        $sql = 'SELECT * FROM EQUIPE_ADVERSE WHERE id_equipe=:id_equipe ORDER BY libelle ASC';
        $equipes = $this->executerRequete($sql, array('id_equipe' => $id_equipe));
        return $equipes->fetchAll(PDO::FETCH_ASSOC);
    }



}