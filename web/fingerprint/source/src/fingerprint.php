<?php

$mysqli = new mysqli("localhost", "user", "123456", "db");

/* проверка соединения */
if ($mysqli->connect_errno) {
    printf("connection failed: %s\n", $mysqli->connect_error);
    exit();
}

$v['user_agent'] = $mysqli->real_escape_string($_SERVER['HTTP_USER_AGENT']);
$v['referer'] = $_SERVER['HTTP_REFERER'];
$v['remote_addr'] = $_SERVER['REMOTE_ADDR'];
$v['fingerprint'] = md5(json_encode($v));

$data = json_encode($v);

$query = "SELECT id, info FROM browser_info WHERE fingerprint = '" . $v['fingerprint'] . "'";

$result = $mysqli->query($query);
if (!$result) {
    echo "Something gonna wrong!!! Db exception";
    die();
}

$dbData = $result->fetch_assoc();
if (!$dbData) {
    $query = "INSERT INTO browser_info(info, fingerprint) VALUES('$data', '" .  $v['fingerprint'] . "')";
    
    if (!$mysqli->query($query)) {
        echo "Something gonna wrong (remove after release)!!! Query exception: ";
        echo $query;
        die();
    }
    $fingerprint = $v['fingerprint'];
    $fingerprintId = $mysqli->insert_id;
} else {
    $fingerprint = $dbData['info'];
    $fingerprintId = $dbData['id'];
}

?>

<html>
<head>
    <title>Make your browser fingerprint (Site under construction)</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">

</head>
<body>
    <div class="container">
        <!-- Content here -->
        <h1>Make browser <a href="fingerprint.php">fingerprint</a>!</h1>
        <p><?= "Record #" . $fingerprintId . " " . $fingerprint ?></p>
    </div>
</body>
</html>