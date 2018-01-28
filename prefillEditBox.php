<?php
header("Content-Type: application/json"); // Since we are sending a JSON response here (not an HTML document), set the MIME Type to application/json
ini_set("session.cookie_httponly", 1);
session_start();

$eventid = htmlentities($_POST['eventid']); //id number of story or comment


require 'connectDB.php';

$stmt = $mysqli->prepare("SELECT COUNT(*), title,dateofevent,datetimeofevent,tag FROM events WHERE eventid=?");
if (!$stmt) {
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
}

$stmt->bind_param('i', $eventid);
$stmt->execute();

$stmt->bind_result($cnt, $title, $dateofevent, $datetimeofevent, $tag);
$stmt->fetch();

$stmt->close();
if ($cnt == 1) {
    echo json_encode(array(
        "success" => true,
        "title"           => htmlentities($title),
        "dateofevent"     => htmlentities($dateofevent),
        "datetimeofevent" => htmlentities($datetimeofevent),
        "tag"             => htmlentities($tag),
    ));
    exit;
} else {
    echo json_encode(array(
        "success" => false,
    ));
}
?>
