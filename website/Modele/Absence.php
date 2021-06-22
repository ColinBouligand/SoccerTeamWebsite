<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/website/Modele/Modele.php');

/**
 * Fournit les services d'accès aux absences des joueurs
 *
 * A -> absent
 * B -> blessé
 * E -> exempt
 * N -> non licencié
 * S -> suspendu
 * R -> rien
 *
 * @author
 */
class Absence extends Modele {

    /** Renvoie la liste des absences des joueurs d'un club entre 2 dates
     *
     * @return PDOStatement La liste des absences
     */
    public function getAbsences() { // les absences de la date d'ajd + 3 dimanche (environ 25 jours)
        $sql = "SELECT * FROM ABSENCE WHERE date_absence BETWEEN current_date AND date_add(current_date,interval 25 day) ";
        $absences = $this->executerRequete($sql);
        return $absences->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAbsencesDates($date_d, $date_f) {
        $sql = "SELECT * FROM ABSENCE WHERE date_absence BETWEEN :datedeb AND :datefin";
        $absences = $this->executerRequete($sql, array('datedeb' => $date_d, 'datefin' => $date_f));
        return $absences->fetchAll(PDO::FETCH_ASSOC);
    }

    public function absencesJoueur($id_joueur){
        $absencesJoueur = $this->executerRequete("SELECT id_absence, date_absence, motif from ABSENCE where id_joueur = :id_joueur", array('id_joueur' => $id_joueur));
        return $absencesJoueur;
    }

    public function ajouterAbsence($idjoueur, $date, $motif)
    {
        $motifs_array = array('A','B','E','N','S','R');

        //vérif -> si motif différent de ceux prévus -> remplacer par A
        if(!in_array($motif,$motifs_array)) // si le motif n'est égal à aucun prévu, on le transforme en absence
        {
            $motif='A';
        }

        //vérif -> si motif = " " -> supprimer l'absence correspondante
        if($motif=='R')
        {
            $sql = "DELETE FROM ABSENCE WHERE id_joueur=:idjoueur AND date_absence=:date;";
            $this->executerRequete($sql, array('idjoueur' => $idjoueur, 'date' => $date));
            return 'Suppression d\'absence réussie';
        }

        //vérif > si il y a déjà une absence à cette date là et avec ce joueur -> si oui update / si non insert
        else{
            $sql = "SELECT * FROM ABSENCE WHERE id_joueur=:idjoueur AND  date_absence=:date AND motif=:motif";
            $res = $this->executerRequete($sql, array('idjoueur' => $idjoueur, 'date' => $date, 'motif' => $motif));

            if(!$res->fetch())// si non la faire
            {
                $sql = "INSERT INTO ABSENCE (id_joueur, date_absence, motif) VALUES (:idjoueur, :date,:motif)";
                $this->executerRequete($sql, array('idjoueur' => $idjoueur, 'date' => $date, 'motif' => $motif));
                return 'Insertion d\'absence réussie';
            }
            else{
                $sql = "UPDATE ABSENCE SET motif=:motif WHERE id_joueur=:idjoueur AND date_absence=:date";
                $this->executerRequete($sql, array('idjoueur' => $idjoueur, 'date' => $date, 'motif' => $motif));
                return 'Modification d\'absence réussie';
            }

        }



    }



}