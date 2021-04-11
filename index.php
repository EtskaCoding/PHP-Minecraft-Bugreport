<?php
session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>BugReport</title>
        <link rel="stylesheet" href="style.css"/>
    </head>
    <body>
        <?php
        if (isset($_SESSION['msg'])) {
            echo $_SESSION['msg'];
            unset($_SESSION['msg']);
        }
        ?>
        <form name="bugreport" action="send.php" method="POST" enctype="multipart/form-data">
            <input type="text" placeholder="Your player name" name="playername" id="playername">
            <input type="text" placeholder="Your discord name or email" name="dcname" id="dcname">
            <textarea id="description" name="description" rows="5" cols="10" style="resize: none;"></textarea>
            <input type="submit" value="Report!">
        </form>
    </body>
</html>
