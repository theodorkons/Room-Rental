<?php

class Review{

    var $_rating = null;
    var $_reviewText = null;

    public function getRating(){
        return $this->_rating;
    }

    public function setRating($rating): void{
        $this->_rating = $rating;
    }

    public function getReviewText(){
        return $this->_reviewText;
    }

    public function setReviewText($reviewText): void{
        $this->_reviewText = $reviewText;
    }



}