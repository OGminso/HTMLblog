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
            $title = htmlspecialchars_decode($postsData['title']);
            $body = htmlspecialchars_decode($postsData['body']);

            if (isset($_SESSION['userID'])) {
                $sessionUserID = $_SESSION['userID'];
                if ($puID == $sessionUserID) {

                    if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['submit'])) {
                        $ntitle = htmlspecialchars($_POST['title']);
                        $nbody = htmlspecialchars($_POST['body']);
                        $curTime = time();

                        if (empty($ntitle) || empty($nbody)) {
                            echo 'Must fill out all feilds.';
                        } else {
                            echo "pass";
                            $sql = "UPDATE `posts` SET title='$ntitle', body='$nbody', updated='$curTime' WHERE id='$pID'";
                            if (mysqli_query($conn, $sql)) {
                                echo "Post Updated.";
                                header('Location: index.php?Post=Updated');
                                exit();
                            } else {
                                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                            }
                        }
                    }
                    ?>

                    <form action="editPost.php?post=<?php echo $pID;?>" method="post">
                        <input type="text" name="title" value="<?php echo $title;?>" placeholder="Title">
                        <textarea name="body" id="body" cols="30" rows="10"><?php echo $body;?></textarea>
                        <input type="submit" name=submit value="Update Post">
                    </form>
                    <?php
                    
                } else {
                    header ('Location: index.phps');
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

echo '</div>';

?>

<script>
	CKEDITOR.replace('body');
</script>