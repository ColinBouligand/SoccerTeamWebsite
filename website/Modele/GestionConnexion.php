<?php
if(!isset($_SESSION['role'])){
    $host = $_SERVER['HTTP_HOST'];
    header("Location: http://$host/VueConnexion.php");
}