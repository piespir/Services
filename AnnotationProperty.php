<?php

class AnnotationProperty {

    private $data = array();

    public function set($key, $value) {
        $this->data[(string) $key] = (string) $value;
    }

    public function get($key) {
        return isset($this->data[(string) $key]) ? $this->data[(string) $key] : null;
    }

}

