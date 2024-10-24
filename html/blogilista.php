<?php
session_start();

if (isset($_SESSION["kayttajanimi"])) {
    if ($_SESSION['login_status'] == true) {
        $loginStatus = "Kirjautunut käyttäjällä: " . $_SESSION["kayttajanimi"];
    } else {
        $loginStatus = "Ei kirjauduttu";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Blogi lomake</title>
    <link rel="stylesheet" href="../css/bloglista.css">
</head>

<body>

<div class="main">
    <div class="overlay"></div>
    <div class="navbar">
        <ul>
                <li><a href="../html/etusivu.php">Etusivu</a></li>
                <li><a href="../html/blogilista.php">Blogit</a></li>


                <?php
                    if (isset($_SESSION["kayttajanimi"])) {
                        if ($_SESSION['login_status'] == true) {
                            echo '<li><a href="../html/profile.php">';
                            echo $loginStatus;
                            echo '</a></li>';
                            echo '<li><a href="../php/kirjaudu_ulos.php">Kirjaudu Ulos</a></li>';
                            echo '<li><a class="active" href="../html/blogilomakesivu.php">Kirjoita blogi</a></li>';
                        }
                    } else {
                        echo '<li><a href="../html/kirjautumissivu.php">Kirjaudu Sisään</a></li>';
                        echo '<li><a href="../html/rekisterointisivu.php">Rekisteröidy</a></li>';
                    }
            echo '</div>
            <div class="box">
            <div class="center">';


            
// Yhdistetään MySql databaseen
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "blogi";

$conn = new mysqli($servername, $username, $password, $dbname);

// Varmistetaan yhteys
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Haetaan kaikki blogit
$sql = "SELECT id, title FROM blogi_table";
$result = $conn->query($sql);

// Näytetään lista blogeista
echo "<h2>Julkaistut blogit</h2>";
echo "<ol>";

while ($row = $result->fetch_assoc()) {
    echo "<li><a href='view_blog.php?id=" . $row['id'] . "'>" . $row['title'] . "</a></li>";
}

echo "</ol>";

// Suljetaan database yhteys
$conn->close();
?>

</div>
</div>
</div>
</body>
</html> 
