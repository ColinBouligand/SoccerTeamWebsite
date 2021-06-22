<?php

require_once($_SERVER['DOCUMENT_ROOT']."/website/Modele/Modele.php");

class Convocation extends Modele
{


    public function saveConvo($date,$equipe,$joueurs){

        //Supprime les relations match-joueurs s'il en existe déjà
        $sql = 'DELETE FROM ASSOCIATION_CONVOCATION WHERE id_equipe =:id_equipe  AND date_rencontre=:date';
        $this->executerRequete($sql, array('id_equipe' => $equipe,'date' => $date));



        foreach($joueurs as $j) // pour chaque joueur
        {
            //regarder si la relation joueur-match n'existe pas déjà

            $sql = 'SELECT * FROM ASSOCIATION_CONVOCATION WHERE id_equipe =:id_equipe AND id_joueur=:id_joueur AND date_rencontre=:date';
            $res1 =$this->executerRequete($sql, array('id_equipe' => $equipe,'date' => $date,'id_joueur' => $j));

            if(!$res1->fetch())// si non la faire
            {
                $sql = 'INSERT INTO ASSOCIATION_CONVOCATION (id_equipe,id_joueur,date_rencontre) values (:id_equipe,:id_joueur, :date)';
                $res =  $this->executerRequete($sql, array('id_equipe' => $equipe,'date' => $date,'id_joueur' => $j));
            }
        }
        return 'Convocation enregistrée';
    }

    public function reiniConvo($date,$equipe)
    {

        //Supprime les relations match-joueurs s'il en existe déjà
        $sql = 'DELETE FROM ASSOCIATION_CONVOCATION WHERE id_equipe =:id_equipe  AND date_rencontre=:date';
        $this->executerRequete($sql, array('id_equipe' => $equipe, 'date' => $date));
        return 'Convocation réinitialisée !';

    }

    public function publierConvo($date,$equipe,$dateConvo)
    {

        //Ajoute une date de convo à tous les joueurs de la convo
        $sql = 'UPDATE RENCONTRE SET date_convocation=:dateConvo WHERE id_equipe =:id_equipe  AND date_rencontre=:date';
        $this->executerRequete($sql, array('id_equipe' => $equipe, 'date' => $date, 'dateConvo' => $dateConvo));
        return 'Convocation publiée !';

    }


    public function getJoueursEnregistres($date,$equipe){
        $sql = 'SELECT * FROM ASSOCIATION_CONVOCATION A INNER JOIN JOUEUR ON A.id_joueur = JOUEUR.id_joueur AND A.date_rencontre=:date AND A.id_equipe=:equipe 	';
        $res = $this->executerRequete($sql, array('date' => $date, 'equipe' => $equipe));
        return $res->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getConvocations(){
        $sql = 'SELECT R.categorie,R.competition, R.id_equipe, R.adversaire, R.date_rencontre,
                R.heure_rencontre,R.terrain,R.site, E.libelle as libelle1, A.libelle as libelle2, C.nom_competition, R.date_convocation
FROM RENCONTRE R INNER JOIN EQUIPE E ON R.id_equipe = E.id_equipe INNER JOIN EQUIPE_ADVERSE A ON R.adversaire = A.id_equipe_adv INNER JOIN COMPETITION C ON R.competition = C.id_competition 
                WHERE R.date_convocation <> "NULL" ORDER BY R.date_convocation	';
        $res = $this->executerRequete($sql);
        return $res->fetchAll(PDO::FETCH_ASSOC);
    }

}