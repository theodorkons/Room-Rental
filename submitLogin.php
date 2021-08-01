<?php

require_once('User.php');
require_once('rental_database.php');

$username = ($_POST['username']);
$password = ($_POST['password']);
$prevPage = $_SERVER['HTTP_REFERER'];


$db = new RentalDatabase();
$validUser = $db->isValidUser($username, $password);

if($validUser) {

    session_start();
    $_SESSION["id"] = $username;

    echo "true";

}else{
    echo "false";
}

