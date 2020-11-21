<?php 
     include_once 'player_array.php';
     session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scoreboard PHPed</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://unpkg.com/@saeris/typeface-beleren-bold@latest/index.css" rel="stylesheet" type="text/css" />
    
</head>
<body>

<main>
    <table class="centered" id="table">
        <thead>
            <tr>
                <td colspan="6"><a href="index.php"><img id="logo" alt="Dirigeable League" src="img/лого.png"></a></td>
            </tr>
            <tr class="belwe">
                    <td>Позиция</td>
                    <td>Имя</td>
                    <td>ID</td>
                    <td>Рейтинг</td>
                    <td>Партии / Win Rate</td>
                    <td>Ник в MTGA</td>
            </tr>
        </thead>

        <tbody class="score-table-body">
        
        <?php 
            $index = 1;
            
            // заполнение таблицы с данными
            foreach ($playersArray as $element) {
                echo "<tr class='inserted'>";
                    echo "<td class='beleren smallSize'>". $index ." </td>";
                    echo "<td id='pos". $index ."' class='belwe centered'>". $element['name']." </td>";
                    echo "<td class='beleren '>". $element['player_id']." </td>";
                    echo "<td class='beleren '>" .$element['rating']." MP</td>";
                    echo "<td class='beleren '><span class='green'>" .$element['wins']. "</span> | <span class='red'>" .$element['losses']. "</span> / ".$element['winrate']."% </td>";
                    if ($element['mtga_name'] != NULL) {
                        echo "<td class=' beleren'>" .$element['mtga_name']. "</td>";
                    } else {
                        echo "<td class=' beleren'>" ." — ". "</td>";
                    }
                    

                echo "</tr>";
                $index++;
            }
        
        ?> 
        
        </tbody>
    </table>
    
    <div class="div-control">
        <form class="controls" method="POST">
            <!--
                <input class="centered" type="button" value ="refresh" onclick="tableDraw()">
                <input id="inputId" name="inputId" class="centered" type="text" placeholder ="Player Id" autocomplete="off">
            -->
            <select id="playerName" name="playerName" class="centered select" onchange="this.form.submit()">
                <option value="" disabled <?php if (!isset($_POST['playerName'])) { echo 'selected';} ?> >--Choose player name--</option>
                <?php
                    foreach ($playersArray as $elem) {
                        echo '<option value="'.$elem['name'].'" ';
                        if(isset($_POST['playerName']) && $_POST['playerName'] == $elem['name']){
                            echo 'selected';
                        }
                        echo '>'.$elem['name']. '</option>';
                    };
                ?>
            </select>
            <!--
            <input class="centered" type="submit" value ="Submit Name" name="id">
            -->
            
        </form>
        <br>
        <br>
        <form method="POST"  action="updateform.php">
            <table>
                <tr class="inserted">
                    <td align="center">Имя</td>
                    <td align="center">ID</td>
                    <td align="center">Очки рейтинга<br>(само умножает при add)</td>
                    <td align="center">Победы</td>
                    <td align="center">Поражения</td>
                    <td align="center">Ник в MTGA</td>
                </tr>
                <tr class="inserted">
                    <?php                  
                        // заполнение таблицы со сменой данных
                        
                        if (isset($_POST['playerName']) ) {
                            $playerName = $_POST['playerName'];
                            foreach ($playersArray as $element) {

                                if ($playerName == $element['name']) {
                                    echo '<td><input id="name" name="name" class="centered" type="text" placeholder="Имя игрока" autocomplete="off"  value="'.$element['name'].'"></td>';
                                    echo '<td><input id="playerId" name="player_id" class="centered" type="text" placeholder="Id игрока" autocomplete="off"  value="'.$element['player_id'].'"></td>';
                                    echo '<td><input id="playerRating" name="rating" class="centered" type="number" placeholder="Рейтинг игрока" value="'.$element['rating'].'"></td>';
                                    echo '<td><input id="playerWins" name="wins" class="centered" type="number" placeholder="Победы игрока" value="'.$element['wins'].'"></td>';
                                    echo '<td><input id="playerLosses" name="losses" class="centered" type="number" placeholder="Поражения игрока" value="'.$element['losses'].'"></td>';
                                    echo '<td><input id="playerRating" name="mtga_name" class="centered" type="text" placeholder="Ник в MTGA" value="'.$element['mtga_name'].'" autocomplete="off"></td>';
                                    break;
                                }
                            }
                            
                        }
                        else if (empty($_POST['playerName'])){
                            echo '<td><input id="name" name="name" class="centered" type="text" placeholder="Имя игрока" autocomplete="off"></td>';
                            echo '<td><input id="playerId" name="player_id" class="centered" type="text" placeholder="Id игрока" autocomplete="off"></td>';
                            echo '<td><input id="playerRating" name="rating" class="centered" type="number" placeholder="Рейтинг игрока"></td>';
                            echo '<td><input id="playerWins" name="wins" class="centered" type="number" placeholder="Победы игрока"></td>';
                            echo '<td><input id="playerLosses" name="losses" class="centered" type="number" placeholder="Поражения игрока"></td>';
                            echo '<td><input id="playerName" name="mtga_name" class="centered" type="text" placeholder="Ник в MTGA" value="" autocomplete="off"></td>';
                        }
                        
                        
                    ?>
                </tr>
                <?php 
                    // Создает нижний столбец таблицы с управлением. Запоминат размер очков за победу с помощью сессии
                        
                        echo "<tr class='inserted centered'>";
                            
                            echo "<td> <button type='submit' name='addPlayer'>Добавить Игрока</button> </td>";
                            echo "<td colspan='4'>Режим: ";
                                echo "<select name='mode'>";
                                    echo "<option value='add'>add</option>";
                                    echo "<option value='replace'>replace</option>";
                                echo "</select>";
                                echo "<span> Количество рейтинга за одно очко: </span>";
                                echo "<input type='number' id='pointsForWin' name='pointsForWin' value='";
                                    if (isset($_SESSION['pointsPerWin'])) {
                                        $points = $_SESSION['pointsPerWin'];
                                        echo $points;
                                    }
                                    else {
                                        echo '3';
                                    }
                                echo "' >";
                            echo "</td>";
                            echo "<td><button type='submit' class='centered' name='changeData'>Изменить значения</button> </td>";
                        echo "</tr>";
                ?>
            </table>
            <br>
            
            
        </form>
    </div>
    <nav>
        <ul class="centered nav-ul">
            <li><a href="index.php">Scoreboard</a></li>
            <li><a href="profile.php">Profile</a></li>
        </ul>
    </nav>
</main>

</body>
</html>