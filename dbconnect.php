<?php 
    $db = new mysqli ('localhost', 'root', '', 'scoreboard');
    if ($db->connect_error) {
        die ("Conncetion error: ({$db->connect_errno}){$db->connect_error}");
    };
    
    
    
    //$req = "SELECT * FROM scoreboard WHERE player_id='$player_id'";
?>