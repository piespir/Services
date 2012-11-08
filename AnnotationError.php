<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AnnotationError
 *
 * @author inluare
 */
class AnnotationError {
    private $messages  = array();
    
    public function set($property,$message)
    {
        $this->messages[(string) $property] = (string) $message;
    }
    
    public function getErrors()
    {
        return $this->messages;
    }
    
    public function getError($key)
    {
        return isset($this->messages[(string)$key]) ? $this->messages[(string)$key]:null;
    }
}

?>
