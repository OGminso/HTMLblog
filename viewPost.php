<?php

include 'inc/functions.php';
?><link rel="stylesheet" href="inc/css/core.css"><?php

session_start();

include 'header.php';

if (isset($_GET['post'])) {
    $postID = $_GET['post']; 
    

    $postInfo = mysqli_query($conn, "SELECT * FROM posts WHERE id='$postID'");
    if (mysqli_num_rows($postInfo) > 0) {
        while($postInfoData = mysqli_fetch_assoc($postInfo)) { 
            $id = $postInfoData['id'];
            $title = htmlspecialchars($postInfoData['title']);
            $body = $postInfoData['body'];
            $author = $postInfoData['userID'];
            $created = $postInfoData['created'];
            echo '<div class="container">';
            echo '<h1 class="title">'.htmlspecialchars_decode($title).'</h1>';
            echo '<p class="author">By '.getUsername($author).'</p>';
            echo '<p class="date">Created '.getTimeElapsed($created).'</p>';
            echo '<hr/>';
            echo '<div class="body">'.htmlspecialchars_decode($body).'</div>';
            echo '</div>';
            
        }
    } else {
        echo 'Post not found';
    }

} else {
    echo 'Post not found';
}
