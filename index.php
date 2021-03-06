<?php
/*
Twisted Destiny Text RPG

*/

session_start();

ob_start();

require("DatabaseObject.php");
require("databaseVars.php");

$database = new DatabaseObject($host, $username, $password, $database);


if(!isset($_SESSION['user_id']) && $_POST['login']) {
    $username = $database->clean($_POST['username']);
    $password = $database->clean($_POST['password']);

    $result = $database->query("SELECT `id`, `username`, `password` FROM `users` WHERE `username`='$username' LIMIT 1");
    try {
        if($database->num_rows($result) == 0) {
            throw new Exception('User does not exist!');
        }
        
        $user = $database->fetch($result);

        if(md5($password) != $user['password']) {
            throw new Exception('Invalid password!');
        }

        $_SESSION['user_id'] = $user['id'];

    } catch (Exception $e) {
        $e->getMessage();
    }
}
// If user is logged in, load data and select page.
if(isset($_SESSION['user_id'])) {
    require('user.php');
    $player = new User($_SESSION['user_id'], $database);

    $default_page = 'create_monster';
    $pages = array(
        'profile' => array(
            'name' => 'Profile',
            'file' => 'profile.php',
            'function' => 'profile',
        ),
        'arena' => array(
            'name' => 'Combat Arena',
            'file' => 'arena.php',
            'function' => 'arena',
        ),
        'attack_shop' => array(
            'name' => 'Attack Shop',
            'file' => 'attackShop.php',
            'function' => 'attackShop',
        ),
        'potion_shop' => array(
            'name' => 'Potion Shop',
            'file' => 'potionShop.php',
            'function' => 'potionShop',
        ),
        'create_monster' => array(
            'name' => 'Create Monster',
            'file' => 'monsterPages.php',
            'function' => 'createMonster',
        ),
        'create_attack' => array(
            'name' => 'Create Attack',
            'file' => 'attackPages.php',
            'function' => 'createAttack',
        ),
    );

    if(!empty($_GET['page'])) {
        $page = strtolower(trim($_GET['page']));

        if(isset($pages[$page])) {
            require($pages[$page]['file']);
            echo "<h1 class='pageTitle' style='padding-bottom: 30px; text-decoration:underline;'>" . $pages[$page]['name'] . "</h1>";
            $self_link = '?page=' . $page;
            $pages[$page]['function']();
        }
        else {
            require($pages[$default_page]['file']);
            echo "<h1 class='pageTitle' style='padding-bottom: 30px; text-decoration:underline;'>" . $pages[$default_page]['name'] . "</h1>";
            $self_link = '?page=' . $default_page;
            $pages[$default_page]['function']();
        }
    }
    else {
        require($pages[$default_page]['file']);
        echo "<h1 class='pageTitle' style='padding-bottom: 30px; text-decoration:underline;'>" . $pages[$default_page]['name'] . "</h1>";
        $self_link = '?page=' . $default_page;
        $pages[$default_page]['function']();
    }
}


/* DISPLAY */
$output = ob_get_clean();

require('templates/header.php');



if(isset($_SESSION['user_id'])) {
    echo $output;

}
else {
    echo "<p style='text-align: center;'>".$output."</p>
    <form action='./index.php' method='POST'>
    Username: <input type='text' name='username' /><br />
    Password: <input type='password' name='password' /><br />
    <input type='submit' name='login' value='Login' />
    </form>";
}
require('templates/footer.php');
?>
