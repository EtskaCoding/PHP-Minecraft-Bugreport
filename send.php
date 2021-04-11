<?php

session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $playername = $_POST['playername'];
    if (empty($playername)) {
        
    }

    $_SESSION['msg'] = "Hello";
    header("Location: index.php");
    exit();
}
