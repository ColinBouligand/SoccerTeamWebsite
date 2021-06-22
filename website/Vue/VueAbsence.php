<?php


require_once("../Controleur/Routeur.php");
require_once("../Modele/GestionConnexion.php");

//à déplacer dans index.php !
$routeur = new Routeur();
$routeur->routerRequete();

/*if(isset($_GET['dD']) && isset($_GET['dF'])){
    $date_debut = $_GET['dD'];
    $date_fin = $_GET['dF'];
} else {
    $date_debut = date('d-m-Y');
    $date_fin = date('d-m-Y', strtotime('+1 year'));
}*/

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="fr">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <title>Planning des absences</title>
    <style>
        body{
            text-align:center;
                    }

        table {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 80%;
            table-layout: fixed;
            position:relative;
            left:10%;


        }

        #div-tab{
            overflow: auto;
            padding: 10px 16px;
        }
        td, th {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center  ;
        }

        tr:nth-child(even){background-color: #f2f2f2;}

        tr:hover {background-color: #ddd;}


        .date_row:hover{
            background-color: #4CAF50; <!-- Annule le hover d'au dessus -->

        }

        .date_row {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #4CAF50;
            color: white;
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
            left:30%;
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

        /* POUR QUE LE HEADER DU TABLEAU SUIVE LE SCROLL*/
        /* Style the header */


        /* Page content */
        .content {
            padding: 16px;
        }

        /* The sticky class is added to the header with JS when it reaches its scroll position */
        .sticky {
            position: fixed;
            top: 0;
            width: 100%
        }

        /* Add some top padding to the page content to prevent sudden quick movement (as the header gets a new position at the top of the page (position:fixed and top:0) */
        .sticky + .content {
            padding-top: 102px;
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

<h1> Planning des absences </h1>

<h2>Code : A(bsent), B(lessé), E(xempt), N(on-licencié), S(uspendu) </h2>

<div id="dates_select">
   Du : <input type="date" id="date_debut" name="dD">
    au : <input type="date" id="date_fin" name="dF">  <button id="dates_absences"> Afficher</button>
</div>

<div id="div-tab">
    <table id="tab_absence" style="border:solid black 1px" ><thead><tr class="date_row" style="border:solid black 1px">   <td></td></tr></thead>
        <tbody></tbody>
</div>


</table>

<script> //AJAX


    // recup tous les joueurs
    // getJoueurs()

    //recup les absences de ces joueurs là pour les dates sélectionnées
    //par défaut mettre la date du jour(dimanche) + 2 mois
    d= new Date() // date du jour
    jour=d.getDay()
    if(jour!=0)
    {
        d.setDate(d.getDate() + (7-jour));
    }
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

    $('#date_debut').val(date)

    d.setDate(d.getDate() + 8 * 7); // + 8 semaines entre date de début et de fin

    day = d.getDate();
    month = d.getMonth() + 1;
    year = d.getFullYear();

    if (month < 10) {
        month = "0" + month;
    }
    if (day < 10) {
        day = "0" + day;
    }
    date2 = year + "-" + month + "-" + day;

    $('#date_fin').val(date2)


    afficherAbsences()

    $(document).ready(function () {


    })
    //CHANGER L'ETAT D'UNE ABSENCE
    $(document).on('change', 'select', function () {
        var value = $(this).val();

        index=$(this).parent().index() // index de la case
       // console.log(.children()[$(this).parent().index()])
        thead = $('table').children()[0]

        tr =thead.firstChild // header
        console.log(tr.children[index].textContent.substring(1))
        datefr = tr.children[index].textContent.substring(1)
        dateeng= datefr.substr(6,10)+"-"+datefr.substr(3,2)+"-"+datefr.substr(0,2)
         $.ajax({
             url: '?',
             async: true,
             "type": 'POST',
             data: {
                 'action': 'ajouterabsence',
                 'idjoueur': $(this).closest('tr').attr('id'),
                 'date': dateeng,
                 'motif': value.toUpperCase()

             },
             dataType: 'json',
             success: function (text) {

                 console.log(text)
             }
         });
    });

    function afficherAbsences (){

        $('.date_row').empty()
        $('.date_row').append('<td></td>')
        $('tbody').empty()



        //afficher les dates
        $.ajax({
            url: '?',
            async: true,
            "type": 'POST',
            data: {
                'action': 'getsunday',
                'date_d': $('#date_debut').val(),
                'date_f': $('#date_fin').val()
            },
            dataType: 'json',
            success: function (data) {
                //console.log(data)
                for (d in data) {
                    $('.date_row').append("<td> " + data[d] + "</td>")

                }

            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                alert("Status: " + textStatus);
                alert("Error: " + errorThrown);

            }
        });
        //afficher les absences

        $.ajax({
            url: '?',
            async: true,
            "type": 'POST',
            data: {
                'action': 'absencestab',
                'date_d': $('#date_debut').val(),
                'date_f': $('#date_fin').val()
            },
            dataType: 'text',
            success: function (data) {
                //console.log(data)
                $('tbody').append(data)


            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                alert("Status: " + textStatus);
                alert("Error: " + errorThrown);

            }
        });
    }





    //TRIER EN FONCTION DES DATES
    $(document).on('click', '#dates_absences', function () {

        console.log("tests")
        if($('#date_debut').val() && $('#date_fin').val()) // SI 2 dates ont été sélectionnées
        {
           if($('#date_debut').val() < $('#date_fin').val())
           {
             afficherAbsences()
           }

        }

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

    //POUR LE  SCROLL DANS LE TABLEAU

    // // When the user scrolls the page, execute myFunction
    // window.onscroll = function() {myFunction()};
    //
    // // Get the header
    // var header = $("#div-tab");
    //
    // // Get the offset position of the navbar
    // var sticky = header.offsetTop;
    //
    // // Add the sticky class to the header when you reach its scroll position. Remove "sticky" when you leave the scroll position
    // function myFunction() {
    //     if (window.pageYOffset > sticky) {
    //         header.classList.add("sticky");
    //     } else {
    //         header.classList.remove("sticky");
    //     }
    // }


</script>
</body>
</html>

