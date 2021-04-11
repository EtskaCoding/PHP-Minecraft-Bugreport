<?php
session_start();
define('sitekey', 'YOUR SITE KEY');
?>
<!-- By: EtskaCoding https://github.com/EtskaCoding -->
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>BugReport</title>
        <link rel="stylesheet" href="style.css"/>
        <script
            src="https://code.jquery.com/jquery-3.4.1.min.js"
            integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
        crossorigin="anonymous"></script>

        <script src="https://www.google.com/recaptcha/api.js?render=<?php echo sitekey; ?>"></script>
    </head>
    <body>
        <?php
        if (isset($_SESSION['msg'])) {
            echo $_SESSION['msg'];
            unset($_SESSION['msg']);
        }
        ?>
        <form name="bugreport" id="bugreport" action="send.php" method="POST" enctype="multipart/form-data">
            <input type="text" placeholder="Your player name" name="playername" id="playername">
            <input type="text" placeholder="Your discord name or email" name="dcname" id="dcname">
            <textarea id="description" name="description" rows="5" cols="10" style="resize: none;"></textarea>
            <input type="submit" value="Report!">
        </form>
    </body>
    <script>
        $('#bugreport').submit(function (event) {
            event.preventDefault();
            var playername = $('#playername').val();
            var dcname = $('#dcname').val();
            var description = $('#description').val();

            grecaptcha.ready(function () {
                grecaptcha.execute('<?php echo sitekey; ?>', {action: 'bugreport'}).then(function (token) {
                    $('#bugreport').prepend('<input type="hidden" name="token" value="' + token + '">');
                    $('#bugreport').prepend('<input type="hidden" name="action" value="bugreport">');
                    $('#bugreport').unbind('submit').submit();
                });
                ;
            });
        });
    </script>
</html>
