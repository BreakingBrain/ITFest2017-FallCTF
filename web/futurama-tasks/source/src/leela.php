<?php

if ($_POST['name'] == 'Leela' && $_POST['secret'] == 'secret') {
    echo 'ITF{EasYP@ssssw0rd}';
}

?>
<html>
<head>
    <title>Leela</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
</head>
<body>
    <div class="container">
            <img src="static/leela_eye.gif"/>
            <div class="col-lg-4 col-lg-offset-4">
                <div class="input-group">
                    <form action="" method="post">
                    <!--<input id="name" type="password" class="form-control" />  -->
                    <input id="secret" type="password" class="form-control" /> 
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="submit">Get info!</button>
                    </span>
                    </form>
                </div><!-- /input-group -->
            </div><!-- /.col-lg-4 -->
    </div>
</body>
</html>
