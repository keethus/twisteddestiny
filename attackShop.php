<?php


/**
 * attackShop.php
 * Shop for buying weapons and spells.
 */

 function attackShop() {
     global $database;
     global $player;
     global $self_link;


    // Fetch attack data
    $result = $database->query("SELECT * FROM `attacks`");
    $attacks = array();
    while($attack = $database->fetch($result)) {
        $attacks[$attack['id']] = $attack;
    }

    if(!empty($_POST['buy'])) {
        $attack_id = (int)$_POST['attack_id'];

        try{
            if(!isset($attacks[$attack_id])) {
                throw new Exception("Invalid attack!");
            }

            if(isset($player->attacks[$attack_id])) {
                throw new Exception("You already have this attack!");
            }

            if($player->coins < $attacks[$attack_id]['purchase_cost']) {
                throw new Exception("You dont have enough coins!");
            }

            // Purchase technique
            $player->coins -= $attacks[$attack_id]['purchase_cost'];
            $player->attacks[$attack_id] = array();
            $player->update();

            echo "Attack purchased! <br />";
        } catch (Exception $e) {
            echo $e->getMessage();
        }

     }

     // Display form
     echo "<table class='attackShop' style='text-align:left;'>
            <tr>
                <th style='width:30%; padding-right:100px;;'>NAME</th>
                <th style='width:20%; padding-right:100px;'>TYPE</th>
                <th style='width:35%; padding-right:50px;'>PRICE</th>
                <th style='width:15%; padding-right:50px;'>&nbsp;</th>
            </tr>";
            foreach($attacks as $id => $attack) {
                if(isset($player->attacks[$id])){
                    continue;
                }
                echo " <tr>
                    <td>{$attack['name']}</td>
                    <td>{$attack['type']}</td>
                    <td>{$attack['purchase_cost']}</td>
                    <td>
                        <form action='$self_link' method='POST'>
                            <input type='hidden' name='attack_id' value='$id' />
                            <input type='submit' name='buy' value='Buy' />
                        </form>
                    </td>
                </tr>";
            }

        echo "</table>";
 }