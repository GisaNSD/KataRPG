<?php

namespace App;

class Character
{
    protected $name;
    protected int $health;
    protected int $level;
    protected bool $alive;
    protected int $damage;
    protected int $heal;
    protected int $attackRange;
    protected int $range;
    protected $faction;
    protected bool $ally;
    protected bool $thing;
 

    function __construct(string $name)
    {
        $this->name= $name;
        $this->health = 1000;
        $this->level = 1;
        $this->alive = true;
        $this->damage= 100;
        $this->heal= 400;
        $this->range= 30;
        $this->faction= [];
        $this->ally= false;
        $this->thing= false;
    }
    
    public function getHealth(): int
    {
        return $this->health;
    }
    
    public function getName()
    {
        return $this->name;
    }
    public function getRange(): int
    {
        return $this->range;
    }

    public function getLevel(): int
    {
        return $this->level;
    }
    
    public function getFaction()
    {
        return $this->faction;
    }

    public function isAlive(): bool
    {
        return $this->alive;
    }
    public function getAlly(): bool
    {
        return $this->ally;
    }

    public function setHealth($health): int
    {
        return $this->health= $health;
    }

    public function setLevel($level): int
    {
        return $this->level = $level;
    }

    public function setRange($range): void
    {
        $this->range = $range;
    }
    
    public function attacks($damaged)
    { 
        if ($this->name == $damaged->name || $this->ally == true){
            return $damaged->health;
        }
        
        if ( $this->level >= $damaged->level+ 5)
        {
            return $damaged->health -= ($this->damage * 1.5);};
            
            
        if ( $this->level <= ($damaged->level-5) )
        {
            return $damaged->health -= ($this->damage/2);
        };
            
         return $damaged->health -= $this->damage;
            
    }
        
    public function characterDies()
    {
        if($this->health <= 0){
        $this->alive= false;
        }
    }
        
    public function healing($character){
            
        if($character->alive == false || $character->thing == true) { 
            return $this->health= 0;};
        
        if($character->health >= 600) {return $character->health= 1000;};
                
        return $character->health += $this->heal;
        
    }

    public function healingAllies($character){
            
        if($character->alive == false || $character->thing == true) { 
            return $this->health= 0; 
        };
        
        if($character->ally == true && $character->health >= 600) { 
            return $character->health= 1000;
        };
        
        if($character->ally == true) {
            return $character->health += $this->heal;
        }
        
        return "Character can only heal allies";
    }
            
    public function itselfHealing($cured){
                
        if($this->name != $cured->name || $this->thing == true) {return $cured->health;}
                
        if($cured->getHealth() >= 600) { return $cured->setHealth(1000); }
                
        return $cured->setHealth($cured->health + $this->heal);}
                
                
    public function belongsAFaction($indexOfFaction){
                    
        $factions= ["Controlador", "Iniciador", "Centinela", "Duelista"];
                    
        foreach($indexOfFaction as $indexToBelong){
            array_push($this->faction, $factions[$indexToBelong]);
            }
    }
                
    public function leavesAFaction($characterFaction){
                    
        foreach($characterFaction as $fationToLeave){
        
            $indexOfFaction = array_search($fationToLeave, $this->faction);
        
            array_splice($this->faction, $indexOfFaction, 1);
        }
    }
                
    public function isAnAlly($character){
            
        foreach($this->faction as $factionCharacter){

           $indexExist= array_search($factionCharacter, $character->faction);
           
           if($indexExist !== false){
            $this->ally= true;
            $character->ally = true;}
        } 
    }

}