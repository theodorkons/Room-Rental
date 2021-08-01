<?php
require_once('Accommodation.php');
require_once('rental_database.php');

function main(){
   // Check to make sure that an image has been specified. If not, display an
  // error page.
  if (!isset($_GET['id'])) {
    display_error("You must specify a housing ID using the ?id query parameter.");
    return;
  }

  // Retrieve the card from the database
  $db = new RentalDatabase();
  $housing = $db->retrieveAccommodation($_GET['id']);

  // Display card
  display_Housing($housing);
}

?>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <!--    <link type="text/css" rel="stylesheet" href="styles/popupforms.css">-->
    <link rel="icon" href="icon.svg" sizes="any" type="image/svg+xml">
        <!--        <img src="img/airbnb.png" alt="Airbnb" class="logo"/>-->
    </a>
    <link type="text/css" rel="stylesheet" href="../styles/header.css">
    <link type="text/css" rel="stylesheet" href="../styles/housing_info.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <title>Housing Information</title>

</head>
    <body>

    <form action="../index.php" method="get" hidden></form>

    <?php include 'header.php'; ?>

    <div id="side-nav">
        <a href="#slideshow-container">Photos</a>
        <a href="#housing_info">Housing Information</a>
        <a href="#rating">Rating</a>
        <a href="#reviews">Reviews</a>
    </div>

    <!-- Center Menu -->
    <div class="center-menu">
        <!-- Slideshow container -->
        <div class="slideshow-container">

          <!-- Full-width images with number and caption text -->
          <div class="mySlides fade">
            <div class="numbertext">1 / 3</div>
            <img src="$img[0]" style="width:100%">
            <div class="text">Caption Text</div>
          </div>

          <div class="mySlides fade">
            <div class="numbertext">2 / 3</div>
            <img src="img[1]" style="width:100%">
            <div class="text">Caption Two</div>
          </div>

          <div class="mySlides fade">
            <div class="numbertext">3 / 3</div>
            <img src="img[2]" style="width:100%">
            <div class="text">Caption Three</div>
          </div>

          <!-- Next and previous buttons -->
          <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
          <a class="next" onclick="plusSlides(1)">&#10095;</a>
        </div>
        <br>

        <!-- The dots/circles -->
        <div class="dots">
          <span class="dot" onclick="currentSlide(1)"></span>
          <span class="dot" onclick="currentSlide(2)"></span>
          <span class="dot" onclick="currentSlide(3)"></span>
        </div>

        <div class="head" id="housing_info">Housing Information</div>
        <div class="content">
            <?php echo $title ?>
            <br>
            <?php echo $location ?>
            <br>
            <?php echo $description ?>
        </div>

        <div class="head" id="rating"> Rating </div>
        <div class="content"></div>

        <div class="head" id="reviews"> Reviews</div>
        <div class="content">$reviews</div>
    </div>

    <script>
        var slideIndex = 1;
    showSlides(slideIndex);

    // Next/previous controls
    function plusSlides(n) {
      showSlides(slideIndex += n);
    }

    // Thumbnail image controls
    function currentSlide(n) {
      showSlides(slideIndex = n);
    }

    function showSlides(n) {
      var i;
      var slides = document.getElementsByClassName("mySlides");
      var dots = document.getElementsByClassName("dot");
      if (n > slides.length) {slideIndex = 1}
      if (n < 1) {slideIndex = slides.length}
      for (i = 0; i < slides.length; i++) {
          slides[i].style.display = "none";
      }
      for (i = 0; i < dots.length; i++) {
          dots[i].className = dots[i].className.replace(" active", "");
      }
      slides[slideIndex-1].style.display = "block";
      dots[slideIndex-1].className += " active";
    }
    </script>

    </body>

</html>

main();