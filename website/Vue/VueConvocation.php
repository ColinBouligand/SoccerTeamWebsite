<?php
require_once("../Controleur/Routeur.php");
require_once("../Modele/GestionConnexion.php");


//à déplacer dans index.php !
$routeur = new Routeur();
$routeur->routerRequete();

?>

<html>
<head>

    <meta charset="UTF-8"/>
    <link rel="stylesheet" type="text/css" href="src/styles.scss"/>
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <!-- <meta name="viwport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no"> -->
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=5">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <!-- Title -->
    <title>Formulaire Convocation</title>
    <style>


        body {
            background-image: url("https://images.pexels.com/photos/440731/pexels-photo-440731.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=750&w=1260");

            background-size: cover;
        }


        .grid-container {
            position: relative;
            display: grid;
            grid-template-columns: auto auto;

            width: 100%;
            height: 100%;
        }

        .left {
            width: 100%;
            height: 100%;
        }


        .right {

            width: 100%;
            height: 100%;
        }

        .convocation {
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;

        }

        .left_item {
            margin: 1%;
            border-radius: 10px;
            width: 80%;

        }

        .date_convo {
            background-color: white;
            padding: 2%;
            text-align: center;
        }

        .equipe_convo {
            background-color: white;
            text-align: center;
            padding: 2%;
        }

        .info_convo {
            background-color: white;
            height: 10%;
            position: relative;
            z-index: 50;
            padding: 2%;
            display: flex;
            flex-direction: column;
            text-align: center;
            overflow: auto;

        }

        .joueurs_convo {
            background-color: white;
            position: relative;
            height: 50%;
            z-index: 50;
            display: flex;
            flex-direction: column;
            flex-wrap: wrap;
            align-content: space-around;

        }

        /*.joueur{
            width:20%;
            height:7%;
            margin:2%;
            background-color:black;
            color:white;
            text-align: center;
            padding:1%
        }*/

        .right {
            display: flex;
        }

        .liste_joueurs {
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;

        }

        .right_item {
            width: 80%;
            margin: 1%;
            border-radius: 10px;
        }


        .joueurs_dispos {
            height: 40%;
            max-height: 40%;
            background-color: white;
            display: flex;
            flex-direction: column;
            flex-wrap: wrap;
            align-content: space-around;
            text-align: center;
            overflow:auto;

        }


        .joueur_dispo {

            width: 20%;
            height: 7%;
            margin: 1%;
            background-color: black;
            color: white;
            text-align: center;
            padding: 1%;


        }


        .joueurs_non_dispos {
            height: 20%;

            background-color: white;
            flex-direction: column;
            flex-wrap: wrap-reverse;
            justify-content: space-between;
            text-align: center;
            overflow:auto;
        }

        .no_disp {
            display: flex;
            flex-direction: row;
            background-color: #ff0000;
            margin: 1%;

        }

        .liste_boutons {
            height: 15%;
            width: 80%;
            display: flex;
            flex-direction: row;
            justify-content: space-around;


        }

        .liste_boutons button {

            width: 25%;
            background-color: white;
            max-height: 20%;
            min-height:30px;
        }

        .liste_boutons :nth-child(3) { /*dernier bouton*/
            background-color: Red;
        }

        .joueur_non_dispo {
            width: 20%;
            height: 7%;
            margin: 1%;
            background-color: black;
            color: white;
            text-align: center;
            padding: 1%;
            margin: 1%;

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


<div class="grid-container">
    <div class="left grid-item">

        <div class="convocation">
            <div class="date_convo left_item"><button class="btn dayMinusOneBtn">Dimanche précédent</button><input id="convo-date" type="date"><button class="btn dayPlusOneBtn">Dimanche suivant</button></div>
            <div class=" left_item equipe_convo"><select id="convo-equipe"></select></div>


            <div class="info_convo left_item">
                <b id="convo-compet"></b>
                <span id="convo-equipe-adv"></span>
                <span id="convo-heure"></span>
                <span id="convo-terrain"></span>
                <span id="convo-site"> </span>
            </div>

            <div class="joueurs_convo left_item" ondrop="drop(event)" ondragover="allowDrop(event)">


            </div>

        </div>


    </div>

    <div class="right grid-item">

        <div class="liste_joueurs">
            <div class="joueurs_dispos right_item" ondrop="drop(event)" ondragover="allowDrop(event)">


            </div>

            <div class="joueurs_non_dispos right_item">

                JOUEURS ABSENTS
                <div class="joueurs_absents no_disp">


                </div>
                JOUEURS BLESSES
                <div class="joueurs_blesses no_disp">

                </div>
                JOUEURS SUSPENDUS
                <div class="joueurs_suspendus no_disp">


                </div>
                JOUEURS NON LICENCIES
                <div class="joueurs_non_licencies no_disp">



                </div>
            </div>

            <div class="liste_boutons right_item">
                <button id="convo-reini">Réinitialiser</button>
                <button id="convo-save">Sauvegarder</button>
                <button id="convo-publi">Publier</button>
            </div>

        </div>
    </div>
</div>

<script>

    $(document).ready(function () {


        //créer une association convocation dès qu'une rencontre est créée ? -> surement NON

        //charger le prochain match/dimanche par défaut (équipe 1)
        d = new Date()
        let day = d.getDate();
        let month = d.getMonth() + 1;
        let year = d.getFullYear();

        if (month < 10) {
            month = "0" + month;
        }
        if (day < 10) {
            day = "0" + day;
        }
        let date = year + "-" + month + "-" + day;
        $("#convo-date").val(date);
        //déclencher clic sur dimanche suivant ??
        //$(".dayPlusOneBtn").trigger("click");

        $("#convo-date").trigger("change");

        

        //loadConvoc()


        //charger les équipes -> equipe 1 par défaut
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
                    $('#convo-equipe').append(new Option(data[i]['libelle'], data[i]['id_equipe']))

                }

            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                alert("Status: " + textStatus);
                alert("Error: " + errorThrown);

            }
        });

        //recharger les infos à chaque modif d'équipe/ de date OK


        //afficher les joueurs que si il y a match de prévu OK-> pas utilisable même si affiché
        //loadJoueurs()


        //bloquer la modif des convos publiées


    })


    //changer la convo en fonction de la date + check si dimanche
    $(document).on('change', '#convo-date', function () {
        date = $(this).val();
        //console.log(date)

        jour= new Date(date)

        var day = jour.getDay();
        var isSunday = (day === 0);// 0 = Sunday

        if (isSunday)
        {
            loadConvoc()
            loadJoueurs()
        }



    });
    // ---- Change le contenu de la convoc en fonction de l'équipe sélectionnée
    $(document).on('change', '#convo-equipe', function () {
            loadJoueurs()

            loadConvoc()



    });

    // clic sur dimanche précédent
    $(document).on('click', '.dayMinusOneBtn', function () {

        var d = new Date($("#convo-date").val()); // date actuelle
        var jour = d.getDay();

        if(jour==0) jour=7 // si le jour est déjà dimanche -> décaler à celui d'avant
        d.setDate(d.getDate() - jour);
        let day = d.getDate();
        let month = d.getMonth() + 1;
        let year = d.getFullYear();

        if (month < 10) {
            month = "0" + month;
        }
        if (day < 10) {
            day = "0" + day;
        }
        let date = year + "-" + month + "-" + day;
        $("#convo-date").val(date);
        $("#convo-date").trigger("change");


    });

    // clic sur dimanche suivant
    $(document).on('click', '.dayPlusOneBtn', function () {
        var d = new Date($("#convo-date").val()); // date actuelle
        var jour = d.getDay();


        d.setDate(d.getDate() + (7-jour));
        let day = d.getDate();
        let month = d.getMonth() + 1;
        let year = d.getFullYear();

        if (month < 10) {
            month = "0" + month;
        }
        if (day < 10) {
            day = "0" + day;
        }
        let date = year + "-" + month + "-" + day;
        $("#convo-date").val(date);
        $("#convo-date").trigger("change");

    });




    function loadConvoc() {

        //clean la div
        $('#convo-compet').empty()
        $('#convo-equipe-adv').empty()
        $('#convo-heure').empty()
        $('#convo-terrain').empty()
        $('#convo-site').empty()

        if(!$("#convo-equipe option:selected").val())
        {
            equipe= 1
        }
        else {
            equipe = $("#convo-equipe option:selected").val()
        }

        $.ajax({
            url: '?',
            async: true,
            "type": 'POST',
            data: {
                'action': 'getconvoinfos',
                'date': $("#convo-date").val(),
                'equipe': equipe
            },
            dataType: 'json',
            success: function (data) {


                if(data !== false) {
                    /** 1 E METHODE  AFFICHER CONVO PUBLIEE **/

                    // console.log($('#convo-publi').length)
                  //  if(!$('#convo-publi').length) // si il existe le supprimer
                   // {
                     //   console.log("no")                                     // COMPLIQUE -> la méthode length renvoie toujours 1
                      //  $('#convo-publi').remove()
                    //}

                    $('#convo-compet').text("" + data['nom_competition'])
                    $('#convo-equipe-adv').text("VS : " + data['libelle2'])
                    $('#convo-heure').text("Heure : " + data['heure_rencontre'].substr(0, 5))
                    $('#convo-terrain').text("Terrain : " + data['terrain'])
                    $('#convo-site').text("Site : " + data['site'])
                }
                else{
                    $('#convo-compet').text("Aucun match pour ce jour et cette équipe")
                }


                if(data['date_convocation'])
                {
                    /** 3 E METHODE  DESAC LES BOUTONS ET LES REACTIVER SINON**/
                    //BLOQUER LES BOUTONS / LES RENDRE INVISIBLE

                   // alert("CONVOCATION PUBLIEE") // horrible mais prévient l'utilisateur
                    $('.liste_boutons').css('visibility', 'hidden')



                    /** 2 E METHODE : JOUEURS -> DRAGGABLE = FALSE **/

                    // await loadJoueurs()

                    /*console.log($('.joueur_dispo'))

                    //BLOQUER LA CONVOC SI DEJA VALIDEE
                    //$.each($('.joueur_dispo')).attr('draggable', false)

                    $('.joueur_dispo').each(function(){ // LES JOUEURS NE SONT PAS TOUJOURS DISPOS -> mauvaise méthode
                        $(this).attr('draggable', false);
                    });

                    console.log($('.joueur_dispo'))*/
                    //Rendre impossible à déplacer les joueurs ne fonctionne pas -> rendre inaccessible les boutons ?
                    // + LE DIRE A L'UTILISATEUR

                    //  console.log($('#convo-publi').length)

                    // $('.info_convo').prepend('<h3 style="color:red" id="convo-publi">CONVOCATION PUBLIEE</h3>') // prepend -> insere en 1er fils

                }
                else{
                    $('.liste_boutons').css('visibility', 'visible')
                }


            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                alert("Status: " + textStatus);
                alert("Error: " + errorThrown);

            }
        });
    }

    function loadJoueurs() {

        //clean les div
        $('.joueurs_dispos').empty()
        $('.joueurs_convo').empty()
        $('.no_disp').empty()

        if(!$("#convo-equipe option:selected").val())
        {
            equipe= 1
        }
        else {
            equipe = $("#convo-equipe option:selected").val()
        }


        //AFFICHE LES JOUEURS DISPOS (déplacables) // ATTENTION AUX JOUEURS DEJA PRIS DANS UN AUTRE MATCH !!!!!!! // attention aux joueurs enregistrés dans une convo
        $.ajax({
            url: '?',
            async: true,
            "type": 'POST',
            data: {
                'action': 'getjoueursdispos',
                'date': $('#convo-date').val(),
                'equipe': equipe
            },
            dataType: 'json',
            success: function (data) {

                for (i in data) {

                    $('.joueurs_dispos').append("<div draggable=true class=joueur_dispo id=" + data[i]['id_joueur'] + " ondragstart=drag(event)>" + data[i]['nom'] + " " + data[i]['prenom'] + " </div>")
                }


            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                alert("Status: " + textStatus);
                alert("Error: " + errorThrown);

            }
        });
        $.ajax({
            url: '?',
            async: true,
            "type": 'POST',
            data: {
                'action': 'getjoueursenregistres',
                'date': $('#convo-date').val(),
                'equipe': equipe
            },
            dataType: 'json',
            success: function (data) {
                for (i in data) {

                    $('.joueurs_convo').append("<div draggable=true class=joueur_dispo id=" + data[i]['id_joueur'] + " ondragstart=drag(event)>" + data[i]['nom'] + " " + data[i]['prenom'] + " </div>")
                }

            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                alert("Status: " + textStatus);
                alert("Error: " + errorThrown);

            }
        });


        //AFFICHE LES JOUEURS NON DISPOS (non déplacables)
        $.ajax({
            url: '?',
            async: true,
            "type": 'POST',
            data: {
                'action': 'getjoueursabsents',
                'date': $('#convo-date').val()
            },
            dataType: 'json',
            success: function (data) {

                for (i in data) {

                    if(data[i]['motif']=='A')
                    {
                        $('.joueurs_absents').append("<div class=joueur_non_dispo data-id=" + data[i]['id_joueur'] + " >" + data[i]['nom'] + " " + data[i]['prenom'] + " </div>")
                    }
                    else if (data[i]['motif']=='B'){
                        $('.joueurs_blesses').append("<div class=joueur_non_dispo data-id=" + data[i]['id_joueur'] + " >" + data[i]['nom'] + " " + data[i]['prenom'] + " </div>")

                }
                    else if (data[i]['motif']=='S'){
                        $('.joueurs_suspendus').append("<div class=joueur_non_dispo data-id=" + data[i]['id_joueur'] + " >" + data[i]['nom'] + " " + data[i]['prenom'] + " </div>")

                }
                    else if (data[i]['motif']=='N'){
                        $('.joueurs_non_licencies').append("<div class=joueur_non_dispo data-id=" + data[i]['id_joueur'] + " >" + data[i]['nom'] + " " + data[i]['prenom'] + " </div>")

                }

                }
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                alert("Status: " + textStatus);
                alert("Error: " + errorThrown);

            }
        });
    }


    //SAUVEGARDER CONVO

    // clic sur sauvegarder
    $(document).on('click', '#convo-save', function () {

        sauverConvo()


    });

    async function sauverConvo()
    {
        //si dimanche + s'il y a match
        date = $('#convo-date').val();
        jour= new Date(date)

        var day = jour.getDay();
        var isSunday = (day === 0);// 0 = Sunday

        console.log("save")
        console.log(isSunday)
        console.log($('#convo-site').text())

        if (isSunday && $('#convo-site').text()) {
            console.log("dimanche et match")


            //récup tous les joueurs de la div
            //console.log($('.joueurs_convo').children())
            children = $('.joueurs_convo').children()
            //console.log(children)

            if (children.length <= 14 && children.length >= 11) {//si < 11 ou > 14 stopper là
                joueurs = []
                //console.log("parfait")
                children.each(function (c) { // récup tous les joueurs de la convo
                    // console.log(children[c])
                    joueurs.push(children[c].id)
                })

                //console.log(joueurs)


                $.ajax({
                    url: '?',
                    async: true,
                    "type": 'POST',
                    data: {
                        'action': 'saveconvo',
                        'date': $('#convo-date').val(),
                        'equipe': $('#convo-equipe').val(),
                        'joueurs': joueurs
                    },
                    dataType: 'text',
                    success: function (data) {
                        alert('Convocation sauvegardée !')


                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {


                    }
                });
            }
            else{ // si mauvais nombre de joueurs
                alert("Veuillez saisir un nombre de joueurs entre 11 et 14 ")
            }
        }

    }



    //REINITIALISER CONVO

    // clic sur réinitialiser
    $(document).on('click', '#convo-reini', function () {

        //si dimanche + s'il y a match
        date = $('#convo-date').val();
        jour= new Date(date)

        var day = jour.getDay();
        var isSunday = (day === 0);// 0 = Sunday


        if (isSunday && $('#convo-site').text()) {
            console.log("dimanche et match")


            //récup tous les joueurs de la div
            //console.log($('.joueurs_convo').children())
            children = $('.joueurs_convo').children()
            //console.log(children)
            joueurs = []
                //console.log("parfait")
                children.each(function (c) { // récup tous les joueurs de la convo
                    // console.log(children[c])
                    joueurs.push(children[c].id)
                })

                //console.log(joueurs)


                $.ajax({
                    url: '?',
                    async: true,
                    "type": 'POST',
                    data: {
                        'action': 'reiniconvo',
                        'date': $('#convo-date').val(),
                        'equipe': $('#convo-equipe').val()
                    },
                    dataType: 'text',
                    success: function (data) {
                        alert(data)
                        loadJoueurs()


                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {


                    }
                });
            }
    });

    //PUBLIER CONVO
    async function publierConvo() {


        //$('#convo-save').trigger("click") // sauvegarde la convo avant de la publier

        // supprime la sauvegarde ????
        await sauverConvo()

        d = new Date()
        let day = d.getDate();
        let month = d.getMonth() + 1;
        let year = d.getFullYear();

        if (month < 10) {
            month = "0" + month;
        }
        if (day < 10) {
            day = "0" + day;
        }
        let date = year + "-" + month + "-" + day;


        $.ajax({
            url: '?',
            async: true,
            "type": 'POST',
            data: {
                'action': 'publierconvo',
                'dateMatch': $('#convo-date').val(),
                'equipe': $('#convo-equipe').val(),
                'dateConvo': date
            },
            dataType: 'text',
            success: function (data) {
                alert('Convocation publiée')
                console.log(data)
                //rendre indéplacable les joueurs

            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {


            }
        });
    }

    // clic sur publier
    $(document).on('click', '#convo-publi', function () {

        publierConvo()

    });


    // problème, on peut drop un joueur dans un autre

    function allowDrop(ev) {
        ev.preventDefault();
    }

    function drag(ev) {
        ev.dataTransfer.setData("text", ev.target.id);
    }

    function drop(ev) {
        ev.preventDefault();
        var data = ev.dataTransfer.getData("text");
        ev.target.appendChild(document.getElementById(data));
    }

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
