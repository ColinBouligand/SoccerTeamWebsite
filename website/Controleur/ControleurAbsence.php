<?php

require_once($_SERVER['DOCUMENT_ROOT']."/website/Modele/Absence.php");
require_once($_SERVER['DOCUMENT_ROOT']."/website/Modele/Joueur.php");

class ControleurAbsence {
    private $absence;
    private $joueur;

    public function __construct() {
        $this->absence = new Absence();
        $this->joueur = new Joueur();
    }

    function getSunday($startDt, $endDt): array
    {
        $startDt = strtotime($startDt);
        $endDt = strtotime($endDt);
        $dateSun = array();
        do
        {
            if(date("w", $startDt) != 0)
            {
                $startDt += (24 * 3600); // add 1 day
            }
        } while(date("w", $startDt) != 0);
        while($startDt <= $endDt)
        {
            $dateSun[] = date('d-m-Y', $startDt);
            $startDt += (7 * 24 * 3600); // add 7 days
        }
        return($dateSun);
    }

    //Affiche les absences entre la date de début et la date de fin
    public function absencesTab($datedeb, $datefin){
        //Traduction des dates format HTML en dates format MySQL
        $datedeb = date("Y-m-d",strtotime($datedeb));
        $datefin = date("Y-m-d",strtotime($datefin));


        $joueurs = $this->joueur->getJoueurs();
        $dates = $this->getSunday($datedeb, $datefin);
        $tableauAbsences = array();
        array_push($tableauAbsences, array_values($dates));
        foreach($joueurs as $joueur){
            $absencesJoueur = $this->absence->absencesJoueur($joueur['id_joueur'])->fetchAll();
            $ligne = array();
            array_push($ligne, strtoupper($joueur['nom']) . ' '. $joueur['prenom']);
            array_push($ligne, $joueur['id_joueur']);

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
            //var_dump($ligne);

            array_push($tableauAbsences, $ligne);

        }
        return $tableauAbsences;

    }

    public function absencesHTML($tableauResultat)
    {
        $dates = array_shift($tableauResultat);

        /*foreach($dates as $date){
            ?>
             <td><?=$date?></td>
            <?php
        }*/
        foreach($tableauResultat as $donneesJoueur){


            $joueur = array_shift($donneesJoueur);
            $id = array_shift($donneesJoueur);
            ?>
            <tr style="border:solid black 1px" id="<?=$id?>"><td ><?=$joueur?></td>
                <?php
                foreach($donneesJoueur as $date){
                    ?>
                    <td><select >
                            <option value="r"<?= $date == ' ' ? ' selected' : ''?>></option>
                            <option value="a"<?= $date == 'A' ? ' selected' : ''?>> A</option>
                            <option value="b"<?= $date == 'B' ? ' selected' : ''?>> B</option>
                            <option value="e"<?= $date == 'E' ? ' selected' : ''?>> E</option>
                            <option value="n"<?= $date == 'N' ? ' selected' : ''?>> N</option>
                            <option value="s"<?= $date == 'S' ? ' selected' : ''?>> S</option>
                        </select></td>
                    <?php
                }
                ?>
            </tr>
            <?php

        }
    }

    public function ajouterabsence($idjoueur, $date, $motif)
    {
        $res=$this->absence->ajouterabsence($idjoueur, $date, $motif);
        echo json_encode($res);
    }


    public function getAbsences(){
        $absences =  $this->absence->getAbsences();
        echo json_encode($absences);
    }

    public function getAbsencesDates($date_d, $date_f){
        $absences =  $this->absence->getAbsencesDates($date_d, $date_f);
        echo json_encode($absences);
    }



}
