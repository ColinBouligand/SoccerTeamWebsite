<?php

require_once($_SERVER['DOCUMENT_ROOT']."/website/Modele/Joueur.php");

class ControleurJoueur {

    private $joueur;

    public function __construct() {

        $this->joueur = new Joueur();
    }



    //Affiche les absences entre la date de début et la date de fin
    public function absences($datedeb, $datefin){
        //Traduction des dates format HTML en dates format MySQL
        $datedeb = date("Y-m-d",strtotime($datedeb));
        $datefin = date("Y-m-d",strtotime($datefin));


        $joueurs = $this->joueur->getJoueurs()->fetchAll();
        $dates = $this->getSunday($datedeb, $datefin);
        $tableauAbsences = array();
        array_push($tableauAbsences, array_values($dates));
        foreach($joueurs as $joueur){
            $absencesJoueur = $this->absence->absencesJoueur($joueur['id_joueur'])->fetchAll();
            $ligne = array();
            array_push($ligne, $joueur['prenom'] . ' '. $joueur['nom']);

            foreach ($dates as $date){
                foreach($absencesJoueur as $absenceJoueur){
                    if(date("d-m-Y", strtotime($absenceJoueur['date_absence'])) == $date){
                        $motifAbsence = $absenceJoueur['motif'];
                    }
                }
                if(isset($motifAbsence) ){
                    array_push($ligne, $motifAbsence[0]);

                    unset($motifAbsence);
                    unset($id_absence);

                } else
                    array_push($ligne, ' ');
            }
            array_push($tableauAbsences, $ligne);

        }
        return $tableauAbsences;

    }


    public function ajouterJoueur($prenom,$nom)
    {
        $this->joueur->ajouterJoueur($prenom, $nom);
    }

    public function ajouterCompetition($compet)
    {
        $this->joueur->ajouterCompetition($compet);
    }

    public function getCompetitions(){
        $compets =  $this->joueur->getCompetitions();
        echo json_encode($compets); //transforme le tableau en json pour le rendre lisible par JS
    }

    public function getJoueurs(){
        $joueurs =  $this->joueur->getJoueurs();
        echo json_encode($joueurs);
    }

    public function supprimerJoueur($id_joueur)
    {
        $this->joueur->supprimerJoueur($id_joueur);
    }

    public function supprimerCompet($compet)
    {
        $this->joueur->supprimerCompet($compet);
    }

    public function getJoueursDispos($date, $equipe){
        $joueurs =  $this->joueur->getJoueursDispos($date, $equipe);
        echo json_encode($joueurs);
    }

    public function getJoueursAbsents($date){
        $joueurs =  $this->joueur->getJoueursAbsents($date);
        echo json_encode($joueurs);
    }


}
