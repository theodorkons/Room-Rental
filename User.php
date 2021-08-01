<?php

class User{
    var $_username = null;
    var $_password = null;
    var $_name = null;
    var $_avatar = null;
    var $_email = null;
    var $rentals = null;

    var $_shouldSanitize = false;

    public function _construct(){

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