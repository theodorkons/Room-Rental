<?php
require_once "rental_database.php";
$housing_id = $_GET['housing_id'];
$db = new RentalDatabase();
$reviews = $db->retrieveReviews($housing_id);
?>

<link type="text/css" rel="stylesheet" href="styles/review.css">
<link type="text/css" rel="stylesheet" href="popupforms.css">

<button type="button" id="exitBtn" aria-busy="false">
    <svg viewBox="0 0 24 24" role="img" aria-label="Κλείσιμο" focusable="false"
         style="height: 16px; width: 16px; display: block; fill: rgb(118, 118, 118);">
        <path d="m23.25 24c-.19 0-.38-.07-.53-.22l-10.72-10.72-10.72 10.72c-.29.29-.77.29-1.06 0s-.29-.77 0-1.06l10.72-10.72-10.72-10.72c-.29-.29-.29-.77 0-1.06s.77-.29 1.06 0l10.72 10.72 10.72-10.72c.29-.29.77-.29 1.06 0s .29.77 0 1.06l-10.72 10.72 10.72 10.72c.29.29.29.77 0 1.06-.15.15-.34.22-.53.22"
              fill-rule="evenodd"></path>
    </svg>
</button>
<h2 id="popuptitle">Review</h2>
<form method="post" class="custom-form rating-widget" id="review-form">
    <label class="customInput" for="rating">Rating</label><br>
    <input id="rating" class="customInput" type="range" name="rating" min="1" max="5" required><br>
    <label class="customInput" for="review">Review</label><br>
    <input id="review" class="customInput" type="text" name="review" onkeypress="checkReviewPressedKey()" multiple required>
    <input type="hidden" name="housing_id" id="housing_id" value="<?php echo $housing_id ?>"/>
    <hr>
    <input id="regBtn" type="button" name="submit" value="Submit Review" onclick="submitReview()">
</form>
<hr style="width: 100%; margin-top: 5px;">
<div id="reviews" class="custom-form">
    <h2 id="popup-review-title">Reviews</h2>
    <?php
    foreach ($reviews as $r){
        echo "<div class='review'>";
        echo "<h3 id='rating' class='rating'>$r->_rating stars</h3>";
        echo "<p id='review-text' class='review-text'>$r->_reviewText</p>";
        echo "</div>";
    }
    ?>
</div>