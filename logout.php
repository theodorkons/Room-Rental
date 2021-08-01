<?php

$prevPageFull = $_SERVER['HTTP_REFERER'];

session_start();
session_unset();
session_destroy();

$prevPage = substr($prevPageFull, strrpos($prevPageFull, '/'));
$prevPage = trim($prevPage, '/');

if($prevPage === 'user_profile.php'){
    $prevPage = '/RoomRental/';
}else{
    $prevPage = $prevPageFull;
}

header("Location: $prevPage", true, 303);
