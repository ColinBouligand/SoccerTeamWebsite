<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/website/Modele/Modele.php');

/**
 * Fournit les services d'accès aux logins des responsables du club
 *
 * Admin ->
 * Entraineur ->
 *
 * @author
 */
class Login extends Modele {

    /** Renvoie la liste des absences des joueurs d'un club entre 2 dates
     *
     * @return PDOStatement La liste des absences
     */
    public function getMdp($login) {


        $sql = "SELECT Mdp FROM LOGINS WHERE Login=:login";
        $mdp = $this->executerRequete($sql, array('login' => $login));
        return $mdp;
    }

}