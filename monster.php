<?php 
/*
monster.php
Object for holding and managing monster data.
*/
class Monster {
    public $id;
    public $name;

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

        $result = $this->database->query("SELECT * FROM `monsters` WHERE `id`='$monster_id' LIMIT 1");
        if($this->database->num_rows($result) == 0){
            throw new Exception('Invalid monster!');
        }

        $monster = $this->database->fetch($result);

        $this->id = $monster['id'];
        $this->name = $monster['name'];

        $this->level = $monster['level'];

        $this->max_health = $monster['max_health'];
        if(!isset($_SESSION['monster_health'])) {
            $_SESSION['monster_health'] = $this->max_health;
        }
        $this->health = $_SESSION['monster_health'];

        $this->strength = $monster['strength'];
        $this->intelligence = $monster['intelligence'];
        $this->endurance = $monster['endurance'];

        $this->attacks = $monster['attacks'];
        $this->attacks = array();

        if($monster['attacks']) {
            $this->attacks = json_decode($monster['attacks'], true);
        }
    }

    public function update() {
        $_SESSION['monster_health'] = $this->health;
    }
}

?>