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
    protected bool $allie;
 

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
        $this->allie= false;
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
    public function getAllie(): bool
    {
        return $this->allie;
    }

    public function setHealth($life): int
    {
        return $this->health= $life;
    }

    public function setLevel($level): int
    {
        return $this->level = $level;
    }

    public function setRange($distance): void
    {
        $this->range = $distance;
    }
    
    public function attacks($attacker, $damaged)
    { 
        if ($attacker->name == $damaged->name || $attacker->allie == true){
            echo "Character cannot attack allies";
            return $damaged->health;
        }
        
        if ( $attacker->level >= $damaged->level+ 5)
        {
            return $damaged->health -= ($attacker->damage * 1.5);};
            
            
        if ( $attacker->level <= ($damaged->level-5) )
        {
            return $damaged->health -= ($attacker->damage/2);
        };
            
         return $damaged->health -= $attacker->damage;
            
    }
        
    public function characterDies()
    {
        if($this->health <= 0){
        $this->alive= false;
        }
    }
        
    public function healing($character){
            
        if($character->alive == false) { 
            $this->health= 0;
            return "Cannot heal death character";};
        
        if($character->health >= 600) {return $character->health= 1000;};
                
        return $character->health += $this->heal;
    }

    public function healingAllies($character){
            
        if($character->alive == false) { 
            $this->health= 0; 
            return "Cannot heal death character";
        };
        
        if($character->allie == true && $character->health >= 600) { 
            return $character->health= 1000;
        };
        
        if($character->allie == true) {
            return $character->health += $this->heal;
        }
        
        return "Character can only heal allies";
    }
            
    public function itselfHealing($healer, $cured){
                
        if($healer->name != $cured->name) { return "Healer only heals itself";}
                
        if($cured->getHealth() >= 600) { return $cured->setHealth(1000); }
                
        return $cured->setHealth($cured->health + $healer->heal);}
                
                
    public function belongsAFaction($i){
                    
        $factions= ["Controlador", "Iniciador", "Centinela", "Duelista"];
                    
        foreach($i as $f){
            array_push($this->faction, $factions[$f]);
            }
    }
                
    public function leavesAFaction($i){
                    
        foreach($i as $f){
        
            $indexOfFaction = array_search($f, $this->faction);
        
            array_splice($this->faction, $indexOfFaction, 1);
        }
    }
                
    public function isAnAllie($character1, $character2){
            
        foreach($character1->faction as $f){
           $i= array_search($f, $character2->faction);
           if($i !== false){
            $character1->allie= true;
            $character2->allie = true;}
        }   
    }

}
            
            
class Melee extends Character {
                
    public function attacks($attacker, $damaged)
    {   
        if($attacker->getName() == $damaged->getName()){
            echo "Character cannot damaged himself";
            return $damaged->health;
        }

        if($damaged->range >= 2){
            return $damaged->health;
        }
           
        if( $attacker->level >= $damaged->level+ 5)
        {
            return $damaged->health -= ($attacker->damage * 1.5);
        };
              
        if($attacker->level <= ($damaged->level-5))
        {
            return $damaged->health -= ($attacker->damage/2);
        };
                
        return $damaged->health -= $attacker->damage;
    
    }
}





class Ranged extends Character {

    public function attacks($attacker, $damaged)
    {   
        if($attacker->getName() == $damaged->getName()){
            echo "Character cannot damaged himself";
            return $damaged->health;
        }
        
        if($damaged->range >= 20){
            return $damaged->health;
        }
        
         if($attacker->level >= $damaged->level+ 5){
            return $damaged->health -= ($attacker->damage * 1.5);};
            
        if($attacker->level <= ($damaged->level-5)){
            return $damaged->health -= ($attacker->damage/2);};
                
        return $damaged->health -= $attacker->damage;
                
    }

}