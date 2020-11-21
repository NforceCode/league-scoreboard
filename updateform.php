<?php
    
    include 'player_array.php';
    session_start();
    $conn = mysqli_connect('localhost', 'root', '', 'scoreboard');
    /*if ($db->connect_error) {
        die ("Conncetion error: ({$db->connect_errno}){$db->connect_error}");
    };*/

    $name = $_POST['name'];
    $player_id = $_POST['player_id'];
    $rating = $_POST['rating'];
    $wins = $_POST['wins'];
    $losses = $_POST['losses'];
    $mtga_name = $_POST['mtga_name'];
    $point_for_win = $_POST['pointsForWin'];
    $_SESSION['pointsPerWin'] = $point_for_win;

    if (isset($_POST['changeData'])) {

        $resRating = 1;
        $resWins = 1;
        $resLosses = 1;
    
        if ($_POST['mode'] == "add") {
            foreach ($playersArray as $player) {
                if ($player_id == $player['player_id']) {
                    $resRating = intval($rating) * intval($point_for_win) + intval($player['rating']);
                    $resWins = intval($wins) + intval($player['wins']);
                    $resLosses = intval($losses) + intval($player['losses']);
                }
            }
            
            $updatequery = "UPDATE scoreboard SET rating='".$resRating."', wins='".$resWins."', losses='".$resLosses."', winrate=ROUND((wins/(wins+losses))*100.0, 0), mtga_name='".$mtga_name."' WHERE player_id='".$player_id."'";
        } else if ($_POST['mode'] == "replace") {
            $updatequery = "UPDATE scoreboard SET rating='". $rating . "', wins='" . $wins . "', losses='" . $losses . "', winrate=ROUND((wins/(wins+losses))*100.0, 0), mtga_name='" .$mtga_name. "'  WHERE player_id='" . $player_id . "'";
        }
    
        
        
        if($query = mysqli_query($conn,$updatequery) === FALSE) {
            die();
        } else {
            header('Location: index.php?name='.$name.'&playerId='.$player_id.'&rating='.$rating.'&wins='.$wins.'&losses='.$losses.'&pointsPerWin='.$point_for_win);
        }
    } else if (isset($_POST['addPlayer'])) {
        //if (!empty($name))
        $result_rating = intval($rating) * intval($point_for_win);
        $addquery = "INSERT INTO scoreboard (name, player_id, rating, wins, losses, winrate, mtga_name) VALUES ('".$name."', '".$player_id."', ".$result_rating.", ".$wins.", ".$losses.", ROUND((".$wins."/(".$wins."+".$losses."))*100.0, 0), '".$mtga_name."');";
        echo $addquery;
        if ($query = mysqli_query($conn, $addquery) === FALSE) {
            die("error");
        } else {
            header('Location: index.php?addplayer=success');
        }
    }
    

    
    /*if($updatestats = $db->query($query) === TRUE) {
        
    } else {
        die(mysql_error());
    }*/

    //winrate=ROUND(($wins/($wins+$losses))*100.0, 0)
    
?>