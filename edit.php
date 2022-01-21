<?php

session_start();

//Checken of de gebruiker is ingelogd, anders teruggsturen naar login pagina
if (!isset($_SESSION['loggedInUser'])) {
    header("Location: login.php");
    exit;
}

/** @var mysqli $db */
//Connectie maken met database
require_once "connect.php";

//Variabele booking id ophalen met de GET functie
$bookingId = mysqli_escape_string($db, $_GET['id']);

//Alles ophalen uit de database waar id overeenkomt
$query = "SELECT * FROM booking WHERE id = '$bookingId'";
$result = mysqli_query($db, $query)
or die ('Error: ' . $query );

// redirect bij geen resultaat
if(mysqli_num_rows($result) != 1)
{
    header('Location: secure.php');
    exit;
}
// Resultaten in een variabele zetten
$booking = mysqli_fetch_assoc($result);

$bookingId = mysqli_escape_string($db, $_GET['id']);

//Datum updaten
if (isset($_POST['updatedate'])) {
    $query = "UPDATE booking SET date='$_POST[date]' WHERE id= $bookingId";
    $query_run = mysqli_query($db, $query);
//Validatie
    if ($query_run){
        $datesucces = 'Het is gelukt, je aanpassingen zijn opgeslagen';
    }else{
        echo "Oeps er is iets mis gegaan";
    }
}
//Tijd updaten
if (isset($_POST['updatetime'])) {
    $query = "UPDATE booking SET time='$_POST[time]' WHERE id= $bookingId";
    $query_run = mysqli_query($db, $query);
//Validatie
    if ($query_run){
        $succes = 'Het is gelukt, je aanpassingen zijn opgeslagen';
    }else{
        echo "Oeps er is iets mis gegaan";
    }
}

?>
<!doctype html>
<html lang="en">
<head>
    <title>Afsprakenoverzicht bewerken</title>
    <meta charset="utf-8"/>
    <link rel="stylesheet" type="text/css" href="style.css"/>
</head>
<body>
<h1>Edit</h1>

<form class="box" action="" method="post"> Datum wijzigen van: <?= $booking['date'] ?> naar:<br><br>
    <input type="date" name="date" placeholder="Datum wijzigen naar:"/>
    <input type="submit" name="updatedate" value="Datum wijzigen"/>
    <span><?= $datesucces ?? '' ?></span><br>
    <br> tijd wijzigen van: <?= $booking['time'] ?> naar: <input type="text" name="time" placeholder="Tijd wijzigen naar:"/>
    <input type="submit" name="updatetime" value="Tijd wijzigen"/>
    <span><?= $succes ?? '' ?></span><br>
    <br> </form>
<div>
    <a href="secure.php">Ga terug naar het overzicht</a>
</div>
</body>
</html>