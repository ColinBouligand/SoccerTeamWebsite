<?php

require_once($_SERVER['DOCUMENT_ROOT']."/website/Modele/Modele.php");

class Joueur extends Modele
{


    public function ajouterJoueur($prenom, $nom)
    {
        $sql = 'INSERT INTO JOUEUR (prenom, nom) VALUES (:prenom, :nom)';
        $this->executerRequete($sql, array('prenom' => $prenom, 'nom' => $nom));
        return 'Insertion de joueur réussie';
    }

    public function ajouterCompetition($compet)
    {
        $sql = 'INSERT INTO COMPETITION (nom_competition) VALUES (:compet)';
        $this->executerRequete($sql, array('compet' => $compet));
        return 'Insertion de compétition réussie';
    }


    public function getJoueurs(){
        $sql = 'SELECT * FROM JOUEUR ORDER BY nom ASC';
        $joueurs = $this->executerRequete($sql);
        return $joueurs->fetchAll(PDO::FETCH_ASSOC);
    }


    public function getCompetitions(){
        $sql = 'SELECT * FROM COMPETITION ORDER BY nom_competition ASC';
        $compets = $this->executerRequete($sql);
        return $compets->fetchAll(PDO::FETCH_ASSOC);
    }


    public function supprimerJoueur($id_joueur){

        //supprimer les absences du joueur

        //Vérifier que le joueur n'existe pas déjà (nom + prénom)
        $sql = 'DELETE FROM JOUEUR WHERE id_joueur=:id_joueur';
        $this->executerRequete($sql, array('id_joueur' => $id_joueur));
        return 'Suppression de joueur réussie';
    }

    public function supprimerCompet($compet){

        //supprimer des convocs

        //vérif que la compet n'existe pas déjà
        $sql = 'DELETE FROM COMPETITION WHERE id_competition =:compet';
        $this->executerRequete($sql, array('compet' => $compet));
        return 'Suppression de compétition réussie';
    }

    public function getJoueursDispos($date,$equipe){
        $sql = 'SELECT * FROM JOUEUR WHERE id_joueur not IN (SELECT ABSENCE.id_joueur FROM ABSENCE WHERE date_absence=:date ) 
                       AND id_joueur not IN (SELECT ASSOCIATION_CONVOCATION.id_joueur FROM ASSOCIATION_CONVOCATION WHERE date_rencontre=:date ) ORDER BY nom ASC';
        $joueurs = $this->executerRequete($sql,array('date' => $date, 'equipe' => $equipe));
        return $joueurs->fetchAll(PDO::FETCH_ASSOC);
    }


    public function getJoueursAbsents($date){
        $sql = 'SELECT  JOUEUR.id_joueur, nom, prenom, motif FROM JOUEUR INNER JOIN ABSENCE ON JOUEUR.id_joueur = ABSENCE.id_joueur  WHERE date_absence=:date ORDER BY nom ASC';
        $joueurs = $this->executerRequete($sql,array('date' => $date));
        return $joueurs->fetchAll(PDO::FETCH_ASSOC);
    }


    }