<?php
require_once "rental_database.php";
$rd = new RentalDatabase();
$housing_id = $_GET['housing_id'];
$accommodation = $rd->retrieveAccommodation($housing_id);

$checkIn = $accommodation->getCheckIn();
$checkOut = $accommodation->getCheckOut();
?>

<button type="button" id="exitBtn" aria-busy="false">
    <svg viewBox="0 0 24 24" role="img" aria-label="Κλείσιμο" focusable="false"
         style="height: 16px; width: 16px; display: block; fill: rgb(118, 118, 118);">
        <path d="m23.25 24c-.19 0-.38-.07-.53-.22l-10.72-10.72-10.72 10.72c-.29.29-.77.29-1.06 0s-.29-.77 0-1.06l10.72-10.72-10.72-10.72c-.29-.29-.29-.77 0-1.06s.77-.29 1.06 0l10.72 10.72 10.72-10.72c.29-.29.77-.29 1.06 0s .29.77 0 1.06l-10.72 10.72 10.72 10.72c.29.29.29.77 0 1.06-.15.15-.34.22-.53.22"
              fill-rule="evenodd"></path>
    </svg>
</button>
<h2 id="popuptitle">Book</h2>
<form method="post" action="submitBooking.php" class="custom-form" id="book-form">
    <label class="customInput" for="check-in">Check In</label><br>
    <input class="customInput" type="date" name="check-in" min="<?php echo $checkIn ?>" max="<?php echo $checkOut?>" required><br>
    <label class="customInput" for="check-out">Check Out</label><br>
    <input class="customInput" type="date" name="check-out" min="<?php echo $checkIn ?>" max="<?php echo $checkOut ?>" required>
    <input type="hidden" name="housing_id" id="housing_id" value="<?php echo $housing_id ?>"/>
    <hr>
    <input id="regBtn" type="submit" name="submit" value="Book">
</form>