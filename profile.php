<?php
/*
    User profile, display stats, health, coins etc.
*/

function profile() {
    global $database;
    global $player;

    echo "<b><label style='width:9em;'>Username:</label></b> {$player->username}<br /><br />
    <b><label style='width:9em;'>Level:</label></b> {$player->level}<br />
    <b><label style='width:9em;'>Experience:</label></b> {$player->exp}<br /><br />
    <b><label style='width:9em;'>Health:</label></b> {$player->health} / {$player->max_health}<br /><br />
    <b><label style='width:9em;'>Coins:</label></b> {$player->coins}<br /><br />
    <b><label style='width:9em;'>Strength:</label></b> {$player->strength}<br />
    <b><label style='width:9em;'>Intelligence:</label></b> {$player->intelligence}<br />
    <b><label style='width:9em;'>Endurance:</label></b> {$player->endurance}<br /><br />";

}


?>