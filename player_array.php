<?php 
    /*$db = new mysqli ('localhost', 'root', '', 'scoreboard');
    if ($db->connect_error) {
        die ("Conncetion error: ({$db->connect_errno}){$db->connect_error}");
    };
    
    $sql = "SELECT * FROM scoreboard ORDER BY rating DESC";
    $result = $db->query($sql);
    
    //$req = "SELECT * FROM scoreboard WHERE player_id='$player_id'";
    */
    include 'dbconnect.php';
    //include 'updateform.php';

    $sql = "SELECT * FROM scoreboard ORDER BY rating DESC, winrate DESC";
    $result = $db->query($sql);

    $playersArray = array();

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $playersArray[] = $row;
        }
    }
?>