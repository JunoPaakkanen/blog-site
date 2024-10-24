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
    <link href="../css/comments.css" rel="stylesheet" type="text/css">
</head>

<body>

    <div class="center2">
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

            echo '<button class="back" type="cancel" onclick="history.back();">Takaisin</button>';

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

// Saadaan blogin id url:stä
$blog_id = $_GET['id'];
$blog_author = "";

// Haetaan tietty blogi
$sql = "SELECT sahkoposti, title, content, DATE_FORMAT(time, '%d.%m.%Y %H:%i:%s') AS formatted_time, DATE_FORMAT(time_edited, '%d.%m.%Y %H:%i:%s') as time_edited FROM blogi_table WHERE id = $blog_id";
$result = $conn->query($sql);


// Näytetään blogi
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $blog_author = $row['sahkoposti'];
    
    $sql_02 = "SELECT sahkoposti, kayttajanimi FROM kayttajat WHERE sahkoposti = ?";
    $stmt_02 = $conn->prepare($sql_02);
    $stmt_02->bind_param("s", $blog_author);
    $stmt_02->execute();
    $result_02 = $stmt_02->get_result();

    if ($result_02->num_rows > 0) {
        $row_02 = $result_02->fetch_assoc();
        echo "<h2 id='kirjoittanut'>Kirjoittanut: " . $row_02['kayttajanimi'] . "</h2>";
    }
    echo "<p id='julkaistu'>Julkaistu: " . $row['formatted_time'] . "</p>";
    if ($row['time_edited'] != NULL) {
        echo "<p id='muokattu'>Muokattu: " . $row['time_edited'] . "</p>";
    }
    echo "<h2>" . $row['title'] . "</h2>";
    echo "<p id='content'>" . $row['content'] . "</p>";
} else {
    echo "Blogia ei löydetty.";
}


if (isset($_SESSION["sahkoposti"])) {
    if ($blog_author === $_SESSION['sahkoposti']) {
        echo "<div id='muokkaus_napit'>
            <button class='submitbtn' id='muokkaa_blogia' onclick=\"window.location.href='edit_blog.php?id=" . $_GET['id'] . "'\">
                Muokkaa blogia
                </button>
            <!-- Tähän voisi tehdä ettei heti poista vaan käyttäjän pitäisi hyväksyä se erikseen. -->
            <form id='poista_blogi' action='../php/blogin_poisto.php' method='post'>
                <input type='hidden' name='id' value=$blog_id>
                <button class='deletebtn' id='poista_blogi'>
                    Poista blogi
                </button>
            </form>
        </div>";
        };
}

    // Suljetaan database yhteys
    $conn->close();
?>

<div class="comments">


<script>
const urlParams = new URLSearchParams(window.location.search);
const url_id = urlParams.get('id')
const comments_page_id = url_id; // This number should be unique on every page

fetch("../php/comments.php?page_id=" + comments_page_id)
    .then(response => response.text())
    .then(data => {
        document.querySelector(".comments").innerHTML = data;

        document.querySelectorAll(".comments .write_comment_btn, .comments .reply_comment_btn").forEach(element => {
            element.onclick = event => {
                event.preventDefault();
                document.querySelectorAll(".comments .write_comment").forEach(element => element.style.display = 'none');
                document.querySelector("div[data-comment-id='" + element.getAttribute("data-comment-id") + "']").style.display = 'block';
                document.querySelector("div[data-comment-id='" + element.getAttribute("data-comment-id") + "'] input[name='name']").focus();
            };
        });

        <?php if (isset($_SESSION["kayttajanimi"]) && $_SESSION["login_status"] == true) { ?>
            document.querySelectorAll(".comments .write_comment form").forEach(element => {
                element.onsubmit = event => {
                    event.preventDefault();
                    fetch("../php/comments.php?page_id=" + comments_page_id, {
                        method: 'POST',
                        body: new FormData(element)
                    }).then(response => response.text()).then(data => {
                        element.parentElement.innerHTML = data;
                    });
                };
            });
        <?php } ?>
    });


</script>
</div>

</body>
</html>