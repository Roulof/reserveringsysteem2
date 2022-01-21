<?php


// Variabelen met inloggegevens van de database
$host = "localhost";
$database = "cle";
$user = "root";
$password = "";


// connectie maken met database
$db = mysqli_connect($host, $user, $password, $database)
or die("Error: " . mysqli_connect_error());;
