<?php
/**
 * Created by PhpStorm.
 * User: john
 * Date: 25/5/2018
 * Time: 6:13 μμ
 */

class User{
    var $_username = null;
    var $_password = null;
    var $_name = null;
    var $_avatar = null;
    var $_email = null;
    var $rentals = null;

    var $_shouldSanitize = false;

    /**
     * User constructor.
     * @param null $_username
     * @param null $_password
     * @param null $_name
     * @param null $_avatar
     * @param null $_email
     */
    public function __construct($_username, $_password, $_name, $_avatar, $_email){
        $this->_username = $_username;
        $this->_password = $_password;
        $this->_name = $_name;
        $this->_avatar = $_avatar;
        $this->_email = $_email;
    }

    function setShouldSanitize($value) {
      $this->_shouldSanitize = $value;
    }

    function getShouldSanitize(): bool{
        return $this->_shouldSanitize;
    }

    function setUsername($value){
        $this->_username = $value;
    }

    function getUsername(){
        return $this->_username;
    }

    function setPassword($value){
        $this->_password = $value;
    }

     function getPassword(){
        return $this->_password;
    }

    function setName($value){
        $this->_name = $value;
    }

     function getName(){
        return $this->_name;
    }

    function setAvatar($value){
        $this->_avatar = $value;
    }

     function getAvatar(){
        return $this->_avatar;
    }

    function setEmail($value){
        $this->_email = $value;
    }

     function getEmail(){
        return $this->_email;
    }

    public function __toString(){
        return sprintf("Username: %s, Password: %s, Name: %s, Email: %s, Avatar: %s",
            $this->_username,
            $this->_password,
            $this->_name,
            $this->_email,
            $this->_avatar);
    }
}