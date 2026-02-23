<?php
// Start the session only if it hasn't been started already
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Define constants only if they aren't already defined
if (!defined('SITEURL')) {
    define('SITEURL', 'http://localhost/food-order/');
}
if (!defined('LOCALHOST')) {
    define('LOCALHOST', 'localhost');
}
if (!defined('DB_USERNAME')) {
    define('DB_USERNAME', 'root');
}
if (!defined('DB_PASSWORD')) {
    define('DB_PASSWORD', '1234');
}
if (!defined('DB_NAME')) {
    define('DB_NAME', 'food-order');
}
if (!defined('DB_PORT')) {
    define('DB_PORT', '3307');
}

// Database connection
$conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME, DB_PORT);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

?>
