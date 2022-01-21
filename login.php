<?php
session_start();

//Kijken of de gebruiker al ingelogd is
if(isset($_SESSION['loggedInUser'])) {
    $login = true;
} else {
    $login = false;
}

/** @var mysqli $db */
//Connectie maken met database
require_once "connect.php";

//Mail en wachtwoord ophalen uit submit
if (isset($_POST['submit'])) {
    $mail = mysqli_escape_string($db, $_POST['mail']);

    $password = $_POST['password'];

    // Errors tonen bij lege velden
    $errors = [];
    if($mail == '') {
        $errors['mail'] = 'Voer een gebruikersnaam in';
    }
    if($password == '') {
        $errors['password'] = 'Voer een wachtwoord in';
    }

    if(empty($errors))
    {
        // Alles ophalen waar variabele mail overeenkomt met ingevoerde mail
        $query = "SELECT * FROM users WHERE mail='$mail'";
        $result = mysqli_query($db, $query);
        // Kijken of ingevoerde gegevens overeenkomen met een bestaand account
        if (mysqli_num_rows($result) == 1) {
            $user = mysqli_fetch_assoc($result);
            // Gehashde password controleren
            if (password_verify($password, $user['password'])) {
                // Variabele voor gelukte login
                $login = true;
//Session aanmaken
                $_SESSION['loggedInUser'] = [
                    'mail' => $user['mail'],
                    'id' => $user['id']
                ];
            } else {
                //error onjuiste inloggegevens
                $errors['loginFailed'] = 'De combinatie van email en wachtwoord is bij ons niet bekend';
            }
        } else {
            //error onjuiste inloggegevens
            $errors['loginFailed'] = 'De combinatie van email en wachtwoord is bij ons niet bekend';
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
    <title>Login</title>
</head>
<body>
<h2>Inloggen</h2>
//Als login is geslaagd de gebruiker naar de admin pagina sturen
<?php if ($login) {

    header('Location: secure.php');?>

<?php } else { ?>
    <form action="" method="post">
        <div>
            <label for="mail">mail</label>
            <input id="mail" type="text" name="mail" value="<?= $mail ?? '' ?>"/>
            <span class="errors"><?= $errors['mail'] ?? '' ?></span>
        </div>
        <div>
            <label for="password">Wachtwoord</label>
            <input id="password" type="password" name="password" />
            <span class="errors"><?= $errors['password'] ?? '' ?></span>
        </div>
        <div>
            <p class="errors"><?= $errors['loginFailed'] ?? '' ?></p>
            <input type="submit" name="submit" value="Login"/>
        </div>
        <div>


            <a href="index.php">Terug</a>
        </div>
    </form>
<?php } ?>
</body>
</html>

