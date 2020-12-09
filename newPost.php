<?php
include 'inc/functions.php';
include 'inc/config.php';

?><script src="inc/js/ckeditor/ckeditor.js"></script><?php

session_start();

if (!loggedIn()) {
    header ('Location: index.php');
    exit();
}

?><link rel="stylesheet" href="inc/css/core.css"><?php
include 'header.php';

echo '<div class="container">';

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['submit'])) {
    $title = htmlspecialchars($_POST['title']);
    $body = htmlspecialchars($_POST['body']);
    $user = $_SESSION['userID'];
    $curTime = time();

    if (empty($title) || empty($body)) {
        echo 'Must fill out all feilds.';
    } else {
        $sql = "INSERT INTO `posts` (`id`, `userID`, `title`, `body`, `created`, `updated`) VALUES (NULL, '$user', '$title', '$body', '$curTime', 0)";
        if (mysqli_query($conn, $sql)) {
            echo "New record created successfully";
            header('Location: index.php?Post=Created');
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }

}

?>

<form action="newPost.php" method="post">
    <input type="text" name="title" placeholder="Title">
    <textarea name="body" id="body" cols="30" rows="10"></textarea>
    <input type="submit" name=submit value="Create Post">

</form>
</div>
<script>
	CKEDITOR.replace('body');
</script>