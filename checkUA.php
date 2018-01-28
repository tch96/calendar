<?php
// Web security:
// Persistent XSS occurs when a web site stores input in a database and displays it to victims later
// Reflected XSS is when a web page accepts input and then displays it immediately as output (without the database intermediate).
// htmlentities() and its charset-dependent cousin htmlspecialchars() escape output that is safe for HTML. THEY DO NOT RETURN STRINGS THAT ARE SAFE FOR INCLUSION IN JAVASCRIPT OR CSS
// tokens when submitting forms
ini_set("session.cookie_httponly", 1);
session_start();

$previous_ua = @$_SESSION['useragent'];
$current_ua = $_SERVER['HTTP_USER_AGENT'];

if(isset($_SESSION['useragent']) && $previous_ua !== $current_ua){
	die("Session hijack detected");
}else{
	$_SESSION['useragent'] = $current_ua;
}

?>
