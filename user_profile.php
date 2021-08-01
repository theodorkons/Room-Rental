<?php
require_once "rental_database.php";
session_start();
if (!isset($_SESSION['id'])) {
    echo "window.alert('No cookie has been set')";
} else {
    $username = $_SESSION['id'];

    $db = new RentalDatabase();
    $user = $db->retrieveUser($username);
    $prentals = $db->retrievePastRentals($username);
    $frentals = $db->retrieveFutureRentals($username);
    $accommodation = $db->retrieveUserAccom($username);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Airbnb/user</title>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no"/>

    <script type="application/javascript" src="script.js"></script>

    <link rel="icon" href="img/airbnb.png">

    <link rel="stylesheet" href="styles/user_profile.css" type="text/css">

    <link rel="stylesheet" href="styles/rental_card.css" type="text/css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <style>
        #popup {
            display: none;

            width: 600px;

            height: max-content;

            position: absolute;
            top: 25%;
            z-index: 100;

            background-color: white;

            border: hidden;
            border-radius: 4px;

            padding: 20px;
        }

        #overlay {
            position: fixed;
            display: none;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 99;
            cursor: pointer;
        }

        #flexbox {
            display: flex;
            justify-content: center;
        }

    </style>
</head>
<body>

<?php include 'header.php'; ?>

<div id="overlay">
</div>

<div id="main-body">

    <div id="side-nav">
        <a href="#user-info">Personal Info</a>
        <a href="#prentals">Past Rentals</a>
        <a href="#frentals">Feature Rentals</a>
        <a href="#accommodation">My Accommodations</a>
    </div>

    <div class="menu">

        <div class="head" id="user-info">Personal Info</div>

        <div class="content">
            <img id="u-img" src='<?php echo $user->getAvatar() ?>' alt="User Image">
            <span id="username">Username: </span>
            <span> <?php echo $user->getUsername() ?></span>
            <br>
            <span id="name">Name: </span>
            <span> <?php echo $user->getName() ?></span>
            <br>
            <span id="email">Email: </span>
            <span> <?php echo $user->getEmail() ?> </span>
        </div>

        <div class="head" id="prentals"> Past Rentals</div>
        <div class="content row housings">
            <?php
            foreach ($prentals as $pr) {
                $accom = $db->retrieveAccommodation($pr->getHousingId());
                echo('<div class="column">');
                printf('
                    <div class="card">
                        <img src="%s">
                        <div id="container">
                            <a id="title" href="housing_info.php?id=%s">%s</a>
                            <span>(<a id="rating-res" onclick="%s">%s</a>)</span>    
                            <p id="location">%s</p>   
                            <p id="checkin">%s</p>
                            <p id="checkout">%s</p>  
                            </div>       
                    </div>',
                    isset($accom->getImages()[0])?$accom->getImages()[0]:'housing_photos\default_housing.jpeg',
                    $pr->getHousingId(),
                    $accom->getTitle(),
                    "review(" . $pr->getHousingId() . ")",
                    $db->getRating($pr->getHousingId()),
                    $accom->getLocation(),
                    $accom->getCheckIn(),
                    $accom->getCheckOut());
                echo('</div>');
            }
            ?>

        </div>
        <div class="head" id="frentals"> Feature Rentals</div>
        <div class="content row housings">
            <?php
            echo('<ul id="frentals">');
            foreach ($frentals as $fr) {
                $accom = $db->retrieveAccommodation($fr->getHousingId());
                echo('<div class="column">');
                printf('
                    <div class="card">
                        <img src="%s">
                        <div id="container">
                            <a id="title" href="housing_info.php?id=%s">%s</a>
                            <span>(<a id="rating-res" onclick="%s">%s</a>)</span>    
                            <p id="location">%s</p>   
                            <p id="checkin">%s</p>
                            <p id="checkout">%s</p>  
                            </div>       
                    </div>',
                    isset($accom->getImages()[0])?$accom->getImages()[0]:'housing_photos\default_housing.jpeg',
                    $fr->getHousingId(),
                    $accom->getTitle(),
                    "review(" . $fr->getHousingId() . ")",
                    $db->getRating($fr->getHousingId()),
                    $accom->getLocation(),
                    $accom->getCheckIn(),
                    $accom->getCheckOut());
                echo('</div>');
            }
            ?>
        </div>
        <div class="head" id="accommodation"> My Accommodation</div>
        <div class="content row housings">
            <?php
            foreach ($accommodation as $accom) {
                echo('<div class="column">');
                printf(
                    '<div class="card">
                        <img src="%s">
                        <div id="container">
                            <a id="title" href="housing_info.php?id=%s">%s</a>
                            <span>(<a id="rating-res" onclick="%s">%s</a>)</span>
                            <p id="location">%s</p>
                            <p id="description">%s</p>                 
                        </div>
                    </div>',
                    isset($accom->getImages()[0])?$accom->getImages()[0]:'housing_photos\default_housing.jpeg',
                    $accom->getId(),
                    $accom->getTitle(),
                    "review(" . $accom->getId() . ")",
                    $db->getRating($accom->getId()),
                    $accom->getLocation(),
                    $accom->getDescription());
                echo('</div>');
            }

            ?>
        </div>

    </div>
</div>

<div id="unscrollable">
    <div id="flexbox">
        <div id="popup">

        </div>
    </div>
</div>
</body>

</html>