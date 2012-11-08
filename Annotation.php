<?php

abstract class Annotation {

    /**
     * Referencia a classe a ser inspecionada
     * @var ReflectionClass  
     */
    private $reflection;
    
    protected $data = array();
    
    protected $errors = array();

    /**
     * Construtor da classe Annotation
     */
    public function __construct() {

        $this->reflection = new ReflectionClass($this);
    }

    /**
     * Retorna todas as annotations dos atributos
     * @return Array todas as annotations dos atributos
     */
    protected function _getAnnotations() {
        $props = $this->reflection->getProperties();
        $data = array();
        foreach ($props as $prop) {
            $lines = explode("\n", $prop->getDocComment());
            $count = count($lines);
            for ($i = 0; $i < $count; $i++) {
                if (strpos($lines[$i], '@')) {
                    preg_match("/@(.+)/", $lines[$i], $string);
                    $data[] = $string[1];
                }
            }
        }
        return $data;
    }

    /**
     * Retorna todos os dados de uma annotation em específico
     * @param String $annot A annotation em específico
     * @return Array Array com todos os dados de uma annotation em específico
     */
    protected function _getAnnotation($annot) {
        $props = $this->reflection->getProperties();
        $data = array();
        foreach ($props as $prop) {
            $lines = explode("\n", $prop->getDocComment());
            $count = count($lines);
            for ($i = 0; $i < $count; $i++) {
                if (strpos($lines[$i], $annot)) {
                    preg_match("/@(.+)/", $lines[$i], $string);
                    $data[] = $string[1];
                }
            }
        }
        return $data;
    }

    /**
     * Retorna os dados referentes ao annotation da tabela, da classe
     * @return Array Dados da tabela
     */
    protected function _getTableDesc() {
        $props = $this->reflection->getDocComment();
        $data = array();

        $lines = explode("\n", $props);
        $count = count($lines);
        for ($i = 0; $i < $count; $i++) {
            if (strpos($lines[$i], 'Table')) {
                preg_match("/@(.+)/", $lines[$i], $string);
                $data[] = $string[1];
            }
        }
        return $data;
    }

    /**
     * Retorna os dados da tabela pelos annotations
     * @return Mixed Retorna AnnotationProperty ou um array de AnnotationProperty
     */
    protected function _getTableData() {
        $desc = $this->_getTableDesc();
        $prop = array();
        $count = count($desc);
        for ($i = 0; $i < $count; $i++) {
            $string = explode(' ', $desc[$i]);
            $string = explode(',', str_replace(array('(', ')'), '', $string[1]));
            $counts = count($string);
            $prop[$i] = new AnnotationProperty();
            for ($j = 0; $j < $counts; $j++) {
                list($key, $value) = explode('=', $string[$j]);
                $prop[$i]->set($key, $value);
            }
        }
        return count($prop) == 1 ? $prop[0] : $prop;
    }

    /**
     * Retorna os dados da tabela
     * @return Mixed
     */
    public function getTableDesc() {
        return $this->_getTableData();
    }

    /**
     * Retorna dados das chaves primárias
     * @return Mixed
     */
    public function getIdDesc() {
        return $this->_getProperty('Id');
    }

    /**
     * Retorna propriedades das annotations pela AnnotationProperty
     * @return AnnotationProperty
     */
    protected function _getProperties() {
        $lines = $this->_getAnnotations();
        $count = count($lines);
        $props = array();
        for ($i = 0; $i < $count; $i++) {
            list($name, $desc) = explode(' ', $lines[$i]);
            $desc = str_replace(array('(', ')'), '', $desc);
            $prop = explode(',', $desc);
            $countp = count($prop);
            $props[$i] = new AnnotationProperty();
            for ($j = 0; $j < $countp; $j++) {
                list($key, $value) = explode('=', $prop[$j]);
                $props[$i]->set($key, $value);
            }
        }
        return $props;
    }
    
    protected function _getPropertyByName($key)
    {
        $props = $this->_getProperties();
        foreach($props as $prop)
        {
            if($prop->get('name') == $key)
            {
                return $prop;
            }
        }
    }

    /**
     * Retorna uma annotation específica
     * @param String $annot Uma annotation específica
     * @return Mixed
     */
    protected function _getProperty($annot) {
        $lines = $this->_getAnnotation($annot);
        $count = count($lines);
        $props = array();
        for ($i = 0; $i < $count; $i++) {
            list($name, $desc) = explode(' ', $lines[$i]);
            $desc = str_replace(array('(', ')'), '', $desc);
            $prop = explode(',', $desc);
            $countp = count($prop);
            $props[$i] = new AnnotationProperty();
            for ($j = 0; $j < $countp; $j++) {
                list($key, $value) = explode('=', $prop[$j]);
                $props[$i]->set($key, $value);
            }
        }
        return count($props) == 1 ? $props[0] : $props;
    }

    /**
     * Retornas as colunas da tabela
     * @return Mixed
     */
    public function getColumnsDesc() {

        return $this->_getProperty('Column');
    }
    
    public function __call($name, $arguments) {
       $type = substr($name, 0,3);
       if($type == 'set')
       {
           $property = substr($name, 3,  strlen($name));
           if(property_exists($this, $property))
           {
               $typeprop = $this->_getPropertyByName($property);
               $this->data[$property] = AnnotationType::filter($arguments[0], $typeprop->get('type') );                
           }
       }
       if($type == 'get')
       {
           $property = substr($name, 3,  strlen($name));
           if(property_exists($this, $property))
           {
               return isset($this->data[$property]) ? $this->data[$property] : null ;
           }
       }
    }
    
        
}