<?php

/* potionShop.php
    Shop for purchasing potions

*/

function potionShop() {
    global $database;
    global $player;
    global $self_link;

    $healing = array(
        'small' => array(
            'cost' => 5,
            'health' => 25,
        ),
        'medium' => array(
            'cost' => 25,
            'health' => 75,
        ),
        'large' => array(
            'cost' => 55,
            'health' => 150,
        ),
    );

    //Display
    echo "<div class='formContainer ' style='text-align:left;width:400px;'>
        <form action='$self_link' method='POST'>";
            foreach($healing as $name => $potion) {
                echo "<label>".ucwords($name)." health potion ({$potion['cost']} coins, {$potion['health']} health) </label>
                <input type='submit' name='$name' value='Purchase' /><br /><br />";
            }

        echo "</form>
    </div>";
}