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

//Tallennetaan lähetetyn blogin otsikko ja teksti muuttujiin.
$id = $_POST['id']; 
$_SESSION["updated_otsikko"] = $_POST["blogin_otsikko"];
$_SESSION["updated_teksti"] = $_POST["blogin_teksti"];

while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
        $moukkausaika = new DateTime($row['time_edited']);
        $stmt_01 = $connection->prepare("UPDATE blogi_table SET title = :title, content = :content, time_edited = CURRENT_TIMESTAMP(6) WHERE ID = :id");
        $stmt_01->execute([':title' => $_SESSION["updated_otsikko"], ':content' => $_SESSION["updated_teksti"], ':id' => $id]);

        //Päivitetään blogin otsikko ja teksti.
        $_SESSION['title'] = $_SESSION["updated_otsikko"];
        $_SESSION['content'] = $_SESSION["updated_teksti"];
        
    }
    header('Location: ../html/view_blog.php?id=' . $id);
    exit();
?>