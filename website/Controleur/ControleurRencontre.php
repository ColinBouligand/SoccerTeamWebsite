<?php

require_once($_SERVER['DOCUMENT_ROOT']."/website/Modele/Rencontre.php");

class ControleurRencontre {

    private $rencontre;

    public function __construct()
    {
        $this->rencontre = new Rencontre();
    }


    public function getCalendrier()
    {
        $cal =$this->rencontre->getCalendrier();
        return json_encode($cal);
    }

    public function ajouterMatch($categorie,$compet, $equipe, $equipe2,$date,$heure,$terrain, $site)
    {

        //Verifier que l'équipe n'a pas déjà un match
        $tmp =$this->rencontre->getMatch($equipe,$date);
        if(!$tmp)
        {
            $res = $this->rencontre->ajouterMatch($categorie,$compet, $equipe, $equipe2,$date,$heure,$terrain, $site);

        }
        else $res = "Cette équipe a déjà un match de prévu pour ce jour là";


        return $res;
    }

    public function supprimerMatch($id_equipe, $date)
    {
        $this->rencontre->supprimerMatch($id_equipe,$date);
    }

    public function importerMatchs($csv){
        $this->rencontre->importerMatchs($csv);
    }

    public function getConvoInfos($date,$equipe)
    {
        $convo =$this->rencontre->getConvoInfos($equipe, $date);
        echo json_encode($convo);
    }







}
