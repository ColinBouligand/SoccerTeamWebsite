<?php

require_once("../Controleur/Routeur.php");
$routeur = new Routeur();
$routeur->routerRequete();


?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <title>Connexion</title>

    <style>
        .container-connex {
            position: relative;
            width: 50%;
            height: 50%;
            left: 25%;
            top: 20%;

            display: flex;


        }

        .warning-connex {

            color: crimson;
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

        .btn-conn{
            left:65%;
        }

        .btn-conv{
            left:50%
        }

        .btn-reg{
            left: 40%;
        }
        .btn-cal{
            left:40%;
        }
        .btn-abs{
            left:40%;
        }



    </style>
</head>
<body>
<header>
 <button class="btn" onclick="window.location.href='VueAccueil.php';">Accueil</button>

</header>



<div class="container-connex">
    <input class="login-connex" type="text" placeholder="Votre pseudo">

    <input class="mdp-connex" type="password" placeholder="Votre mot de passe">

    <p class="warning-connex"></p>

    <button class="btn-connex">Se connecter</button>

</div>

<script>


    //VERIF CONNEXION
    $(document).on('click', '.btn-connex', function () {

        if (!$('.login-connex').val()) // si pas de login rentré par l'utilisateur
        {
            $('.warning-connex').text('Veuillez remplir le champ Pseudo')
            return
        }

        if (!$('.mdp-connex').val()) // si pas de mdp rentré par l'utilisateur
        {
            $('.warning-connex').text('Veuillez remplir le champ Mot de passe')
            return
        }

        $.ajax({
            url: '?',
            async: true,
            "type": 'POST',
            data: {
                'action': 'getmdp',
                'login': $(".login-connex").val()

            },
            dataType: 'json',
            success: function (data) {
                if (data[0]["mdp"] = $('.mdp-connex').val()) // si mot de passe bon
                {

                    // IL FAUT charger le role dans la session en php
                    $.ajax({
                        url: '?',
                        async: true,
                        "type": 'POST',
                        data: {
                            'action': 'sessionrole',
                            'role': $('.login-connex').val()
                        },
                        success: function () {
                           // console.log("yes")
                            window.location.href = "VueAccueil.php";

                        }
                    });

                }
                else {
                    $('.warning-connex').text('Mauvais mot de passe')
                }
            }
        });
    });


</script>
</body>
</html>