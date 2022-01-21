<?php
/** @var mysqli $db */

//Checken of er op de submit knop is gebruikt
if (isset($_POST['submit'])) {
    // Connectie maken met database
    require_once "connect.php";

    //Postback with the data showed to the user, first retrieve data from 'Super global'
    $name   = mysqli_escape_string($db, $_POST['name']);
    $lastname = mysqli_escape_string($db, $_POST['lastname']);
    $mail  = mysqli_escape_string($db, $_POST['mail']);
    $date   = mysqli_escape_string($db, $_POST['date']);
    $time = mysqli_escape_string($db, $_POST['time']);

    //Errors voor niet ingevulde velden
    require_once "validatie.php";



        // De geposte informatie opslaan in de database
        $query = "INSERT INTO booking (name, lastname, mail, date, time)
                  VALUES ('$name', '$lastname', '$mail', '$date', '$time')";
        $result = mysqli_query($db, $query) or die('Error: '.mysqli_error($db). ' with query ' . $query);

        // Wanneer de query gelukt is de gebruiker terugsturen naar de index pagina
        if ($result) {
            header('Location: index.php');
            exit;
            // wanneer niet gelukt een error tonen
        } else {
            $errors['db'] = 'Something went wrong in your database query: ' . mysqli_error($db);
        }

        // Connectie met database verbreken
        mysqli_close($db);

}
?>
<!doctype html>
<html lang="en">

<head>
    <title>Reserveer</title>
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

<h1>Maak een afspraak</h1>
<?php if (isset($errors['db'])) { ?>
    <div><span class="errors"><?= $errors['db']; ?></span></div>
<?php } ?>

<!-- Datainputs met beveiliging van htmlentities -->
<form action="create.php" method="post" enctype="multipart/form-data">
    <div class="data-field">
        <label for="name">Naam</label>
        <input id="name" type="text" name="name" value="<?= isset($name) ? htmlentities($name) : '' ?>"/>
        <span class="errors"><?= $errors['name'] ?? '' ?></span>
    </div>
    <div class="data-field">
        <label for="lastname">Achternaam</label>
        <input id="lastname" type="text" name="lastname" value="<?= isset($lastname) ? htmlentities($lastname) : '' ?>"/>
        <span class="errors"><?= isset($errors['lastname']) ? $errors['lastname'] : '' ?></span>
    </div>
    <div class="data-field">
        <label for="mail">Mail</label>
        <input id="mail" type="text" name="mail" value="<?= isset($mail) ? htmlentities($mail) : '' ?>"/>
        <span class="errors"><?= isset($errors['mail']) ? $errors['mail'] : '' ?></span>
    </div>
    <div class="data-field">
        <label for="date">Datum</label>
        <input id="date" type="date" name="date" value="<?= isset($date) ? htmlentities($date) : '' ?>"/>
        <span class="errors"><?= isset($errors['date']) ? $errors['date'] : '' ?></span>
    </div>
    <div class="data-field">
        <label for="time">Tijd</label>
        <input id="time" type="time" name="time" value="<?= isset($time) ? htmlentities($time) : '' ?>"/>
        <span class="errors"><?= isset($errors['time']) ? $errors['time'] : '' ?></span>

    <div class="data-submit">
        <input type="submit" name="submit" value="Save"/>
    </div>
</form>
<div>


    <a href="index.php">Terug</a>
</div>
</body>
</html>
