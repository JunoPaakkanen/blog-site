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
    <link rel="stylesheet" href="../css/blogilomake.css">
</head>

<body>

    <div class="moi">
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

                ?>
            </ul>
        </div>

        <form action="../html/insert.php" method="post">
    <div class="input-group">
        <textarea id="message" name="content" rows="8" required maxlength="10000"></textarea>
        <label for="message">Sinun blogisi</label>
        <input type="text" id="blog_title" name="title" required maxlength="50" placeholder="Kirjoita blogisi nimi" maxlength="100">
    </div>
    <button type="submit" value="Submit" name="publish">LÄHETÄ</button>
</form>

</div>

</body>
</html>