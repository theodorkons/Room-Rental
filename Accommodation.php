<?php
require_once('rental_database.php');

class Accommodation
{
    var $_id = null;
    var $_username = null;
    var $_title = null;
    var $_images = array();
    var $_location = null;
    var $_description = null;
    var $_check_in = null;
    var $_check_out = null;
    var $_reviews = array();
    var $_availability = true;

    /**
     * Accommodation constructor.
     * @param null $_username
     * @param null $_title
     * @param null $_location
     * @param null $_description
     * @param null $_check_in
     * @param null $_check_out
     */
    public function __construct($args = array())
    {
        if (count($args) != 0) {
            $this->_id = $args[0];
            $this->_username = $args[1];
            $this->_title = $args[2];
            $this->_location = $args[3];
            $this->_description = $args[4];
            $this->_check_in = $args[5];
            $this->_check_out = $args[6];
            $this->_availability = $args[7];
        }
    }

    /**
     * @return null
     */
    public function getUsername()
    {
        return $this->_username;
    }

    /**
     * @param null $username
     */
    public function setUsername($username): void
    {
        $this->_username = $username;
    }

    /**
     * @return null
     */
    public function getAvailability()
    {
        return $this->_availability;
    }

    /**
     * @param null $availability
     */
    public function setAvailability($availability): void
    {
        $this->_availability = $availability;
    }

    function setId($value)
    {
        $this->_id = $value;
    }

    function getId(): int
    {
        return $this->_id;
    }

    function setTitle($value)
    {
        $this->_title = $value;
    }

    function getTitle(): string
    {
        return $this->_title;
    }

    function setImages($value)
    {
        $this->_images = $value;
    }

    function addImage($image)
    {
        array_push($this->_images, $image);
    }

    function addImages($images)
    {
        foreach ($images as $image) {
            $this->addImage($image);
        }
    }

    function getImages(): array
    {
        return $this->_images;
    }

    function setLocation($value)
    {
        $this->_location = $value;
    }

    function getLocation(): string
    {
        return $this->_location;
    }

    function setDescription($value)
    {
        $this->_description = $value;
    }

    function getDescription(): string
    {
        return $this->_description;
    }

    function setCheckIn($value)
    {
        $this->_check_in = $value;
    }

    function getCheckIn(): string
    {
        return $this->_check_in;
    }

    function setCheckOut($value)
    {
        $this->_check_out = $value;
    }

    function getCheckOut(): string
    {
        return $this->_check_out;
    }

    function setReviews($value)
    {
        $this->_reviews = $value;
    }

    function getReviews(): array
    {
        return $this->_reviews;
    }

    function toHtmlCard()
    {
        $main_image = isset($this->_images[0]) ? $this->_images[0] : "housing_photos/default_housing.jpeg";
        $db = new RentalDatabase();
        return sprintf(
            '<div class="card">
                        <img src="%s">
                        <div id="container">
                            <a id="title" href="housing_info.php?id=%s">%s</a>
                            <span>(<a id="rating-res" onclick="%s">%s</a>)</span>
                            <p id="location">%s</p>
                            <p id="description">%s</p>
                            <a id="user" href="user_accom.php?username=%s">%s</a>
                            <p class="popup">
                                <button class="button popup-btn" onclick="%s">Book now!</button>
                                <span class="popuptext" id="popup_msg%s">This housing is currently unavailable</span>
                            </p>
                        </div>
                    </div>',
            $main_image,
            $this->_id,
            $this->_title,
            isset($_SESSION["id"]) ? "review($this->_id)" : "login()",
            $db->getRating($this->_id),
            $this->_location,
            $this->_description,
            $this->_username,
            $this->_username,
            isset($_SESSION["id"]) ? ($this->_availability ? "book($this->_id)" : "unavail_msg($this->_id)") : "login()",
            $this->_id);
    }

    function toHtmlInfo()
    {
        $db = new RentalDatabase();
        return sprintf(
            '<div id="static-div">
                       <div id="info-book">
                            <div id="info" class="card">
                                <div id="location">
                                    <h4>Location</h4>
                                    <span>%s</span>
                                </div>
                                <div id="description">
                                    <h4>Description</h4>
                                    <p >%s</p>
                                </div>
                                <span id="rating">(<a onclick="%s">%s</a>)</span>
                             </div>
                            <div id="book" class="card">
                                <form method="post" action="submitBooking.php" class="custom-form" id="book-form">
                                    <label class="customInput" for="check-in">Check In</label><br>
                                    <input class="customInput" type="date" name="check-in" min="%s" max="%s" required><br>
                                    <label class="customInput" for="check-out">Check Out</label><br>
                                    <input class="customInput" type="date" name="check-out" min="%s" max="%s" required>
                                    <input type="hidden" name="housing_id" id="housing_id" value="%s"/>
                                    <hr>
                                    <p class="popup">
                                        <input id="regBtn" type="button" value="Book now!" class="customInput button popup-btn" onclick="%s">
                                        <span class="popuptext" id="popup_msg%s">This housing is currently unavailable</span>
                                    </p>                                
                            </form>
                            </div>
                        </div>
                    </div>',
            $this->_location,
            $this->_description,
            isset($_SESSION["id"]) ? "review($this->_id)" : "login()",
            $db->getRating($this->_id),
            $this->_check_in,
            $this->_check_out,
            $this->_check_in,
            $this->_check_out,
            $this->_id,
            isset($_SESSION["id"]) ? ($this->_availability ? "" : "unavail_msg($this->_id)") : "login()",
            $this->_id);
    }


}