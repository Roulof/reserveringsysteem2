<?php
/** @var mysqli $db */

//Checken of de gebruiker is ingelogd, zo niet wordt deze teruggestuurd naar de login pagina
if (!isset($_SESSION['loggedInUser'])) {
    header("Location: login.php");
    exit;
}

// Connectie maken met database
require_once "connect.php";


if (isset($_POST['submit'])) {
    // Variabele van de post beveiligd met een escape_string
    $bookingId = mysqli_escape_string($db, $_POST['id']);

    // Alles selecteren uit de database waar booking id overeenkomt met de variabele
    $query = "SELECT * FROM booking WHERE id = '$bookingId'";
    $result = mysqli_query($db, $query) or die ('Error: ' . $query);

    $booking = mysqli_fetch_assoc($result);


    // Alles deleten waar booking id overeenkomt met de variabele
    $query = "DELETE FROM booking WHERE id = '$bookingId'";
    mysqli_query($db, $query) or die ('Error: ' . mysqli_error($db));

    //Close connection
    mysqli_close($db);

    //Redirect naar de admin pagina
    header("Location: secure.php");
    exit;

} else if (isset($_GET['id']) || $_GET['id'] != '') {
    //Retrieve the GET parameter from the 'Super global'
    $bookingId = mysqli_escape_string($db, $_GET['id']);

    //Get the record from the database result
    $query = "SELECT * FROM booking WHERE id = '$bookingId'";
    $result = mysqli_query($db, $query) or die ('Error: ' . $query);

    if (mysqli_num_rows($result) == 1) {
        $booking = mysqli_fetch_assoc($result);
    } else {
        // redirect when db returns no result
        header('Location: secure.php');
        exit;
    }
} else {
    // Id was not present in the url OR the form was not submitted

    // redirect to index.php
    header('Location: secure.php');
    exit;
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
    <title>Delete - <?= $booking['name'] ?></title>
</head>
<body>
<h2>Delete - <?= $booking['name'] ?></h2>
<form action="" method="post">
    <p>
        Weet je zeker dat je de reservering van "<?= $booking['name'] ?>" wilt verwijderen?
    </p>
    <input type="hidden" name="id" value="<?= $booking['id'] ?>"/>
    <input type="submit" name="submit" value="Verwijderen"/>
</form>
</body>
</html>
