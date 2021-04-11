<?php
$webhookurl = "YOUR_WEBHOOK_URL";//PASTE YOUR WEBHOOK URL HERE!

session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $playername = $_POST['playername'];
    $dcname = $_POST['dcname'];
    $description = $_POST['description'];
    
    if (empty($playername)) {
        $_SESSION['msg'] = '<div class="alert">
            Player name is required!
            </div>';
    }
    
    
    elseif (empty($dcname)) {
        $_SESSION['msg'] = '<div class="alert">
            Discord name or email is required!
            </div>';
    }
    
    
    elseif (empty($description)) {
        $_SESSION['msg'] = '<div class="alert">
            Description is required!
            </div>';
    } else {
        
    }


    header("Location: index.php");
    exit();
}
