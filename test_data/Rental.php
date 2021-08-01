<?php
/**
 * Created by PhpStorm.
 * User: john
 * Date: 25/5/2018
 * Time: 6:19 μμ
 */

class Rental{
    var $_id = null; //redundant
    var $_housing_id = null;
    var $_username = null;
    var $_check_in = null;
    var $_check_out = null;

    public function __construct($housing_id, $username, $check_in, $check_out){
        $this->_housing_id = $housing_id;
        $this->_username = $username;
        $this->_check_in = $check_in;
        $this->_check_out = $check_out;
    }


    /**
     * @return null
     */
    public function getHousingId(){
        return $this->_housing_id;
    }

    /**
     * @param null $housing_id
     */
    public function setHousingId($housing_id): void{
        $this->_housing_id = $housing_id;
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



    function setId($value){
        $this->_id = $value;
    }

    function getId(){
        return $this->_id;
    }

    function setCheckIn($value){
        $this->_check_in = $value;
    }

    function getCheckIn(){
        return $this->_check_in;
    }

    function setCheckOut($value){
        $this->_check_out = $value;
    }

    function getCheckOut(){
        return $this->_check_out;
    }

}