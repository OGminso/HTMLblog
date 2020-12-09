<?php
if (loggedIn()) {
    echo '
    <ul class="nav">
        <li class="navitem navtitle"><a href="index.php">Blog</a></li>
        <li class="navitem"><a href="index.php">Home</a></li>
        <li class="navitem"><a href="newPost.php">Create Post</a></li>
        <li class="navitem navRight"><a href="logout.php">Logout</a></li>
    </ul>
    ';
} else {
    echo '
    <ul class="nav">
        <li class="navitem navtitle"><a href="index.php">Blog</a></li>
        <li class="navitem"><a href="index.php">Home</a></li>
        <li class="navitem navRight"><a href="login.php">Login</a></li>
    </ul>
    ';
    
}

include 'footer.php';




