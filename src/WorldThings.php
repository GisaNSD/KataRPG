<?php

namespace App;

class WorldThings{

    public $thing;
    public $level;
    public $alive;
    protected $faction;
    public $destroyed;

    function __construct()
    {
        $this->thing = true;
        $this->level = 1;
        $this->alive= true;
        $this->faction= "Neutral";
        $this->destroyed= false;
    }


    public function setHealth($health){
        $this->health = $health;
    }

    public function getHealth(){
        return $this->health;
    }

    public function getFaction(){

        return $this->faction;

    }

    public function thingIsDestroyed($thing){

    if($this->health <= 0){
        unset($thing);
       return;
    }
    return;
}
}