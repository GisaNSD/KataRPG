<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use App\Character;
use App\Melee;
use App\Ranged;
use App\Box;
use App\Glass;

class CharacterTest extends TestCase
{

	public function test_Health_starting_at_1000()
	{

		$sonGoku = new Character("Son Goku");

		$result = $sonGoku->getHealth();

		$this->assertEquals(1000, $result);
	}

	public function test_Level_starting_at_1()
	{

		$sonGoku = new Character("Son Goku");

		$result = $sonGoku->getLevel();

		$this->assertEquals(1, $result);
	}

	public function test_starting_Alive()
	{

		$sonGoku = new Character("Son Goku");

		$result = $sonGoku->isAlive();

		$this->assertEquals(true, $result);
	}

	public function test_damage_is_substracted_from_health()
	{
		//given escenario

		$raze = new Character("Raze");
		$omen = new Character("Omen");

		//action
		$raze->attacks($omen);

		//then

		$result = $omen->getHealth();

		$this->assertEquals(900, $result);
	}

	public function test_character_is_dead()
	{
		$phoenix= new Character("Phoenix");

		$phoenix->setHealth(0);

		$phoenix->characterDies();

		$result = $phoenix->isAlive();

		$this->assertEquals(false, $result);
	}

	public function test_healing() 
	{
		$sage = new Character("Sage");
		$cypher = new Character("Cypher");
		
		$cypher-> setHealth(300);
		$sage->healing($cypher);

		$result = $cypher->getHealth();

		$this->assertEquals(700, $result);
	}

	public function test_itself_healing(){
		$reyna= new Character("Reyna");
		
		$reyna->setHealth(600);
		
		$reyna->itselfHealing($reyna);

		$result= $reyna->getHealth();

		$this->assertEquals(1000, $result);
	}

	public function test_damage_is_incremented()
	{
		//given escenario

		$skye = new Character("Skye");
		$breach = new Character("Breach");

		$skye->setLevel(10);
		$breach->setLevel(5);

		// action
		
		$skye->attacks($breach);

		//then

		$result = $breach->getHealth();

		$this->assertEquals(850, $result);
	}

	public function test_damage_is_decreased()
	{
		//given escenario

		$jett = new Character("Jett");
		$sova = new Character("Sova");

		$jett->setLevel(5);
		$sova->setLevel(10);

		// action

		$jett->attacks($sova);

		//then

		$result = $sova->getHealth();

		$this->assertEquals(950, $result);
	}

	public function test_melee_attack_range(){
		$killjoy = new Melee('Killjoy');
		$brimstone = new Character("Brimstone");

		$brimstone-> setRange(1);
		$killjoy->attacks($brimstone);

		$result= $brimstone->getHealth();

		$this->assertEquals(900, $result);
	}


	public function test_ranged_range_attack_range(){
		$killjoy = new Ranged('Killjoy');
		$brimstone = new Character("Brimstone");

		$brimstone-> setRange(10);
		$killjoy->attacks($brimstone);

		$result= $brimstone->getHealth();

		$this->assertEquals(900, $result);
	}

	public function test_new_character_belongs_no_faction(){

		$cypher= new Character('Cypher');

		$result= $cypher->getFaction();

		$this->assertEmpty($result);
	}

	public function test_character_belongs_one_faction()
	{
		$cypher= new Character('Cypher');

		$cypher->belongsAFaction([0]);

		$result= $cypher->getFaction();

		$this->assertEquals($result, ['Controlador']);
	}

	public function test_character_belongs_two_factions()
	{
		$cypher= new Character('Cypher');

		$cypher->belongsAFaction([0, 2]);

		$result= $cypher->getFaction();

		$this->assertEquals($result, ['Controlador', 'Centinela']);
	}

	public function test_character_leaves_a_faction(){

		$cypher= new Character('Cypher');

		$cypher->belongsAFaction([1, 3]);

		$cypher->leavesAFaction([1]);

		$result= $cypher->getFaction();

		$this->assertEquals($result, ['Duelista']);
	}

	public function test_character_are_allies(){

		$cypher= new Character('Cypher');
		$skye= new Character('Skye');

		$cypher->belongsAFaction([0,1,3]);
		$skye->belongsAFaction([3]);
		
		$cypher->isAnAlly($skye);

		$result= $cypher->getAlly();
		$this->assertEquals($result, true);
	}

	public function test_character_cannot_attack_allies(){

		$killjoy= new Character('Killjoy');
		$jett= new Character('Jett');

		$killjoy->belongsAFaction([0,1,3]);
		$jett->belongsAFaction([3]);

		$killjoy->isAnAlly($jett);

		$killjoy->attacks($killjoy, $jett);
		$result= $jett->getHealth();

		$this->assertEquals($result, 1000);
	}
	
	public function test_character_can_only_heal_allies(){

		$viper= new Character('Viper');
		$sage= new Character('Sage');

		$viper->belongsAFaction([0,3]);
		$sage->belongsAFaction([3]);

	
		$viper->isAnAlly($sage);
		$sage->setHealth(300);

		$viper->healingAllies($sage);
		$result= $sage->getHealth();

		$this->assertEquals($result, 700);
	}

	public function test_things_can_receibe_damage(){

		$omen= new Character('Omen');
		$box= new Box;

		$omen->attacks($box);

		$result= $box->getHealth();

		$this->assertEquals($result, 1900);
	}

	public function test_things_can_not_be_healed(){

		$reyna= new Character('Reyna');
		$box= new Box;

		$box->setHealth(1500);
		$reyna->healing($box);

		$result= $box->getHealth();
		$this->assertEquals($result, 1500);
	}

	public function test_things_are_neutral(){

		$box= new Box;

		$result= $box->getFaction();

		$this->assertEquals($result, "Neutral");

	}

	public function test_things_can_be_destroyed(){

		$sova= new Character('Sova');
		$glass= new Glass;

		$sova->attacks($glass);

		$result= $glass->thingIsDestroyed($glass);

		$this->assertEquals(isset($result), false);
	}
}