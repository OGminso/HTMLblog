<?php

include 'inc/functions.php';
session_start();
?><link rel="stylesheet" href="inc/css/core.css"><?php
include 'header.php';

echo '<div class="container">';

if (isset($_GET['id'])) {
    $usernID = $_GET['id']; 
    
    $userInfo = mysqli_query($conn, "SELECT * FROM users WHERE username='$usernID'");
    if (mysqli_num_rows($userInfo) > 0) {
        while($userInfoData = mysqli_fetch_assoc($userInfo)) { 
            $userID = $userInfoData['id'];
            echo '<h1 class="profileTittle">'.$userInfoData['username'].'</h1>';

            echo '<p class="profilesubtitle">Posts</p>';

            $userPostsInfo = mysqli_query($conn, "SELECT * FROM posts WHERE userID='$userID' ORDER BY created DESC");
            if (mysqli_num_rows($userPostsInfo) > 0) {
                while($userPostsData = mysqli_fetch_assoc($userPostsInfo)) { 
?>
                <div class="profileItem">
                    <h1><?php echo $userPostsData['title'] ?></h1>
                    <?php
                    if (!$userPostsData['updated'] == 0) {
					    ?><span>Posted <?php echo getTimeElapsed($userPostsData["created"]);?> (edited) <?php echo getTimeElapsed($userPostsData["updated"]); ?></span><?php
                    } else { ?>
                        <span>Posted <?php echo getTimeElapsed($userPostsData["created"]);?></span>
                    <?php
                    }
                    ?>
                   
                    <span>By <a href="profile.php?id=<?php echo getUsername($userPostsData["userID"]); ?>"><?php echo getUsername($userPostsData["userID"]); ?></a></span>
                    <br>
                    <span><a href="viewPost.php?post=<?php echo $userPostsData['id'];?>">Read more...</a></span>
                    <?php
                    $postUserID = $userPostsData['userID'];
                    if (isset($_SESSION['userID'])) {
                        $sessionUserID = $_SESSION['userID'];

                        if ($postUserID == $sessionUserID) {
                            echo '<a href="editPost.php?post='.$userPostsData['id'].'">Edit</a>';
                            echo ' <a href="deletePost.php?post='.$post['id'].'">Delete</a>';
                        }

                    }
                    

                    ?>
                </div>
<?php
                }
            }


        }

    } else {
        echo 'user not found.';
    }
    
} else {
    echo 'user not found.';
}


echo '</div>';