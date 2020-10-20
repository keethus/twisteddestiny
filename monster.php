<?php 
/*
monster.php
Object for holding and managing monster data.
*/
class Monster {
    public $id;

    public $level;

    public $max_health;

    public $strength;
    public $intelligence;
    public $endurance;

    public $attacks;

    private $database;

    public function __construct($monster_id, $database) {
        $this->database = $database;
        $monster_id = (int)$monster_id;

        $result = $this->database->query("SELECT * FROM `monsters` WHERE `monster_id`='$monster_id' LIMIT 1");
        if($this->database->num_rows($result) == 0){
            throw new Exception('Invalid monster!');
        }

        $monster = $this->database->fetch($result);

        $this->id = $monster['id'];
        
        $this->level = $monster['level'];

        $this->max_health = $monster['max_health'];

        $this->strength = $monster['strength'];
        $this->intelligence = $monster['intelligence'];
        $this->endurance = $monster['endurance'];

        $this->attacks = $monster['attacks'];
    }
}

?>