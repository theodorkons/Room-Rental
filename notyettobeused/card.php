<?php

class Card{
    var $_senderEmail = null;
    var $_senderName = null;
    var $_recipientEmail = null;
    var $_recipientName = null;
    var $_imageUrl = null;
    var $_messageSubject = null;
    var $_messageBody = null;
    var $_shouldSanitize = false;

    function _output($value) {
      if ($this->_shouldSanitize)
        return htmlspecialchars($value);
      else
        return $value;
    }

    function setShouldSanitize($value) {
      $this->_shouldSanitize = $value;
    }

    function setSenderEmail($value) {
      $this->_senderEmail = $value;
    }

    function setSenderName($value) {
      $this->_senderName = $value;
    }

    function setRecipientEmail($value) {
      $this->_recipientEmail = $value;
    }

    function setRecipientName($value) {
      $this->_recipientName = $value;
    }

    function setImageUrl($value) {
      $this->_imageUrl = $value;
    }

    function setMessageSubject($value) {
      $this->_messageSubject = $value;
    }

    function setMessageBody($value) {
      $this->_messageBody = $value;
    }

    function getShouldSanitize() {
      return $this->_shouldSanitize;
    }

    function getSenderEmail() {
      return $this->_output($this->_senderEmail);
    }

    function getSenderName() {
      return $this->_output($this->_senderName);
    }

    function getRecipientEmail() {
      return $this->_output($this->_recipientEmail);
    }

    function getRecipientName() {
      return $this->_output($this->_recipientName);
    }

    function getImageUrl() {
      return $this->_output($this->_imageUrl);
    }

    function getMessageSubject() {
      return $this->_output($this->_messageSubject);
    }

    function getMessageBody() {
      return $this->_output($this->_messageBody);
    }
}
