<?php

session_start();

if (isset($_SESSION["kayttajanimi"])) {
    if ($_SESSION['login_status'] == true) {
        $loginStatus = "Kirjautunut käyttäjällä: " . $_SESSION["kayttajanimi"];
    } else {
        $loginStatus = "Ei kirjauduttu";
    }
}
// koodi on saatu täältä https://codeshack.io/commenting-system-php-mysql-ajax/

// Update the details below with your MySQL details
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'blogi';
try {
    $pdo = new PDO('mysql:host=' . $DATABASE_HOST . ';dbname=' . $DATABASE_NAME . ';charset=utf8', $DATABASE_USER, $DATABASE_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $exception) {
    // If there is an error with the connection, stop the script and display the error
    exit('Failed to connect to database: ' . $exception->getMessage());
}


// This function will populate the comments and comments replies using a loop
function show_comments($comments, $parent_id = -1) {
    $html = '';
    if ($parent_id != -1) {
        // If the comments are replies sort them by the "submit_date" column
        array_multisort(array_column($comments, 'submit_date'), SORT_ASC, $comments);
    }
    // Iterate the comments using the foreach loop
    foreach ($comments as $comment) {
        if ($comment['parent_id'] == $parent_id) {
            // Add the comment to the $html variable
            $html .= '<div class="comment center">
                        <div>
                            <h3 class="name">' . htmlspecialchars($comment['name'], ENT_QUOTES) . '</h3>
                        </div>
                        <p class="content">' . nl2br(htmlspecialchars($comment['content'], ENT_QUOTES)) . '</p>';
                        
            if (isset($_SESSION['kayttajanimi'])) {
                $html .= '<a class="reply_comment_btn" href="#" data-comment-id="' . $comment['id'] . '">Vastaa</a>
                        ' . show_write_comment_form($comment['id']);
            }
            
            $html .= '<div class="replies">
                        ' . show_comments($comments, $comment['id']) . '
                    </div>
                </div>';
        
        }
    }
    return $html;
}

// This function is the template for the write comment form
function show_write_comment_form($parent_id = -1) {
    $html = '
    <div class="write_comment" data-comment-id="' . $parent_id . '">
        <form>
            <input name="parent_id" type="hidden" value="' . $parent_id . '">
            <input name="name" type="text" value=' . $_SESSION["kayttajanimi"] . ' required readonly>
            <textarea name="content" placeholder="Kommentti..." required></textarea>
            <button type="submit">Submit Comment</button>
        </form>
    </div>
    ';
    return $html;
}



// Page ID needs to exist, this is used to determine which comments are for which page
if (isset($_GET['page_id'])) {
    // Check if the submitted form variables exist
    if (isset($_POST['name'], $_POST['content'])) {
        // POST variables exist, insert a new comment into the MySQL comments table (user submitted form)
        $stmt = $pdo->prepare('INSERT INTO comments (page_id, parent_id, name, content, submit_date) VALUES (?,?,?,?,NOW())');
        $stmt->execute([ $_GET['page_id'], $_POST['parent_id'], $_POST['name'], $_POST['content'] ]);
        exit('Kommenttisi on lähetetty.!');
    }
    // Get all comments by the Page ID ordered by the submit date
    $stmt = $pdo->prepare('SELECT * FROM comments WHERE page_id = ? ORDER BY submit_date DESC');
    $stmt->execute([ $_GET['page_id'] ]);
    $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // Get the total number of comments
    $stmt = $pdo->prepare('SELECT COUNT(*) AS total_comments FROM comments WHERE page_id = ?');
    $stmt->execute([ $_GET['page_id'] ]);
    $comments_info = $stmt->fetch(PDO::FETCH_ASSOC);
} else {
    exit('No page ID specified!');
}
?>

<div class="comment_header">
    <span class="total"><?=$comments_info['total_comments']?> kommentti(a)</span>
    <?php
    if (isset($_SESSION['kayttajanimi'])) {
    echo '<a href="#" class="write_comment_btn" data-comment-id="-1">Kirjoita kommentti</a>';
    } else {
        //Linkki ei toimi
        echo '<p class="write_comment_btn_denied">Kirjaudu sisään kommentoidaksesi.</p>';
    }
    ?>
</div>

<?=show_write_comment_form()?>

<?=show_comments($comments)?>
