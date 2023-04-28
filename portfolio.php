<?php
require "includes/database-connection.php";

function pdo(PDO $pdo, string $sql, array $arguments = null)
{
    if (!$arguments) {
        return $pdo->query($sql);
    }
    $statement = $pdo->prepare($sql);
    $statement->execute($arguments);
    return $statement;
}

function get_comments(PDO $pdo)
{
    $sql = "SELECT portfolio_comments.id, portfolio_comments.subject_id, portfolio_comments.comment, subject.name FROM portfolio_comments INNER JOIN subject ON portfolio_comments.subject_id=subject.id";
    // Returns portfolio comments
    return pdo($pdo, $sql)->fetchAll();
}

function add_comment(PDO $pdo, $subject_id, $comment)
{
    $sql = "INSERT INTO portfolio_comments (subject_id, comment) VALUES (:subject_id, :comment)";
    $arguments = ["subject_id" => $subject_id, "comment" => $comment];
    // Returns number of rows that were affected
    return pdo($pdo, $sql, $arguments)->rowCount();
}

function update_comment(PDO $pdo, $id, $comment)
{
    $sql = "UPDATE portfolio_comments SET comment = :comment WHERE id = :id";
    $arguments = ["comment" => $comment, "id" => $id];
    // Returns number of rows that were affected
    return pdo($pdo, $sql, $arguments)->rowCount();
}

function delete_comment(PDO $pdo, $id)
{
    $sql = "DELETE FROM portfolio_comments WHERE id = :id";
    $arguments = ["id" => $id];
    // Returns number of rows that were affected
    return pdo($pdo, $sql, $arguments)->rowCount();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST["add_comment"])) {
        $subject_id = filter_input(INPUT_POST, 'subject');
        $comment = filter_input(INPUT_POST, 'comment');
        add_comment($pdo, $subject_id, $comment);
    } elseif (isset($_POST["update_comment"])) {
        $id = $_POST["id"];
        $comment = filter_input(INPUT_POST, 'comment');
        update_comment($pdo, $id, $comment);
    } elseif (isset($_POST["delete_comment"])) {
        $id = $_POST["id"];
        delete_comment($pdo, $id);
    }
    // Prevent form resubmission
    header("Location: " . $_SERVER["PHP_SELF"]);
    exit();
}

$comments = get_comments($pdo);

session_start();
$page_views = $_SESSION["page_views"] ?? 0;
$page_views++;
$_SESSION["page_views"] = $page_views;

$message = "Page Views: $page_views"
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Drone Design</title>
    <link rel="stylesheet" type="text/css" href="styles/main.css" />
    <link rel="stylesheet" type="text/css" href="styles/custom-elements.css" />
    <script src="https://kit.fontawesome.com/626b14f90d.js" crossorigin="anonymous"></script>
</head>

<body>
    <nav id="navbar"></nav>

    <section id="portfolio"></section>

    <section class="portfolio-slideshow-container"></section>

    <div class="portfolio-comments-container ">
        <div>
            <h5><?= !$comments ? "No Comments" : "" ?></h5>
            <?php
            foreach ($comments as $comment) { ?>
                <div class="portfolio-comment">
                    <h4><?= $comment["name"] ?></h4>
                    <form action="" method="post">
                        <input type="hidden" name="id" value="<?= $comment["id"] ?>">

                        <textarea class="portfolio-comment-text" name="comment" maxlength="200"><?= htmlspecialchars($comment["comment"]); ?></textarea>

                        <input type="submit" name="update_comment" value="Update">
                        <input type="submit" name="delete_comment" value="Delete">
                    </form>
                </div>
            <?php } ?>
        </div>

        <div class="add-portfolio-comment">
            <h3>Add Comment</h3>
            <form action="" method="post">
                <select id="subject" name="subject">
                    <option value="1">General Comment</option>
                    <option value="2">Feedback</option>
                    <option value="3">Suggestion</option>
                </select>

                <textarea class="portfolio-comment-text" name="comment" maxlength="200"></textarea>

                <input type="submit" name="add_comment" value="Submit">
            </form>
        </div>
    </div>

    <div class="portfolio-view-counter">
        <p><?= $message ?></p>
    </div>

    <footer id="footer"></footer>

    <nav id="sidenav"></nav>

    <script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
    <script>
        Window.jQuery || document.write('<script src="scripts/jquery-3.6.3.js"><\/script>');
    </script>
    <script src="scripts/custom-elements.js"></script>
    <script src="scripts/portfolio.js"></script>
</body>

</html>