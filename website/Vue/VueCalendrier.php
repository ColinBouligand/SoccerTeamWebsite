<?php

require_once("../Controleur/Routeur.php");
require_once("../Modele/GestionConnexion.php");


//à déplacer dans index.php !
$routeur = new Routeur();
$routeur->routerRequete();


?>


<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Calendrier</title>
    <style>
        .container-calendar {
            text-align: center;
            position: relative;
            width: 80%;
            height: 80%;
            top: 10%;
            left: 10%;
        }

        .calendar {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            margin: 2%;
        }

        .legend {
            font-weight: bold;
            display: flex;
            flex-direction: column;
            margin-bottom: 5%;
        }

        .cal, .cal2 {
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .cal span {
            margin: 5%;
        }

        #csv_file_div {
            margin-bottom: 3%;
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


<div class="container-calendar">

    <h1> CALENDRIER DES RENCONTRES</h1>
    <form method="post" enctype="multipart/form-data">
        <div id="csv_file_div"><span>Ajouter des matchs à partir d'un csv : </span><input type="file" name="csv"
                                                                                          id="add_calendar_csv"><input
                    class="button" type="submit" name="submit" value="Ajouter">
    </form>
</div>
<span id="cal-mess"></span>
<div class="calendar">
    <div class="cal"><span class="legend">Catégorie</span>
        <span id="add_cat">Senior</span></div>
    <div class="cal"><span class="legend">Compétition</span>
        <select id="add_competition"></select></div>
    <div class="cal"><span class="legend">Equipe</span>
        <select id="add_equipe"></select></div>
    <div class="cal"><span class="legend">Equipe Adverse</span>
        <select id="add_equipe2"></select></div>
    <div class="cal"><span class="legend">Date</span>
        <input type="date" id="add_date"></div>
    <div class="cal"><span class="legend">Heure</span>
        <input type="time" id="add_heure"></div>
    <div class="cal"><span class="legend">Terrain</span>
        <input type="text" id="add_terrain"></div>
    <div class="cal"><span class="legend">Site</span>
        <input type="text" id="add_site">
    </div>
    <div class="cal">
        <span class="legend">Actions</span>
        <button id="add_match">Ajouter match</button>

    </div>

</div>

<div class="calendar">
    <div class="cal2 cal-categ">
    </div>
    <div class="cal2 cal-compet">
    </div>
    <div class="cal2 cal-equ1">
    </div>
    <div class="cal2 cal-equ2">
    </div>
    <div class="cal2 cal-date">
    </div>
    <div class="cal2 cal-heure">
    </div>
    <div class="cal2 cal-terrain">
    </div>
    <div class="cal2 cal-site">

    </div>
    <div class="cal2 cal-actions">

    </div>


    <script>

        //CHARGER LE SELECT EQUIPE

        $('document').ready(function () {
            $.ajax({
                url: '?',
                async: true,
                "type": 'POST',
                data: {
                    'action': 'getequipes'
                },
                dataType: 'json',
                success: function (data) {

                    for (i in data) {
                        $('#add_equipe').append(new Option(data[i]['libelle'], data[i]['id_equipe']))

                    }

                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    alert("Status: " + textStatus);
                    alert("Error: " + errorThrown);

                }
            });
            //CHARGER LE SELECT COMPETTION

            $.ajax({
                url: '?',
                async: true,
                "type": 'POST',
                data: {
                    'action': 'getcompetitions'
                },
                dataType: 'json',
                success: function (data) {

                    for (i in data) {
                        $('#add_competition').append(new Option(data[i]['nom_competition'], data[i]['id_competition']))

                    }

                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    alert("Status: " + textStatus);
                    alert("Error: " + errorThrown);

                }
            });
            //CHARGER LE SELECT EQUIPE ADVERSE
            $.ajax({
                url: '?',
                async: true,
                "type": 'POST',
                data: {
                    'action': 'getequipesadverses'
                },
                dataType: 'json',
                success: function (data) {

                    for (i in data) {
                        $('#add_equipe2').append(new Option(data[i]['libelle'], data[i]['id_equipe_adv']))

                    }

                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    alert("Status: " + textStatus);
                    alert("Error: " + errorThrown);

                }
            });

            displayMatch()


        });

        //AFFICHER LES MATCHS

        function displayMatch() {
            //clean la div

            $('.cal2').empty()


            $.ajax({
                url: '?',
                async: true,
                "type": 'POST',
                data: {
                    'action': 'getcalendrier'
                },
                dataType: 'json',
                success: function (data) {
                    for (i in data) {
                        $('.cal-categ').append("<span>" + data[i]["categorie"] + "</span>")
                        $('.cal-compet').append("<span>" + data[i]["nom_competition"] + "</span>")
                        $('.cal-equ1').append("<span>" + data[i]["libelle1"] + "</span>")
                        $('.cal-equ2').append("<span>" + data[i]["libelle2"] + "</span>")
                        $('.cal-date').append("<span>" + data[i]["date_rencontre"] + "</span>")
                        $('.cal-heure').append("<span>" + data[i]["heure_rencontre"] + "</span>")
                        $('.cal-terrain').append("<span>" + data[i]["terrain"] + "</span>")
                        $('.cal-site').append("<span>" + data[i]["site"] + "</span>")
                        $('.cal-actions').append(/*"<button class=mod-match data-id-equipe="+data[i]["id_equipe"]+" data-date="+data[i]["date_rencontre"]+">Modifier</button>*/"<button class=del-match data-id-equipe=" + data[i]["id_equipe"] + " data-date=" + data[i]["date_rencontre"] + ">Supprimer</button>")


                    }
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    alert("Status: " + textStatus);
                    alert("Error: " + errorThrown);

                }
            });
        }


        //AFFICHER RETOUR UTILISATEUR

        function displayMessage(message, couleur) {
            $('#cal-mess').text(message);
            $('#cal-mess').css("color", couleur);

        }


        //AJOUTER MATCH AU CALENDRIER
        $(document).on('click', '#add_match', function () {

            //check que tous les champs sont remplis
            if ($("#add_date").val() && $("#add_terrain").val() && $("#add_site").val() && $("#add_heure").val()) {

                // check si c'est un dimanche

                date = $("#add_date").val()
                jour = new Date(date)

                var day = jour.getDay();
                var isSunday = (day === 0);// 0 = Sunday

                if (isSunday) {
                        $.ajax({
                            url: '?',
                            async: true,
                            "type": 'POST',
                            data: {
                                'action': 'ajoutermatch',
                                'categorie': 'Senior',
                                'competition': $("#add_competition option:selected").val(),
                                'equipe': $("#add_equipe option:selected").val(),
                                'equipe2': $("#add_equipe2").val(),
                                'date': $("#add_date").val(),
                                'heure': $("#add_heure").val(),
                                'terrain': $("#add_terrain").val(),
                                'site': $("#add_site").val()
                            },
                            success: function (message) {
                                //retour utilisateur
                                displayMessage(message, "green")
                                //mettre à jour le calendrier
                                displayMatch()

                                //vider les champs
                            }
                        });
                } else {
                    message = "Veuillez choisir un dimanche"
                    displayMessage(message, "red")
                }
            } else {
                message = "Veuillez remplir tous les champs"
                displayMessage(message, "red")
            }


        });

        //SUPPRIMER MATCH DU CALENDRIER
        $(document).on('click', '.del-match', function () {


            $.ajax({
                url: '?',
                async: true,
                "type": 'POST',
                data: {
                    'action': 'supprimermatch',
                    'id_equipe': $(this).data('id-equipe'),
                    'date': $(this).data('date')

                },
                success: function (message) {

                    //displayMessage(message,"green")
                    displayMatch()
                    //mettre à jour la table

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