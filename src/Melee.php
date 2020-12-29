<?php

namespace App;

class Melee extends Character {

    public function attacks($damaged)
    {   
        if($this->getName() == $damaged->getName() || $this->ally == true){
        return $damaged->health;
    }
            
        if($damaged->range >= 2){
            return $damaged->health;
        }
                       
        if( $this->level >= $damaged->level+ 5)
        {
            return $damaged->health -= ($this->damage * 1.5);
        };
                          
        if($this->level <= ($damaged->level-5))
        {
            return $damaged->health -= ($this->damage/2);
        };
                            
        return $damaged->health -= $this->damage;
                
        }
}