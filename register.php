<?php

ob_start();

require("DatabaseObject.php");
require("databaseVars.php");

$database = new DatabaseObject($host, $username, $password, $database);

if(!empty($_POST['register'])) {
    $username = $database->clean($_POST['username']);
    $password = $database->clean($_POST['password']);

    try { 
        // Username
        if(strlen($username) < 5) {
            throw new Exception('Username must be at least 5 characters!');
        }
        if(strlen($username) > 50){
            throw new Exception('Username nust be shorter than 50 characters!');
        }
        // Check if has any special characters
        if(!ctype_alnum($username)) {
            throw new Exception('Username must be only letters or numbers!');
        }

        // Password
        if(strlen($password) < 6) {
            throw new Exception('Password must be at least 6 characters!');
        }

        // Submit to database
        $password = md5($password);
        $database->query("INSERT INTO `users` (
            `username`,
            `password`,
            `level`,
            `exp`,
            `health`,
            `max_health`,
            `strength`,
            `intelligence`,
            `endurance`,
            `attacks`,
            `coins`
        )
        VALUES (
            '$username',
            '$password',
            '1',
            '0',
            '100',
            '100',
            '1',
            '1',
            '1',
            '',
            '0'
        )");

        if($database->affected_rows() > 0) {
            echo "Accont Created! <a href='./'>Login</a><br />";
        }

    } catch (Exception $e) {
        echo $e->getMessage();
    }
}
$output =  ob_get_clean();

require('templates/header.php');

echo "<p style='text-align: center;'>".$output."</p>";
?>
<div class='formContainer' style="width: 400px; margin-left:auto; margin-right:auto;">
    <form action='./register.php' method='POST'>
        Username: <input type='text' name='username' /><br />
        Password: <input type='password' name='password' /><br />
        <input type='submit' name='register' value='Register' />
    </form>
</div>

<?php require('templates/footer.php'); ?>