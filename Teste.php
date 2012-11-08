<?php

/**
 * @Table (name=teste,type=myisam)
 */
class Teste extends Annotation{

    
    /**
     * @Column (name=var1,type=string,lenght=11)
     */
    private $var1;

    /**
     * @Id (name=Id,type=integer,lenght=45)
     */
    private $Id;

    /**
     * @Column (name=var3,type=text,lenght=11)
     */
    private $var3;
    
    

}
