<?php

namespace App;

class Glass extends WorldThings{

    public $health;
    public $name;
    
    function __construct()
    {
        parent::__construct();
        $this->health = 100;
        $this->name= "Glass";   
    }

    
}