<html>
<head>
    <title>Bender</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
</head>
<body>
    <div class="container">
    
        <?php
        if ($_SERVER['HTTP_USER_AGENT'] == 'Bender') {
            ?>
            <img src="static/bender_appl.gif" />
            <?php
            echo "<h1>ITF{2_be333eee3eee333e333eee333ee3ee3e3e3e3ee3r}</h1>";
        } else {
            ?>
            <img src="static/bender_kill.gif"/>
            <?php
        }
        ?>
    </div>
</body>
</html>