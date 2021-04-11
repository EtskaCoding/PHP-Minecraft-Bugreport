<?php

// By: EtskaCoding https://github.com/EtskaCoding

$webhookurl = "YOUR WEBHOOK URL"; //PASTE YOUR WEBHOOK URL HERE!

session_start();

define("RECAPTCHA_V3_SECRET_KEY", 'YOUR SECRET KEY');
  
$token = $_POST['token'];
$action = $_POST['action'];
  
// call curl to POST request
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,"https://www.google.com/recaptcha/api/siteverify");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array('secret' => RECAPTCHA_V3_SECRET_KEY, 'response' => $token)));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);
$arrResponse = json_decode($response, true);
  
// verify the response
if($arrResponse["success"] == '1' && $arrResponse["action"] == $action && $arrResponse["score"] >= 0.5) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $playername = $_POST['playername'];
        $dcname = $_POST['dcname'];
        $description = $_POST['description'];

        if (empty($playername)) {
            $_SESSION['msg'] = '<div class="alert">
            Player name is required!
            </div>';
        } elseif (empty($dcname)) {
            $_SESSION['msg'] = '<div class="alert">
            Discord name or email is required!
            </div>';
        } elseif (empty($description)) {
            $_SESSION['msg'] = '<div class="alert">
            Description is required!
            </div>';
        } else {
            send($playername, $dcname, $description);
            $_SESSION['msg'] = '<div class="success">
            Bug report sended succesfully! Staff contacts you soon.
            </div>';
        }


        header("Location: index.php");
        exit();
    } else {
    // spam submission
    // show error message
}

}

function send($playername, $dcname, $description) {
    global $webhookurl;
    $json_data = json_encode([
        // Username
        "username" => "BugReport",
        // Avatar URL.
        // Uncoment to replace image set in webhook
        "avatar_url" => "https://i.redd.it/b1b640z9b3c21.jpg",
        // Embeds Array
        "embeds" => [
            [
                // Embed Title
                "title" => "BugReport",
                // Embed Type
                "type" => "rich",
                // Embed left border color in HEX
                "color" => hexdec("3366ff"),
                // Footer
                "footer" => [
                    "text" => "By EtskaCoding",
                    "icon_url" => "https://etska.ml/etska.png"
                ],
                // Additional Fields array
                "fields" => [
                    [
                        "name" => "Player Name",
                        "value" => $playername,
                        "inline" => false
                    ],
                    [
                        "name" => "Discord or email",
                        "value" => $dcname,
                        "inline" => false
                    ],
                    [
                        "name" => "Description",
                        "value" => $description,
                        "inline" => false
                    ]
                // Etc..
                ]
            ]
        ]
            ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

    $ch = curl_init($webhookurl);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    $response = curl_exec($ch);
// If you need to debug, or find out why you can't send message uncomment line below, and execute script.
// echo $response;
    curl_close($ch);
}
