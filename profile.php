<?php
    include 'dbconnect.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php
            if(isset($_POST['username'])) {
                echo $_POST['username'] . "`s profile";
            } else {
                echo "Profile";
            }
        ?>
    </title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://unpkg.com/@saeris/typeface-beleren-bold@latest/index.css" rel="stylesheet" type="text/css" />
</head>
<body>
<main>
    <div class="centered profile-div">
        <div class="player-picker">
            <ul>
                <?php
                // гиперссылки профиля каждого игрока
                ?>
            </ul>
        </div>
        <div class="profile-window">
            <h2><?php echo "" ?></h2>

        </div>
    </div>
</main>
</body>
</html>