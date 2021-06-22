<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/website/Controleur/Routeur.php");
require_once("../Modele/GestionConnexion.php");

$routeur = new Routeur();
$routeur->routerRequete();


?>


<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="../content/style.css"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <title>Admin</title>

    <style>

        .main {
            width: 90%;
            height: 80%;
            margin: 5%;
            background-color: white;
            display: flex;
            justify-content: space-around;
            border-radius: 1%;

        }

        .btn-add {
            background-color: #4CAF50; /* Green */
            border: none;
            color: white;
            padding: 5px 15px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
        }

        .ajout_div {
            text-align: center;
        }

        ul {
            list-style-type: none;
        }

        .liste_joueurs {
            overflow: auto;
            height: 75%;

        }

        .liste_compet {
            overflow: auto;
            height: 75%;

        }

        .del_joueur {
            margin-left: 2%;
        }

        .del_compet {
            margin-left: 2%;
        }

        li {
            display: flex;
            justify-content: space-between;
        }
        html, body {
            margin:0px;
            min-height: 100%;

        }
        header{
            position:relative;
            width:100%;
            height:10%;
            top:0%;
            background-color: lightgrey;
        }
        .btn{
            background-color: #4CAF50; /* Green */
            border: none;
            color: white;
            padding: 5px 15px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            position:relative;
            margin:1%;
        }

        .btn-conn, .btn-deconn{
            left:55%;
        }

        .btn-conv{
            left:50%
        }

        .btn-reg{
            left: 10%;
        }
        .btn-cal{
            left:10%;
        }
        .btn-abs{
            left:10%;
        }


    </style>
</head>
<body>
<header>
    <button class="btn btn-acc" onclick="window.location.href='VueAccueil.php';">Accueil</button>
    <?php
    if(isset($_SESSION['role'])){
    if($_SESSION['role'] =='admin')
    {
        //afficher 3 boutons de plus dans le header (calendrier, planning, création)
        echo '<button class="btn btn-reg" onclick="window.location.href=\'VueAdmin.php\'">Réglages</button>';
        echo '<button class="btn btn-cal" onclick="window.location.href=\'VueCalendrier.php\'">Calendrier</button>';
        echo '<button class="btn btn-abs" onclick="window.location.href=\'VueAbsence.php\'">Absences</button>';
    }

    if($_SESSION['role']=='entraineur')
    {
        //afficher le formulaire de création de convo
        echo '<button class="btn btn-conv" onclick="window.location.href=\'VueConvocation.php\'">Convocation</button>';
    }


        echo '<button class="btn btn-deconn" onclick="window.location.href=\'VueAccueil.php\';unset($_SESSION[\'role\']);">Déconnexion</button>';
        //si clic sur déconnexion, renvoyer à l'accueil et supprimer le param role de session
    }


    else
    {
        //afficher le formulaire de création de convo
        echo '<button class="btn btn-conn" onclick="window.location.href=\'VueConnexion.php\';">Connexion</button>';
    }
    ?>

</header>

<div class="accueil">
    <div class="main">
        <div class="ajout_div">
            <h2>JOUEURS</h2>
            <label>Ajouter un joueur au club :</label>

            <input id="pren_j" type="text" placeholder="Prénom"> <input id="nom_j" type="text" placeholder="Nom">

            <button class="btn-add" id="add_joueur"> Ajouter joueur</button>
            <div class="liste_joueurs">

                <ul id="joueurs"></ul>

            </div>

        </div>
        <div class="ajout_div">
            <h2>COMPETITIONS</h2>
            <label>Ajouter une compétition au club :</label>

            <input id="nom_compet" type="text" placeholder="Nom compétition">
            <button class="btn-add" id="add_compet"> Ajouter compétition</button>

            <div class="liste_compet">
                <ul id="compets"></ul>

            </div>
        </div>
    </div>
