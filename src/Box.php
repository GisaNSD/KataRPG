<?php

namespace App;

class Box extends WorldThings{

    public $name;
    public $health;
    public $quantity;
    
function __construct()
    {
        parent::__construct();
        $this->health = 2000;
        $this->name = "Box";
        $this->quantity= 0;
    }

}