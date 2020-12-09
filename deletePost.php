<?php

include 'inc/functions.php';
session_start();
?><link rel="stylesheet" href="inc/css/core.css"><?php
?><script src="inc/js/ckeditor/ckeditor.js"></script><?php

include 'header.php';

if (!loggedIn()) {
    header ('Location: index.php');
    exit();
}

echo '<div class="container">';

if (isset($_GET['post'])) {
    $postID = $_GET['post'];

    $postsInfo = mysqli_query($conn, "SELECT * FROM posts WHERE id='$postID' ORDER BY created DESC");
    if (mysqli_num_rows($postsInfo) > 0) {
        while($postsData = mysqli_fetch_assoc($postsInfo)) { 
            $pID = $postsData['id'];
            $puID = $postsData['userID']; 

            if (isset($_SESSION['userID'])) {
                $sessionUserID = $_SESSION['userID'];
                if ($puID == $sessionUserID) {

                    $sql = "DELETE FROM `posts` WHERE id='$pID'";
                    if (mysqli_query($conn, $sql)) {
                        echo "Post Deleted";
                        header('Location: index.php?Post=Deleted');
                        exit();
                    } else {
                        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                    }

                } else {
                    echo 'not your post';
                    header ('Location: index.php');
                    exit();
                }
            }
        }

    } else {
        echo 'post not found';
        header ('Location: index.php');
        exit();
    }

} else {
    echo 'post not found';
    header ('Location: index.php');
    exit();
}