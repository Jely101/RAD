<!-- this code is designed to establish a connection to a databse based on the variables listed below -->
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "movies_db";

try {// Create connection
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "PDO Connected successfully";
} catch(PDOException $e) {
    echo "PDO Connection failed: " . $e->getMessage();
}
?>
