<?php 
include 'inc/functions.php';
session_start();

?><link rel="stylesheet" href="inc/css/core.css"><?php

include 'header.php';



$posts = getPosts();

foreach ($posts as $post) { ?>
	<div class="container">
		<div class="post" style="margin-left: 0px;">
			<div>
				<h3><?php echo $post['title'] ?></h3>
				<?php 
				if (!$post['updated'] == 0) {
					?><span>Posted <?php echo getTimeElapsed($post["created"]);?> (edited) <?php echo getTimeElapsed($post["updated"]); ?></span><?php
				} else {
					?>
					<span>Posted <?php echo getTimeElapsed($post["created"]);?></span>
					<?php
				}
				?>
				<br>
				<span>By <a href="profile.php?id=<?php echo getUsername($post["userID"]); ?>"><?php echo getUsername($post["userID"]); ?></a></span>
				<br>
				<span><a href="viewPost.php?post=<?php echo $post['id'];?>">Read more...</a></span>
				<?php
                    $postUserID = $post['userID'];
                    if (isset($_SESSION['userID'])) {
                        $sessionUserID = $_SESSION['userID'];

                        if ($postUserID == $sessionUserID) {
							echo '<a href="editPost.php?post='.$post['id'].'">Edit</a>';
							echo ' <a href="deletePost.php?post='.$post['id'].'">Delete</a>';
                        }

                    }
                    

                    ?>
			</div>
		</div>
	</div>
<?php }
