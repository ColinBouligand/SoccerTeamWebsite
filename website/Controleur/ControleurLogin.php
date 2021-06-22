<?php

require_once($_SERVER['DOCUMENT_ROOT']."/website/Modele/Login.php");

class ControleurLogin {

    private $login;

    public function __construct() {

        $this->login = new Login();
    }

    public function getMdp($login)
    {

        if($login=='admin' || $login=='entraineur') {
            $mdp = $this->login->getMdp($login);
            return $mdp->fetch();
        }
        else return 'Identifiant mauvais';

    }
    public function sessionRole($role)
    {
        $_SESSION['code']= ($role == 'admin' ? 1 : 2);
        $_SESSION['role']= $role;

    }




}