</div>
<script>


    function loadJoueurs(joueurs) {

        var liste = $("#joueurs")
        //Object.keys(joueurs).forEach(function(k){
        for (k in joueurs) {

            liste.append("<li> " + joueurs[k]["nom"].toUpperCase() + " " + joueurs[k]["prenom"] + " <button class=del_joueur data-id=" + joueurs[k]["id_joueur"] + "> Supprimer</button></li>")
        }
        //});


    }

    function loadCompet(compets) {
        var liste = $("#compets")
        for (c in compets) {
            liste.append("<li> " + compets[c]["nom_competition"] + "  <button class=del_compet data-id=" + compets[c]["id_competition"] + "> Supprimer</button></li>")
        }
    }

    //AFFICHER JOUEURS

    function reloadJoueurs() {
        $.ajax({
            url: '?',
            async: true,
            "type": 'POST',
            data: {
                'action': 'getjoueurs'
            },
            dataType: 'json',
            success: function (data) {
                loadJoueurs(data);
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                alert("Status: " + textStatus);
                alert("Error: " + errorThrown);

            }
        });
    }

    $(document).ready(function () {
        reloadJoueurs()
        reloadCompet()
    })


    //AFFICHER COMPETITIONS

    function reloadCompet() {
        var liste = $("#compets") //remet à 0 la liste de compets avant de la reremplir

        liste.innerHTML = '';

        $.ajax({
            url: '?',
            async: true,
            "type": 'POST',
            data: {
                'action': 'getcompetitions'
            },
            dataType: 'json',
            success: function (data) {
                loadCompet(data);
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                alert("Status: " + textStatus);
                alert("Error: " + errorThrown);

            }
        });
    }


    //AJOUTER UN JOUEUR
    $(document).on('click', '#add_joueur', function () { // fonctionne avec les button mais pas les a ??

            if($("#pren_j").val() && $("#nom_j").val())
            {
                $.ajax({
                    url: '?',
                    async: true,
                    "type": 'POST',
                    data: {
                        'action': 'ajouterjoueur',
                        'prenom': $("#pren_j").val(),
                        'nom': $("#nom_j").val()
                    },
                    success: function () {

                        $('#joueurs').empty();
                        reloadJoueurs()
                        //supprimer le contenu des input
                    }
                });
            }

    });


    //AJOUTER UNE COMPETITON
    $(document).on('click', '#add_compet', function () {

        if($("#nom_compet").val()) {


            $.ajax({
                url: '?',
                async: true,
                "type": 'POST',
                data: {
                    'action': 'ajoutercompetition',
                    'competition': $("#nom_compet").val()
                },

                success: function () {
                    $('#compets').empty();
                    reloadCompet()
                    //supprimer le contenu des input
                }
            });
        }
    });


    //SUPPRIMER UN JOUEUR
    $(document).on('click', '.del_joueur', function () { // fonctionne avec les button mais pas les a ??

        $(this).closest('li').remove(); // supprime le li parent
        $.ajax({
            url: '?',
            async: true,
            "type": 'POST',
            data: {
                'action': 'supprimerjoueur',
                'id_joueur': $(this).data("id")
            },
            success: function () {

            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                console.log("Status: " + textStatus);
                console.log("Error: " + errorThrown);
            }
        });
    });


    //SUPPRIMER UNE COMPET
    $(document).on('click', '.del_compet', function () { // fonctionne avec les button mais pas les a ??

        $(this).closest('li').remove(); // supprime le li parent
        $.ajax({
            url: '?',
            async: true,
            "type": 'POST',
            data: {
                'action': 'supprimercompet',
                'id_compet': $(this).data("id")
            },
            success: function () {

            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                console.log("Status: " + textStatus);
                console.log("Error: " + errorThrown);
            }
        });
    });

    //DECONNEXION
    $(document).on('click', '.btn-deconn', function () { // fonctionne avec les button mais pas les a ??
        $.ajax({
            url: '?',
            async: true,
            "type": 'POST',
            data: {
                'action': 'quittersession'
            },
            success: function () {
                window.location.href='VueAccueil.php'
            }
        });
    });


</script>
</body>
</html>
