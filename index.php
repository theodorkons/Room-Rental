<?php
require_once('Accommodation.php');
require_once('rental_database.php');

session_start();

$db = new RentalDatabase();

$accoms = $db->getAccomms();

?>
<!DOCTYPE html>

<html>
<head>

    <script type="application/javascript" src="script.js"></script>

    <link type="text/css" rel="stylesheet" href="styles/my_housing_card.css">
    <link type="text/css" rel="stylesheet" href="styles/msg_popup.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


    <style>
        #popup {
            display: none;

            width: 600px;

            height: max-content;

            position: fixed;
            top: 10%;
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

        #page-title {
            display: block;
            margin: 0 auto;
            padding-top: 5px;
            padding-bottom: 5px;
            text-align: center;
            position: sticky;
            top: 60px;
            background-color: white;
            z-index: 10;
        }

        #flexbox {
            display: flex;
            justify-content: center;
        }

    </style>
</head>
<body id="body">

<?php include 'header.php'; ?>

<div id="overlay">
</div>

<h1 id="page-title">Registered Housings</h1>

<div class="row housings">
    <?php
    foreach ($accoms as $accom) {
        echo('<div class="column">');
        echo($accom->toHtmlCard());
        echo('</div>');
    }
    ?>
</div>


<div id="unscrollable">
    <div id="flexbox">
        <div id="popup">

        </div>
    </div>
</div>


</body>
</html>
