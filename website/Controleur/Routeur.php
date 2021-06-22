<?php
session_start(); // permet de l'avoir dans toutes les vues normalement

require_once($_SERVER['DOCUMENT_ROOT'].'/website/Controleur/ControleurAbsence.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/website/Controleur/ControleurJoueur.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/website/Controleur/ControleurLogin.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/website/Controleur/ControleurRencontre.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/website/Controleur/ControleurEquipe.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/website/Controleur/ControleurConvocation.php');


ini_set('display_errors', '1');
ini_set('display_startup_errors','1');
error_reporting(E_ALL);


class Routeur {

    private $ctrlAbsence;
    private $ctrlJoueur;
    private $ctrlLogin;
    private $ctrlRencontre;
    private $ctrlEquipe;
    private $ctrlConvoc;


    public function __construct() {
        $this->ctrlAbsence = new ControleurAbsence();
        $this->ctrlJoueur = new ControleurJoueur();
        $this->ctrlLogin = new ControleurLogin();
        $this->ctrlRencontre = new ControleurRencontre();
        $this->ctrlEquipe = new ControleurEquipe();
        $this->ctrlConvoc = new ControleurConvocation();
    }

    // Route une requête entrante : exécution l'action associée
    public function routerRequete() {
        try {
            if($_SERVER['REQUEST_URI'] == 'accueil')
            {
                    include('VueAccueil.php');
            }


            if (isset($_POST['action'])) {

                if ($_POST['action'] == 'ajouterabsence') {
                    $date = $_POST['date'];
                    $idjoueur = $_POST['idjoueur'];
                    $motif = $_POST['motif'];
                    $res=$this->ctrlAbsence->ajouterabsence($idjoueur,$date,$motif);
                    echo $res;
                    exit;
                }

                else if ($_POST['action'] == 'getabsences') {
                    $res = $this->ctrlAbsence->getAbsences();
                    echo $res;
                    exit;
                }
                else if ($_POST['action'] == 'getsunday') {
                    $date_d = $_POST['date_d'];
                    $date_f = $_POST['date_f'];
                    $res = $this->ctrlAbsence->getSunday($date_d,$date_f);
                    echo json_encode($res);
                    exit;
                }
                else if ($_POST['action'] == 'absencestab') {
                    $date_d = $_POST['date_d'];
                    $date_f = $_POST['date_f'];
                    $res=$this->ctrlAbsence->absencesTab($date_d,$date_f);
                    $res2 = $this->ctrlAbsence->absencesHTML($res);
                    echo $res2;
                    exit;
                }
                else if ($_POST['action'] == 'getabsencesdates') {
                    $date_d = $_POST['date_d'];
                    $date_f = $_POST['date_f'];
                    $res = $this->ctrlAbsence->getAbsencesDates($date_d,$date_f);
                    echo $res;
                    exit;
                }

                else if ($_POST['action'] == 'ajouterjoueur') {
                    $prenom = $_POST['prenom'];
                    $nom = $_POST['nom'];
                    $this->ctrlJoueur->ajouterJoueur($prenom, $nom);
                }

                else if ($_POST['action'] == 'ajoutercompetition') {
                    $compet = $_POST['competition'];
                    $this->ctrlJoueur->ajouterCompetition($compet);
                }

                else if ($_POST['action'] == 'getjoueurs') {
                    $res = $this->ctrlJoueur->getJoueurs();
                    echo $res; //POUR AJAX, ECHO ET PAS RETURN
                    exit;
                }

                else if ($_POST['action'] == 'getcompetitions') {
                    $res = $this->ctrlJoueur->getCompetitions();
                    echo $res;
                    exit;
                }

                else if ($_POST['action'] == 'supprimerjoueur') {
                    $id_joueur = $_POST['id_joueur'];
                    $this->ctrlJoueur->supprimerJoueur($id_joueur);
                }

                else if ($_POST['action'] == 'supprimercompet') {
                    $compet = $_POST['id_compet'];
                    $this->ctrlJoueur->supprimerCompet($compet);
                }
                else if ($_POST['action'] == 'getmdp') {
                    $login = $_POST['login'];
                    $res = $this->ctrlLogin->getMdp($login);
                    echo json_encode($res);
                    exit;
                }
                else if ($_POST['action'] == 'sessionrole') {
                    $role = $_POST['role'];
                    $this->ctrlLogin->sessionRole($role);

                }
                else if ($_POST['action'] == 'getcalendrier') {
                    $res = $this->ctrlRencontre->getCalendrier();
                    echo $res;
                    exit;
                }
                else if ($_POST['action'] == 'ajoutermatch') {
                    $categorie = $_POST['categorie'];
                    $id_compet = $_POST['competition'];
                    $equipe = $_POST['equipe'];
                    $equipeAdv = $_POST['equipe2'];
                    $date = $_POST['date'];
                    $heure = $_POST['heure'];
                    $terrain = $_POST['terrain'];
                    $site = $_POST['site'];
                    $res = $this->ctrlRencontre->ajouterMatch($categorie,$id_compet,$equipe,$equipeAdv,$date,$heure,$terrain,$site);

                    echo $res;
                    exit;
                }
                else if ($_POST['action'] == 'getequipes') {
                    $res = $this->ctrlEquipe->getEquipes();
                    echo $res; //POUR AJAX, ECHO ET PAS RETURN
                    exit;
                }
                else if ($_POST['action'] == 'getequipesadverses') {
                    $res = $this->ctrlEquipe->getEquipesAdverses(1); //ID de l'équipe du club
                    echo $res;
                    exit;
                }
                else if ($_POST['action'] == 'supprimermatch') {
                    $id_equipe = $_POST['id_equipe'];
                    $date = $_POST['date'];
                    $res =$this->ctrlRencontre->supprimerMatch($id_equipe,$date);
                    echo $res;
                    exit;
                }
                else if ($_POST['action'] == 'getconvoinfos') {
                    $date = $_POST['date'];
                    $equipe = $_POST['equipe'];
                    $res = $this->ctrlRencontre->getConvoInfos($date,$equipe);
                    echo $res;
                    exit;
                }
                else if ($_POST['action'] == 'getjoueursdispos') {
                    $date = $_POST['date'];
                    $equipe = $_POST['equipe'];
                    $res =$this->ctrlJoueur->getJoueursDispos($date, $equipe);
                    echo $res;
                    exit;
                }
                else if ($_POST['action'] == 'getjoueursabsents') {
                    $date = $_POST['date'];
                    $res =$this->ctrlJoueur->getJoueursAbsents($date);
                    echo $res;
                    exit;
                }
                else if ($_POST['action'] == 'saveconvo') {
                    $date = $_POST['date'];
                    $equipe = $_POST['equipe'];
                    $joueurs = $_POST['joueurs'];
                    $res =$this->ctrlConvoc->saveConvo($date,$equipe,$joueurs);
                    echo $res;
                    exit;
                }
                else if ($_POST['action'] == 'reiniconvo') {
                    $date = $_POST['date'];
                    $equipe = $_POST['equipe'];
                    $res =$this->ctrlConvoc->reiniConvo($date,$equipe);
                    echo $res;
                    exit;
                }
                else if ($_POST['action'] == 'getjoueursenregistres') {
                    $date = $_POST['date'];
                    $equipe = $_POST['equipe'];
                    $res =$this->ctrlConvoc->getJoueursEnregistres($date,$equipe);
                    echo $res;
                    exit;
                }
                else if ($_POST['action'] == 'publierconvo') {
                    $dateMatch = $_POST['dateMatch'];
                    $equipe = $_POST['equipe'];
                    $dateConvo = $_POST['dateConvo'];
                    $res =$this->ctrlConvoc->publierConvo($dateMatch,$equipe,$dateConvo);
                    echo $res;
                    exit;
                }
                else if ($_POST['action'] == 'quittersession') {
                        unset($_SESSION['role']);
                }

                else if ($_POST['action'] == 'getconvocations') {
                    $res = $this->ctrlConvoc->getConvocations();
                    echo $res;
                    exit;
                }

                else if ($_POST['action'] == 'getconvocationspubliees') {
                    $res = $this->ctrlConvoc->getConvocationsPubliees();
                    echo $res;
                    exit;
                }

            }

            if(isset($_POST["submit"])){
                $this->ctrlRencontre->importerMatchs($_FILES['csv']['tmp_name']);
            }





            else {  // aucune action définie : affichage de l'accueil

            }
        }
        catch (Exception $e) {
            $this->erreur($e->getMessage());
        }
    }

    // Affiche une erreur
    private function erreur($msgErreur) {

        echo $msgErreur;
        exit;
       // $vue = new Vue("Erreur");
       // $vue->generer(array('msgErreur' => $msgErreur));
    }

}
