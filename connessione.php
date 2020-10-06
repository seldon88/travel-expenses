<?php

define('DB_SERVER', 'dipendenti');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'viaggi');

try{
    $pdo = new PDO("mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME, DB_USERNAME, DB_PASSWORD);

    // Sets an attribute on the database handle.
    // PDO::ATTR_ERRMODE: Error reporting. - PDO::ERRMODE_EXCEPTION: Throw exceptions.
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e){
    die("ERROR: Could not connect. " . $e->getMessage());
}

?>
