<?php

require_once("User.php");
require_once("Accommodation.php");
require_once("rental_database.php");
require_once("Review.php");

$UFilePath = "users";
$AFilePath = "accommodation";
$AIFilePath = "accomm_image";
$ARFilePath = "accomm_reviews";
$IFilePath = "images";
$RenFilePath = "rentals";
$RevFilePath = "reviews";
$UAFilePath = "user_accomm";
$URFilePath = "user_rental";

$db = new RentalDatabase();
$userIds = array();
$accommIds = array();
$images = array();
$reviewIds = array();


addUsers($UFilePath);

getImages($IFilePath);

//var_dump($images);

addAccomms($AFilePath);

addRentals($RenFilePath);
addReviews($RevFilePath);
addAccommReviews($ARFilePath);


function addUsers($UFilePath){
    global $db;
    global $userIds;
    $usersFile = fopen($UFilePath, 'r');
    $fileContents = fread($usersFile, filesize($UFilePath));

    $lines = explode("\n", $fileContents);

    foreach ($lines as $line) {
        $userData = explode(" ", $line);
        $user = new User(...$userData);

        array_push($userIds, $db->addUser($user));

    }
}

function addAccomms($file_path){
    global $db;
    global $accommIds;
    global $images;
    $File = fopen($file_path, 'r');
    $fileContents = fread($File, filesize($file_path));

    $lines = explode("\n", $fileContents);

    foreach ($lines as $line) {
        $Data = explode(" ", $line);
        for($i = 0; $i < sizeof($Data); $i++){
            $Data[$i] = str_replace(".", " ", $Data[$i]);
//            print $Data[$i]." ";
        }
//        var_dump($Data);
        $accomm = new Accommodation(...$Data);

        for($i = 0; $i < 4; $i++) {
            $accomm->addImage($images[$i]);
        }
//        print implode("_", $images) . "\n";
//        var_dump($images);
        array_splice($images, 0, 4);
//        print implode("_", $accomm->getImages()) . "\n";

        array_push($accommIds, $db->addAccommondation($accomm));
//        var_dump($accommIds);

    }
}

function getImages($file_path){
    global $images;
    $File = fopen($file_path, 'r');
    $fileContents = fread($File, filesize($file_path));

    $lines = explode("\n", $fileContents);

    foreach ($lines as $line) {
        array_push($images, $line);

    }
}

function addRentals($file_path){
    global $db;

    $File = fopen($file_path, 'r');
    $fileContents = fread($File, filesize($file_path));

    $lines = explode("\n", $fileContents);

    foreach ($lines as $line) {
        $Data = explode(" ", $line);
        for($i = 0; $i < sizeof($Data); $i++){
            $Data[$i] = str_replace(".", " ", $Data[$i]);
        }
        $rental = new Rental(...$Data);

        $db->addRental($rental);

    }
}

function addReviews($file_path){
    global $db;

    $File = fopen($file_path, 'r');
    $fileContents = fread($File, filesize($file_path));

    $lines = explode("\n", $fileContents);

    foreach ($lines as $line) {
        $Data = explode(" ", $line);
        for($i = 0; $i < sizeof($Data); $i++){
            $Data[$i] = str_replace(".", " ", $Data[$i]);
        }
        $review = new Review(...$Data);

        $db->addReview($review);

    }
}

function addAccommReviews($file_path){
    global $db;

    $File = fopen($file_path, 'r');
    $fileContents = fread($File, filesize($file_path));

    $lines = explode("\n", $fileContents);

    foreach ($lines as $line) {
        $Data = explode(" ", $line);
        $housing_id = $Data[0];
        $review_id = $Data[1];

        $db->addAccommReview($housing_id, $review_id);

    }
}