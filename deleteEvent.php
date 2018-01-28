<?php
header("Content-Type: application/json"); // Since we are sending a JSON response here (not an HTML document), set the MIME Type to application/json
ini_set("session.cookie_httponly", 1);
session_start();
if(!hash_equals($_SESSION['token'], htmlentities($_POST['token']))){
    die("Request forgery detected");
  }
// variables needed from the news site, can be passed via POST or SESSION, whichever is more convenient
if (!isset($_SESSION['user'])) {
  echo json_encode(array(
    "success"=>false,
  ));
  exit;
}
else {
$username = $_SESSION['user'];


require 'connectDB.php';
$stmt = $mysqli->prepare("DELETE FROM events WHERE eventid=?");
    if(!$stmt){
      printf("Query Prep Failed: %s\n", $mysqli->error);
      exit;
    }

    $stmt->bind_param('i',htmlentities($_POST['id']));

    $stmt->execute();

    $stmt->close();
    echo json_encode(array(
        "success" => true,
    ));
  }
?>
