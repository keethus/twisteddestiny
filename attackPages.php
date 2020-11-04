<?php
/*
    attackPages.php
    functions for creating and editing attacks
*/
function createAttack(){
    global $database;
    global $player;
    global $self_link;

    if(!empty($_POST['create_attack'])) {
        try {
            $name = $database->clean($_POST['name']);
            $combat_text = $database->clean($_POST['combat_text']);
            $type = $database->clean($_POST['type']);
            $power = (int)$_POST['power'];
            $purchase_cost = (int)$_POST['purchase_cost'];
            
            if(!$name) {
                throw new Exception("Please enter a name!");
            }
            if(strlen($name) > 50) {
                throw new Exception("Name must be less than 50 characters!");
            }

            if(!$combat_text) {
                throw new Exception("Please enter a name!");
            }
            if(strlen($combat_text) > 500) {
                throw new Exception("Combat Text must be less than 500 characters!");
            }

            if($power < 1) {
                throw new Exception("Invalid power!");
            }
            if($purchase_cost < 1) {
                throw new Exception("Invalid purchase cost!");
            }



            // Insert new attack into database
            $database->query("INSERT INTO `attacks` (`name`, `combat_text`, `type`, `power`, `purchase_cost`)
                VALUES ('$name', '$combat_text', '$type', '$power', '$purchase_cost')");

            if($database->affected_rows() > 0 ){
                echo "Attack Created!<br />";
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
            <b><label style='width:9em;'>Combat Text:</label></b><input type='text' name='combat_text' /><br />
            <b><label style='width:9em;'>Type:</label>
            <select name='type'>
                <option value='melee'>Physical</option>
                <option value='magic'>Magic</option>
            </select><br />
            <b><label style='width:9em;'>Power:</label></b><input type='number' name='power' /><br />
            <b><label style='width:9em;'>Purchase Cost:</label></b><input type='number' name='purchase_cost' /><br />
            <input type='submit' name='create_attack' value='Create Attack' />
        </form>
    </div>";
}

function editAttack(){

}

?>