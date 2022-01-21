// Session kapot maken en terugsturen naar login
<?php
session_start();
session_destroy();
header('Location: login.php');
exit;

