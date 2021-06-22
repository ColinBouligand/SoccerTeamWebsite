<?php


require_once($_SERVER['DOCUMENT_ROOT']."/website/Controleur/Routeur.php");
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <title>Accueil</title>
    <style>
        html, body {
            margin:0px;
            min-height: 100%;
            background-image: url("https://images.pexels.com/photos/114296/pexels-photo-114296.jpeg?auto=compress&cs=tinysrgb&dpr=3&h=750&w=1260");
            background-size: cover;

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

            left:60%
        }

        .btn-conv{
            left:10%
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

        .container_convo{
            position:relative;
            width:100%;
            height:90%;
            min-height:500px;
            top:10%;
            text-align: center;
            display: flex;
            align-items: center;
            flex-direction: column;
            

        }

        .list_convos{
            position:relative;
            width:70%;
            height:70%;
            text-align: center;

        }

        .convo{
            text-align: center;
            background-color:white;
            border-radius:1%;
            margin:5%;

        }
        .convo h2,h3 {
            padding:0;
            margin:0;
        }
        .joueurs-convo{
            display:flex;
            flex-direction: column;
            flex-wrap: wrap;
        }
    </style>
</head>
<body>
<header>
    <?php

    if(isset($_SESSION['role'])) {

        if ($_SESSION['role'] == 'admin') {
            //afficher 3 boutons de plus dans le header (calendrier, planning, création)
            echo '<button class="btn btn-reg" onclick="window.location.href=\'VueAdmin.php\'">Réglages</button>';
            echo '<button class="btn btn-cal" onclick="window.location.href=\'VueCalendrier.php\'">Calendrier</button>';
            echo '<button class="btn btn-abs" onclick="window.location.href=\'VueAbsence.php\'">Absences</button>';
        }

        if ($_SESSION['role'] == 'entraineur') {
            //afficher le formulaire de création de convo
            echo '<button class="btn btn-conv" onclick="window.location.href=\'VueConvocation.php\'">Convocation</button>';
        }

        echo '<button class="btn btn-deconn" >Déconnexion</button>';
        //si clic sur déconnexion, renvoyer à l'accueil et supprimer le param role de session
    }


    else
    {
        //afficher le formulaire de création de convo
        echo '<button class="btn btn-conn" onclick="window.location.href=\'VueConnexion.php\';">Connexion</button>';
    }
    ?>

</header>

    <div class="container_convo">
        <h1>Bienvenue sur le site du club de foot de Laval !</h1>
        <h2>Liste des convocations</h2>
         <div class="list_convos">


      </div>
    </div>
<script>

    /** 2E METHODE DE BOURRIN AVEC DU HTML **/
    $(document).ready(function () {
        $.ajax({
            url: '?',
            async: true,
            "type": 'POST',
            data: {
                'action': 'getconvocationspubliees'
            },
            dataType:"text",
            success: function (data) {
                console.log(data)
                $('.list_convos').append(data)


            }
        });
    });


    /** METHODE AVEC AJAX NE FONCTIONNE PAS TOTALEMENT**/

    //CHARGER LISTE CONVOCS

   /* $(document).ready(function () {

        $.ajax({
            url: '?',
            async: true,
            "type": 'POST',
            data: {
                'action': 'getconvocations'
            },
            dataType: 'json',
            success: function (convocs) {
                console.log(convocs)
                for(convoc in convocs)
                {
                    //afficher infos convos

                    $('.list_convos').append('<div class=convo id="convo'+convoc+'" data-date='+convocs[convoc]["date_rencontre"]+' data-equipe='+convocs[convoc]["id_equipe"]+'></div>')
                    $('#convo'+convoc).append('<h2>'+convocs[convoc]["libelle1"]+' VS '+convocs[convoc]["libelle2"]+' </h2>')
                    $('#convo'+convoc).append('<h3>Compétition : '+convocs[convoc]["nom_competition"]+'</h3>')
                    $('#convo'+convoc).append('<h3>'+convocs[convoc]["date_rencontre"]+' '+ convocs[convoc]["heure_rencontre"]+'</h3>')
                    $('#convo'+convoc).append('<h3>Site : '+convocs[convoc]["site"]+'</h3>')
                    $('#convo'+convoc).append('<h3>Terrain : '+convocs[convoc]["terrain"]+'</h3>')



                        $.ajax({
                            url: '?',
                            async: true,
                            "type": 'POST',
                            data: {
                                'action': 'getjoueursenregistres',
                                'date': convocs[convoc]['date_rencontre'],
                                'equipe': convocs[convoc]['id_equipe']
                            },
                            dataType: 'json',
                            success: function (joueurs) {
                                console.log(joueurs)
                                //retrouver la div correspondant au match :


                                convs = $('.convo')
                                console.log(convs)
                               /* for(c=0; c< convs.length; c++)
                                {
                                    console.log(convs[c])
                                    if(convs[c].attr('data-date')==joueurs[0]["date_rencontre"] && convs[c].attr('data-equipe')==joueurs[0]["id_equipe"])
                                    {
                                        console.log("YES")
                                        //console.log(c)
                                        //console.log(convs[c])
                                    }
                                    else{
                                        console.log("NO")
                                    }
                                }*/
                                //console.log($('div').data('date')=joueurs[0]["date_rencontre"])

                           /*     $('#convo' + convoc).append('<div class=joueurs-convo id="joueurs-convo' + convoc + '"></div>')
                                $('#joueurs-convo' + convoc).append('<h3 >Joueurs du match :</h3>')
                                for (j in joueurs) {
                                    $('#joueurs-convo' + convoc).append('<span>' + joueurs[j]["nom"] + ' ' + joueurs[j]["prenom"] + ' </span>')

                                }
                            },
                            error: function (XMLHttpRequest, textStatus, errorThrown) {
                                alert("Status: " + textStatus);
                                alert("Error: " + errorThrown);

                            }
                        });

                 /*   $.when(getJoueursConvo()).done() // ATTENDRE QUE LES JOUEURS ARRIVENT TOUS AVANT DE LES ASSIGNER AUX CONVOS  // ne fonctionne pas
                        continue*/

       /*         }
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                alert("Status: " + textStatus);
                alert("Error: " + errorThrown);

            }
        });



    })

*/





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