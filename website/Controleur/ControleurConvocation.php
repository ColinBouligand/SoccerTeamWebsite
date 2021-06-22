<?php

require_once($_SERVER['DOCUMENT_ROOT']."/website/Modele/Convocation.php");

class ControleurConvocation {

    private $convocation;

    public function __construct()
    {
        $this->convocation = new Convocation();
    }


    public function saveConvo($date,$equipe,$joueurs)
    {
        //Enregistrer le lien entre le match et chaque joueur
        $res = $this->convocation->saveConvo($date,$equipe,$joueurs);
        return $res;
    }

    public function publierConvo($date,$equipe,$dateConvo)
    {
        //Publier la convo et la rendre impossible à modifier
        $res = $this->convocation->publierConvo($date,$equipe,$dateConvo);
        return $res;
    }

    public function reiniConvo($date,$equipe)
    {
        //Supprimer les lien entre le match et chaque joueur
        $res = $this->convocation->reiniConvo($date,$equipe);
        return $res;
    }

    public function getJoueursEnregistres($date,$equipe)
    {
        //Enregistrer le lien entre le match et chaque joueurs
        $res = $this->convocation->getJoueursEnregistres($date,$equipe);
        return json_encode($res);
    }

    public function getConvocations()
    {
        $res =$this->convocation->getConvocations();
        return json_encode($res);
    }

    public function getConvocationsPubliees()
    {
        $convocs =$this->convocation->getConvocations();
        //var_dump($convocs);
        $res2="";
        $res="";
        foreach($convocs as $c) { // convoc = OK
            $res = '<div class=convo>';
            $res .= '<h2>' . $c["libelle1"] . ' VS ' . $c["libelle2"] . ' </h2>';
            $res .= '<h3>Compétition : ' . $c["nom_competition"] . '</h3>';
            $res .= '<h3>' . $c["date_rencontre"] . ' ' . $c["heure_rencontre"] . '</h3>';
            $res .= '<h3>Site : ' . $c["site"] . '</h3>';
            $res .= '<h3>Terrain : ' . $c["terrain"] . '</h3>';
            $res .= '<div class=joueurs-convo>';
            $res .= '<h3 >Joueurs convoqués :</h3>';
            $joueurs = $this->convocation->getJoueursEnregistres($c["date_rencontre"], $c['id_equipe']);
            //var_dump($joueurs);
            foreach ($joueurs as $j) {
                //var_dump($j);
                $res .= '<span>' . $j["nom"]. ' ' . $j["prenom"] . ' </span>';
            }

            $res .= '</div></div>'; // fin div convoc
            $res2 .= $res;

        }


        return $res2;
    }





}
