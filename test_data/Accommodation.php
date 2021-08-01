<?php

class Accommodation{
    var $_id = null; //will be used to trace it back during the addAccommReview and addAccommRental
    var $_username = null;
    var $_title = null;
    var $_images = array(); //array of image paths
    var $_location = null;
    var $_description = null;
    var $_check_in = null;
    var $_check_out = null;
    var $_reviews = array(); //array of Review objects
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
    public function __construct($_username, $_title, $_location, $_description, $_check_in, $_check_out, $avail){
        /*print $args[7];
        var_dump($args);*/
        $this->_username = $_username;
        $this->_title = $_title;
        $this->_location = $_location;
        $this->_description = $_description;
        $this->_check_in = $_check_in;
        $this->_check_out = $_check_out;
        $this->_availability = $avail;
    }

    /**
     * @return null
     */
    public function getUsername(){
        return $this->_username;
    }

    /**
     * @param null $username
     */
    public function setUsername($username): void{
        $this->_username = $username;
    }

    /**
     * @return null
     */
    public function getAvailability(){
        return $this->_availability;
    }

    /**
     * @param null $availability
     */
    public function setAvailability($availability): void{
        $this->_availability = $availability;
    }

    function setId($value){
        $this->_id = $value;
    }

    function getId(): int{
        return $this->_id;
    }

    function setTitle($value){
        $this->_title = $value;
    }

    function getTitle(): string{
        return $this->_title;
    }

    function setImages($value){
        $this->_images = $value;
    }

    function addImage($image){
        array_push($this->_images, $image);
    }

    function addImages($images){
        foreach ($images as $image){
            $this->addImage($image);
        }
    }

    function getImages(): array{
        return $this->_images;
    }

    function setLocation($value){
        $this->_location = $value;
    }

    function getLocation(): string {
        return $this->_location;
    }

    function setDescription($value){
        $this->_description = $value;
    }

    function getDescription(): string {
        return $this->_description;
    }

    function setCheckIn($value){
        $this->_check_in = $value;
    }

    function getCheckIn(): string{
        return $this->_check_in;
    }

    function setCheckOut($value){
        $this->_check_out = $value;
    }

    function getCheckOut(): string{
        return $this->_check_out;
    }

    function setReviews($value){
        $this->_reviews = $value;
    }

    function getReviews(): array{
        return $this->_reviews;
    }

    function toHtmlCard(){
        $main_image = $this->_images[0];
        //TODO use the cookie to determine the user
        return sprintf(
            '<div class="card">
                        <img src="%s">
                        <div id="container">
                            <a id="title" href="housing_info.php?id=%s">%s</a>
                            <h2>Test h2 header</h2>
                            <p id="location">%s</p>
                            <p id="description">%s</p>
                            <a id="user" href="user_profile.php">%s</a>
                            <p><button class="button">Book now!</button></p>
                        </div>
                    </div>',
            $main_image,
            $this->_id,
            $this->_title,
            $this->_location,
            $this->_description,
            $this->_username);
    }

    function toHtmlInfo(){
        return sprintf(
            '<div id="info" class="card">
                        <h1 id="title">%s</h1>
                        <h4 id="location">%s</h4>
                        <p id="description">%s</p>
                    </div>
                    <div id="book" class="card">
                        <form id="book-form">
                            <label for="check-in">Check In</label><br>
                            <input type="date" name="check-in"><br>
                            <label for="check-out">Check Out</label><br>
                            <input type="date" name="check-out">
                            <input id="btn" type="submit" name="submit" value="Book">
                        </form>
                    </div>',
            $this->_title,
            $this->_location,
            $this->_description);
    }


}