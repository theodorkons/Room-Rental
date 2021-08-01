<?php
session_start();
require_once "Rental.php";
require_once('rental_database.php');

$username = ($_SESSION['id']);
$housing_id = ($_POST['housing_id']);
$prevPage = $_SERVER['HTTP_REFERER'];

$db = new RentalDatabase();
$rental = new Rental();
$rental->setCheckIn($_POST['check-in']);
$rental->setCheckOut($_POST['check-out']);
$rental->setUsername($username);
$rental->setHousingId($housing_id);

$db->addRental($rental);

header("Location: $prevPage", true, 303);
