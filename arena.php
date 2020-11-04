<?php 

/*
    arena.php
    arena for fighting monsters
*/

function arena() {
    global $database;
    global $player;
    global $self_link;
    require('monster.php');

    // Process monster choice
    if(empty($_SESSION['monster_id']) && !empty($_POST['fight'])){
        $monster_id = (int)$_POST['monster_id'];

        try {   
            $monster = new Monster($monster_id, $database);

            $_SESSION['monster_id'] = $monster_id;

        } catch (Exception $e) {
            echo $e->getMessage();
        }
        

    }

    // Fight opponent
    if(isset($_SESSION['monster_id'])){
        if(!isset($monster)){
            $monster = new Monster($_SESSION['monster_id'], $database);
        }
        $winner = battle($player, $monster);

        if($winner) {
            if($winner == 'player') {
                $coin_gain = 10 + ($monster->level * 5);
                $player->coins += $coin_gain;
                $player->update();

                echo "<div class='center'>
                    You gain {$coin_gain} coins!
                    </div>";
            }
            else if($winner == 'opponent'){
                echo "<div class='center'>
                    You gain {$coin_gain} coins!
                    </div>";
            }
            
            unset($_SESSION['monster_id']);
            unset($_SESSION['monster_health']);
        }
    }

    // Display select form
    else {
        $result = $database->query("SELECT `id`, `name`, `level` FROM `monsters`");
        echo "<div class='formContainer centerDiv' style='width:350px;'>
                <form action='$self_link' method='POST'>";
                    while($monster = $database->fetch($result)) {
                        echo "<input type='radio' name='monster_id' value='{$monster['id']}' />".$monster['name']."<br />";
                    }
                    echo "<input type='submit' name='fight' value='Fight' />
                </form>
            </div>";
    }


}

function battle($player, $opponent) {
    global $database;
    global $self_link;

    // Fetch attack data
    $result = $database->query("SELECT * FROM `attacks`");
    $attacks = array();
    while($attack = $database->fetch($result)) {
        $attacks[$attack['id']] = $attack;
    }

    $winner = false;
    $combat_display = '';
    if(!empty($_POST['attack'])) {
        $attack_id = (int)$_POST['attack_id'];

        try{
            if(!isset($attacks[$attack_id])) {
                throw new Exception("Invalid attack!");
            }
            
            if(!isset($player->attacks[$attack_id])) {
                throw new Exception("Invalid attack!");
            }

            $attack = $attacks[$attack_id];

            // Run turn

            // Calculate player damage.
            $player_damage = $attack['power'];
            if($attack['type'] == 'physical') {
                $player_damage *= 10 + $player->strength;
            }
            else if($attack['type'] == 'magic') {
                $player_damage *= 10 + $player->intelligence;
            }

            // Randomness
            $player_damage *= mt_rand(4,5);
            
            $player_damage = round($player_damage / (1 + $opponent->endurance), 2);

            // Set combat text.
            $combat_display .= $player->name.' '.$attack['combat_text'].'<br />'.
                $player->name.' deals '.$player_damage.' damage';

            // Calc Opponent damage
            $attack = $opponent->attacks[array_rand($opponent->attacks)];

            $opponent_damage = $attack['power'];
            if($attack['type'] == 'physical') {
                $opponent_damage *= 2 + $opponent->strength;
            }
            else if($attack['type'] == 'magic') {
                $opponent_damage *= 2 + $opponent->intelligence;
            }
            // Randomness
            $opponent_damage *= mt_rand(3,4);

            $opponent_damage = round($opponent_damage / (1 + $player->endurance), 2);

            // Set combat text.
            $combat_display .= '<br/><br/>'.$opponent->name.' '.$attack['combat_text'].'<br />'.
                $opponent->name.' deals '.$opponent_damage.' damage';


            // Apply damage
            $opponent->health -= $player_damage;
            if($opponent->health >= 0) {
                $player->health -= $opponent_damage;
            }

            // Check for winner
            if($opponent->health <= 0) {
                $opponent->health = 0;
                $winner = 'player';
                $combat_display .= '<br />You win!';
            }
            else if($player->health <= 0) {
                $player->health = 100;
                $winner = 'opponent';
                $combat_display .= "<br />{$opponent->name} won.";
            }

            // Update data
            $player->update();
            $opponent->update();   
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }


    // Display
    echo "<table style='width:800px; margin-left:auto; margin-right:auto;'>
        <tr>
            <th style='width:50%; text-align:left;'><h2>$player->name</h2></th>

            <th style='width:50%; text-align:right;'><h2>$opponent->name</h2></th>
        </tr>
        <tr>
            <td style='width:50%; text-align:left;' class='center'>$player->health / $player->max_health</td>
            <td style='width:50%; text-align:right;' class='center'>$opponent->health / $opponent->max_health</td>
        </tr>";
        // Attack Text
        if($combat_display) {
            echo "<tr>
                <td colspan='3' style='text-align:center; height:200px;'>".$combat_display."<td>
            </tr>";
        }

        // Move prompt
        echo "<tr style='text-align:center; height:200px;'><td colspan='3'>";
        if(is_array($player->attacks)) {
            echo "<form action='$self_link' method='POST'>";
            foreach($player->attacks as $id => $attack) {
                echo "<input type='radio' name='attack_id' value='$id' />".$attacks[$id]['name']."<br />";
            }
            echo "<input type='submit' name='attack' value='Attack' />
            </form>";

        } else {
            unset($_SESSION['monster_id']);
            unset($_SESSION['monster_health']);
        }
        echo "</td></tr>";

    echo "</table>";
    
    return $winner;

    
}

?>