<?php
header("Content-Type: application/json"); // Since we are sending a JSON response here (not an HTML document), set the MIME Type to application/json

$username = htmlentities($_POST["username"]);
$pswguess = htmlentities($_POST["password"]);

require 'connectDB.php';

// Use a prepared statement
$stmt = $mysqli->prepare("SELECT COUNT(*),username,saltedhash FROM user WHERE username=?");

// Bind the parameter
$stmt->bind_param('s', $username);
$stmt->execute();

// Bind the results
$stmt->bind_result($cnt, $user_id, $pwd_hash);
$stmt->fetch();
$stmt->close();
// Compare the submitted password to the actual password hash
if ($cnt == 1 && password_verify($pswguess, htmlentities($pwd_hash))) {
    // Login succeeded!

    ini_set("session.cookie_httponly", 1);

	session_start();

    $_SESSION['user']  = htmlentities($user_id);
    $_SESSION['token'] = htmlentities(bin2hex(openssl_random_pseudo_bytes(32)));
    echo json_encode(array(
        "success" => true,
        "token" => $_SESSION['token'],
    ));
    exit;
} else {
    // Login failed
    echo json_encode(array(
        "success" => false,
        "message" => "Incorrect Username or Password",
    ));
    exit;
}
?>
