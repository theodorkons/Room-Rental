<?php
require_once("rental_database.php");

session_start();

$db = new RentalDatabase();

$numOfImages = 0;
if (!isset($_GET['id'])) {
    print "Id is not given";
} else {
    $housing_id = $_GET['id'];
    $accomm = $db->retrieveAccommodation($housing_id);
    $images = $accomm->getImages();
    $numOfImages = count($images);
}


?>

<!DOCTYPE html>

<html>
<head>

    <script type="application/javascript" src="script.js"></script>
    <link type="text/css" rel="stylesheet" href="styles/housing_slideshow.css">
    <link type="text/css" rel="stylesheet" href="styles/housing_info.css">
    <link rel="stylesheet" href="styles/msg_popup.css" type="text/css">

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

<h1 id="page-title"><?php echo $accomm->getTitle(); ?></h1>

<div class="housing-info">
    <div class="slideshow-container">

        <?php
        for ($i = 0; $i < $numOfImages; $i++) {
            $j = $i + 1;
            echo('<div class="mySlides fade">');
            echo("<div class='numbertext'>$j / $numOfImages</div>");
            echo("<img src=\"$images[$i]\" style='width:100%'>");
            echo('</div>');
        }
        ?>

        <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
        <a class="next" onclick="plusSlides(1)">&#10095;</a>

    </div>
    <br>

    <div style="text-align:center">
        <?php
        for ($i = 1; $i <= $numOfImages; $i++) {
            echo("<span class='dot' onclick=\"currentSlide($i)\"></span>");
        }
        ?>
    </div>

    <?php echo $accomm->toHtmlInfo() ?>

</div>

<div id="unscrollable">
    <div id="flexbox">
        <div id="popup">

        </div>
    </div>
</div>


</body>

<script>
    var slideIndex = 1;
    showSlides(slideIndex);

    function plusSlides(n) {
        showSlides(slideIndex += n);
    }

    function currentSlide(n) {
        showSlides(slideIndex = n);
    }

    function showSlides(n) {
        var i;
        var slides = document.getElementsByClassName("mySlides");
        var dots = document.getElementsByClassName("dot");
        if (n > slides.length) {
            slideIndex = 1
        }
        if (n < 1) {
            slideIndex = slides.length
        }
        for (i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";
        }
        for (i = 0; i < dots.length; i++) {
            dots[i].className = dots[i].className.replace(" active", "");
        }
        slides[slideIndex - 1].style.display = "block";
        dots[slideIndex - 1].className += " active";
    }
</script>
</html>

