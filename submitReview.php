<?php
session_start();
require_once "Review.php";
require_once('rental_database.php');

$username = ($_SESSION['id']);
$housing_id = ($_POST['housing_id']);
$prevPage = $_SERVER['HTTP_REFERER'];

$db = new RentalDatabase();
$review = new Review();
$review->setRating($_POST['rating']);
$review->setReviewText($_POST['review']);

$db->addReview($review, $housing_id);

header("Location: $prevPage", true, 303);