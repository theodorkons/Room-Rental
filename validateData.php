<?php
require_once 'rental_database.php';

$db = new RentalDatabase();
if(isset($_GET['username'])){
    $username = $_GET['username'];
    if($db->userExists($username)){
        echo "false";
    }else{
        echo "true";
    }

}

?>