<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>twisted destiny</title>
<!--- TITLE ICON -->
<link rel="shortcut icon" href="" />
<link href='https://fonts.googleapis.com/css?family=Roboto Mono' rel='stylesheet'>

<!--- LINK CSS FILE -->
<link rel="stylesheet" type="text/css" href="style/style.css"/>

</head>
<body>

    <!--    navbar starts here      -->
    <?php
    if(isset($_SESSION['user_id'])) {
        echo '<nav>
                <span id="brand">
                <a href="keethus.github.io/twisteddestiny">twisted destiny</a>
                </span>
                    <ul id="menu">
                        <li><a href="?page=arena">arena<span>.</span></a></li>
                        <li><a href="?page=profile">profile<span>.</span></a></li>
                        <li><a href="?page=attack_shop">buy attacks<span>.</span></a></li>
                        <li><a href="?page=potion_shop">buy potions<span>.</span></a></li>
                        <li><a href="?page=create_monster">create monster<span>.</span></a></li>
                        <li><a href="?page=create_attack">create attack<span>.</span></a></li>
                    </ul>
                </nav>';
    
    }
    else{
        echo '<nav>
                <span id="brand">
                <a href="keethus.github.io/twisteddestiny">twisted destiny</a>
                </span>
                    <ul id="menu">
                        <li><a href="register.php">login<span>.</span></a></li>     
                        <li><a href="register.php">register<span>.</span></a></li>                        
                    </ul>
                </nav>';
    }
    ?>
        <div id='content'>
          