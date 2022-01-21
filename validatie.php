<?php
// Errors tonen wanneer velden zijn leeggelaten
$errors = [];
if ($name == "") {
    $errors['name'] = 'Name cannot be empty';
}
if ($lastname == "") {
    $errors['lastname'] = 'Album cannot be empty';
}
if ($mail == "") {
    $errors['mail'] = 'Genre cannot be empty';
}

if ($date == "") {
    $errors['date'] = 'Year cannot be empty';
}


if ($time == "") {
    $errors['time'] = 'Tracks cannot be empty';
}

