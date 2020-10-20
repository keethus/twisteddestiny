<?php

/*
 User.php
 Class for managing user data
*/

class User {
    // Members/properties (variables)
    public $id;

    public $username;
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
        $this->password = $user['password'];
    
        $this->level = $user['level'];
        $this->exp = $user['exp'];
    
        $this->health = $user['health'];
        $this->max_health = $user['max_health'];
    
        $this->strength = $user['strength'];
        $this->intelligence = $user['intelligence'];
        $this->endurance = $user['endurance'];
    
        $this->attacks = $user['attacks'];
    
        $this->coins = $user['coins'];
    }

}


?>