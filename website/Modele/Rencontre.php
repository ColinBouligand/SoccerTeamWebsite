<?php

require_once($_SERVER['DOCUMENT_ROOT']."/website/Modele/Modele.php");

class Rencontre extends Modele
{

    public function getCalendrier(){
        $sql = 'SELECT R.categorie,R.competition, R.id_equipe, R.adversaire, R.date_rencontre,R.heure_rencontre,R.terrain,R.site, E.libelle as libelle1, A.libelle as libelle2, C.nom_competition
                FROM RENCONTRE R INNER JOIN EQUIPE E ON R.id_equipe = E.id_equipe 
                INNER JOIN EQUIPE_ADVERSE A ON R.adversaire = A.id_equipe_adv 
                INNER JOIN COMPETITION C ON R.competition = C.id_competition 
                WHERE date_rencontre > current_date ORDER BY date_rencontre ASC';
        $calendrier = $this->executerRequete($sql);
        return $calendrier->fetchAll(PDO::FETCH_ASSOC);
    }


    public function ajouterMatch($categorie,$compet, $equipe, $equipe2,$date,$heure,$terrain, $site){


        $sql = 'INSERT INTO RENCONTRE (categorie,competition, id_equipe, adversaire, date_rencontre,heure_rencontre,terrain,site) values (:categorie,:compet, :equipe, :equipe2, :date,:heure,:terrain,:site) 	';
        $this->executerRequete($sql, array('categorie' => $categorie,'compet' => $compet,'equipe' => $equipe,'equipe2' => $equipe2,'date' => $date,'heure' => $heure,'terrain' => $terrain,'site' => $site));
        return 'Insertion de match réussie';
    }

    public function supprimerCompet($compet){

        //supprimer des convocs

        //vérif que la compet n'existe pas déjà
        $sql = 'DELETE FROM COMPETITION WHERE id_competition =:compet';
        $this->executerRequete($sql, array('compet' => $compet));
        return 'Suppression de compétition réussie';
    }

    public function getMatch($equipe,$date){


        //vérif que la compet n'existe pas déjà
        $sql = 'SELECT * FROM RENCONTRE WHERE id_equipe=:equipe AND date_rencontre=:date';
        $res =$this->executerRequete($sql, array('equipe' => $equipe, 'date'=>$date));
        return $res->fetch(PDO::FETCH_ASSOC);
    }

    public function supprimerMatch($id_equipe, $date){

            $sql = 'DELETE FROM RENCONTRE WHERE id_equipe=:id_equipe AND date_rencontre=:date';
            $this->executerRequete($sql, array('id_equipe' => $id_equipe, 'date' => $date));

            return 'Suppression de match réussie';
    }

    public function importerMatchs($csv){
        $file = fopen($csv,"r");

        $valid = false;
        while (($data = fgetcsv($file, 1000, ";")) !== FALSE)
        {
            #Vérification de la validité du csv
            if(!$valid){
                if($data[0] == 'categorie' && $data[1] == 'competition' && $data[2] == 'id_equipe' && $data[3] == 'adversaire' && $data[4] == 'date_rencontre' && $data[5] == 'heure_rencontre' && $data[6] == 'terrain' && $data[7] == 'site'){
                    $valid = true;
                } else {
                    return 'Echec, csv non conforme';
                }

            } else {
                $this->ajouterMatch($data[0], $data[1], $data[2], $data[3], $data[4], $data[5], $data[6], $data[7]);
            }
        }

        return 'Import réussi';
    }

    public function getConvoInfos($equipe,$date){
        $sql = 'SELECT R.categorie,R.competition, R.id_equipe, R.adversaire, R.date_rencontre,
                R.heure_rencontre,R.terrain,R.site, E.libelle as libelle1, A.libelle as libelle2, C.nom_competition , R.date_convocation
FROM RENCONTRE R INNER JOIN EQUIPE E ON R.id_equipe = E.id_equipe INNER JOIN EQUIPE_ADVERSE A ON R.adversaire = A.id_equipe_adv INNER JOIN COMPETITION C ON R.competition = C.id_competition 
           WHERE R.date_rencontre=:date AND R.id_equipe=:equipe      '; //WHERE R.date_convocation <> "NULL"
        $res =$this->executerRequete($sql, array('equipe' => $equipe, 'date'=>$date));
        return $res->fetch(PDO::FETCH_ASSOC);
    }

}