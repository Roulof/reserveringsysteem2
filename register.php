<?php
session_start();

// Controleren of de gebruiker is ingelogd, anders terugsturen naar login
if (!isset($_SESSION['loggedInUser'])) {
    header("Location: login.php");
    exit;
}
// Kijken of er op submit is gedrukt
if(isset($_POST['submit'])) {
    require_once "connect.php";

    /** @var mysqli $db */

    // Ingevoerde waardes in een variabele zetten
    $mail = mysqli_escape_string($db, $_POST['email']);
    $password = $_POST['password'];
// Errors bij lege invoervelden
    $errors = [];
    if($mail == '') {
        $errors['email'] = 'Voer een gebruikersnaam in';
    }
    if($password == '') {
        $errors['password'] = 'Voer een wachtwoord in';
    }
// Password beveiliging dmv een hash
    if(empty($errors)) {
        $password = password_hash($password, PASSWORD_DEFAULT);

        // Variabelen in de database zetten
        $query = "INSERT INTO users (mail, password) VALUES ('$mail', '$password')";
// Resultaat van query
        $result = mysqli_query($db, $query)
        or die('Db Error: '.mysqli_error($db).' with query: '.$query);
// Gebruiker terugsturen naar de adminpagina
        if ($result) {
            header('Location: secure.php');
            exit;
        }
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css"/>
    <title>Registreren</title>
</head>
<body>
<h2>Nieuwe gebruiker registeren</h2>
<form action="" method="post">
    <div class="data-field">
        <label for="email">Email</label>
        <input id="email" type="text" name="email" value="<?= $email ?? '' ?>"/>
        <span class="errors"><?= $errors['email'] ?? '' ?></span>
    </div>
    <div class="data-field">
        <label for="password">Wachtwoord</label>
        <input id="password" type="password" name="password" value="<?= $password ?? '' ?>"/>
        <span class="errors"><?= $errors['password'] ?? '' ?></span>
    </div>

    <div class="data-submit">
        <input type="submit" name="submit" value="Registreren"/>
    </div>
    <div>
        <a href="index.php">Terug</a>
    </div>
</form>

</body>
</html>