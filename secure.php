<?php
/** @var mysqli $db */

session_start();

//Kijken of de gebruiker is ingelogd, anders terugsturen naar de login pagina
if (!isset($_SESSION['loggedInUser'])) {
    header("Location: login.php");
    exit;
}

// Connectie maken met database
require_once "connect.php";

// Alle reserveringen uit de database ophalen
$query = "SELECT * FROM booking";
$result = mysqli_query($db, $query) or die ('Error: ' . $query );

// Een array maken van alle resultaten uit de database
$booking = [];
while ($row = mysqli_fetch_assoc($result)) {
    $booking[] = $row;
}

//Close connection
mysqli_close($db);
?>
<!doctype html>
<html lang="en">

<head>
    <title>Reserveringen</title>
    <meta charset="utf-8"/>
    <link rel="stylesheet" type="text/css" href="style.css"/>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>

<div class="w3-top">
    <div class="w3-bar w3-green w3-card w3-left-align w3-large">
        <a class="w3-bar-item w3-button w3-hide-medium w3-hide-large w3-right w3-padding-large w3-hover-white w3-large w3-red" href="javascript:void(0);" onclick="myFunction()" title="Toggle Navigation Menu"><i class="fa fa-bars"></i></a>
        <a href="index.php" class="w3-bar-item w3-button w3-padding-large w3-green">Home</a>
        <a href="create.php" class="w3-bar-item w3-button w3-hide-small w3-padding-large w3-hover-white">Reservering maken</a>
        <a href="placeholder.php" class="w3-bar-item w3-button w3-hide-small w3-padding-large w3-hover-white">Over ons</a>
        <a href="placeholder.php" class="w3-bar-item w3-button w3-hide-small w3-padding-large w3-hover-white">Contact</a>
        <a href="secure.php" class="w3-bar-item w3-button w3-hide-small w3-padding-large w3-hover-white">Admin</a>
    </div>

<h1>Reservering</h1>
<p> <a href="logout.php">Logout</a> </p>
<p> <a href="register.php">Admin-acccount aanmaken </a> </p>

<table>
    <thead>
    <tr>
        <th>id</th>
        <th>Naam</th>
        <th>Achternaam</th>
        <th>Datum</th>
        <th>Tijd</th>

        <th colspan="3"></th>
    </tr>
    </thead>
    <tfoot>

    </tfoot>
    <tbody>
    //Tabel maken van alle database tabellen
    <?php foreach ($booking as $booking) { ?>
        <tr>
            <td><?= $booking['id'] ?></td>
            <td><?= $booking['name'] ?></td>
            <td><?= $booking['lastname'] ?></td>
            <td><?= $booking['date'] ?></td>
            <td><?= $booking['time'] ?></td>


            <td><a href="edit.php?id=<?= $booking['id'] ?>">Edit</a></td>
            <td><a href="delete.php?id=<?= $booking['id'] ?>">Delete</a></td>
        </tr>
    <?php } ?>
    </tbody>
</table>
</body>
</html>
