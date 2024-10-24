<?php
session_start();

try {
    $connection = new PDO("mysql:host=localhost;dbname=blogi", "root", "");
} catch (PDOException $e) {
    die("ERROR" . $e->getMessage());
}

$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$connection->exec("SET NAMES utf8");

$query = $connection->prepare("SELECT * FROM blogi_table");
$query->execute();


$id = $_POST['id']; 

while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
        $stmt_01 = $connection->prepare("DELETE FROM blogi_table WHERE ID = :id");
        $stmt_01->bindParam(':id', $id);
        $stmt_01->execute();

        
    }
    //Ohjataan takaisin blogivalikkoon.
    header('Location: ../html/blogilista.php');
    exit();
?>