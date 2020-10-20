<?php
/*
monsterPages.php
functions for creating and editing monsters
*/
function createMonster(){
    global $database;
    global $player;
    global $self_link;

    if(!empty($_POST['create_monster'])) {
        try {
            $name = $database->clean($_POST['name']);
            $level = (int)$_POST['level'];
            $max_health = (int)$_POST['max_health'];
            $strength = (int)$_POST['strength'];
            $intelligence = (int)$_POST['intelligence'];
            $endurance = (int)$_POST['endurance'];
            
            if(!$name) {
                throw new Exception("Please enter a name!");
            }
            if($level < 1) {
                throw new Exception("Invalid level!");
            }
            if($max_health < 1) {
                throw new Exception("Invalid health!");
            }
            if($strength < 1) {
                throw new Exception("Invalid strength!");
            }
            if($intelligence < 1) {
                throw new Exception("Invalid intelligence!");
            }
            if($endurance < 1) {
                throw new Exception("Invalid endurance!");
            }

            $attacks = array();
            foreach($_POST['attacks'] as $id => $attack) {
                if(!is_int($id)) {
                    throw new Exception("Invalid attack as $id!");
                }

                $attacks[$id]['combat_text'] = $database->clean($attack['combat_text']);
                if(!$attacks[$id]['combat_text']) {
                    throw new Exception("Please enter combat text for attack $id!");
                }

                $attacks[$id]['type'] = $database->clean($attack['type']);
                if($attacks[$id]['type'] != 'physical' && $attacks[$id]['type'] != 'magic') {
                    throw new Exception("Invalid attack $id type!");
                }

                $attacks[$id]['power'] = (int)$attack['power'];
                if($attacks[$id]['power'] < 1) {
                    throw new Exception("Please enter attack $id power!!");
                }
            }

            // Insert new monster into database
            $attacks = json_encode($attacks);
            $database->query("INSERT INTO `monsters` (`name`, `level`, `max_health`, `strength`, `intelligence`, `endurance`, `attacks`)
                VALUES ('$name', '$level', '$max_health', '$strength', '$intelligence', '$endurance', '$attacks')");

            if($database->affected_rows() > 0 ){
                echo "Monster Created!<br />";
            }


            
        } 
        catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    // Display Form
    echo "<div class='formContainer' style='text-align: left;'>
        <form action='$self_link' method='POST'>
            <b><label style='width:9em;'>Name:</label></b><input type='text' name='name' /><br /><br />
            <b><label style='width:9em;'>Level:</label></b><input type='number' name='level' /><br /><br />
            <b><label style='width:9em;'>Health:</label></b><input type='number' name='max_health' /><br /><br />
            <b><label style='width:9em;'>Strength:</label></b><input type='number' name='strength' /><br />
            <b><label style='width:9em;'>Intelligence:</label></b><input type='number' name='intelligence' /><br />
            <b><label style='width:9em;'>Endurance:</label></b><input type='number' name='endurance' /><br /><br /><br /><br />
            <b><label style='width:9em;'>Attacks:</label></b>
                <p style='margin-left:10px;'>";
                    for($i=1; $i<=2; $i++){
                        echo "<b><label style='width:8em;'>Text:</label></b><input type='text' name='attacks[$i][combat_text]' /><br/>
                                <b><label style='width:8em;'>Type: </label></b><select name='attacks[$i][type]'>
                                    <option value='physical'>Physical</option>
                                    <option value='magic'>Magic</option>
                                </select><br /><br />
                                <b><label style='width:8em;'>Power: </label></b><input type='number' name='attacks[$i][power]' /> <br /> 
                                <br />";
                            
                    }
                echo "</p>
            <input type='submit' name='create_monster' value='Create Monster' />
        </form>
    </div>";
}

function editMonster(){

}

?>