<?php

/*
 User.php
 Class for managing user data
*/

class User {
    // Members/properties (variables)
    public $id;

    public $username;
    public $name;
    public $password;

    public $level;
    public $exp;

    public $health;
    public $max_health;

    public $strength;
    public $intelligence;
    public $endurance;

    public $attacks;

    public $coins;

    private $database;

    // Methods (functions)
    public function __construct($user_id, $database){
        $this->database = $database;
        $user_id = (int)$user_id; 
        $result = $this->database->query("SELECT * FROM `users` WHERE `id`='$user_id' LIMIT 1");
        if($this->database->num_rows($result) <1){
            throw new Exception("User does not exist!");
        }

        $user = $this->database->fetch($result);

        $this->id = $user['id'];

        $this->username = $user['username'];
        // Alias
        $this->name = $user['username'];
        $this->password = $user['password'];
    
        $this->level = $user['level'];
        $this->exp = $user['exp'];
    
        $this->health = $user['health'];
        $this->max_health = $user['max_health'];

        $this->coins = $user['coins'];
    
        $this->strength = $user['strength'];
        $this->intelligence = $user['intelligence'];
        $this->endurance = $user['endurance'];
    
        $this->attacks = array();

        if($user['attacks']) {
            $this->attacks = json_decode($user['attacks'], true);
        }
    }

    public function update() {
        $attacks = json_encode($this->attacks);

        $this->database->query("UPDATE `users` SET
            `level`='{$this->level}',
            `exp`='{$this->exp}',
            `health`='{$this->health}',
            `max_health`='{$this->max_health}',
            `coins`='{$this->coins}',
            `strength`='{$this->strength}',
            `intelligence`='{$this->intelligence}',
            `endurance`='{$this->endurance}',
            `attacks`='{$attacks}'
        
        WHERE `id`='{$this->id}' LIMIT 1");
    }
}


?>