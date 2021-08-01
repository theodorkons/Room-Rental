<?php
/**
 * Created by PhpStorm.
 * User: john
 * Date: 4/6/2018
 * Time: 1:03 μμ
 */

class Review{

    var $_rating = null;
    var $_reviewText = null;

    public function __construct($rating, $reviewText){
        $this->_rating = $rating;
        $this->_reviewText = $reviewText;
    }


    /**
     * @return null
     */
    public function getRating(){
        return $this->_rating;
    }

    /**
     * @param null $rating
     */
    public function setRating($rating): void{
        $this->_rating = $rating;
    }

    /**
     * @return null
     */
    public function getReviewText(){
        return $this->_reviewText;
    }

    /**
     * @param null $reviewText
     */
    public function setReviewText($reviewText): void{
        $this->_reviewText = $reviewText;
    }



}