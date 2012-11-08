<?php

class AnnotationType {
    static private $types = array('boolean','string','text','date','datetime','integer','float','binary','decimal');
    
    
    static public function filter($property,$typeneedle)
    {
        $type = gettype($property);
        if(($type=='array'|| $type=="object" || $type=='resource' ) && !in_array($typeneedle,  static::$types))
        {
            return null;
        }
        if( ($type !=  $typeneedle))
        {
            return null;
        }
        
        return $property;
    }
}
