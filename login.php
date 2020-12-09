<?php 
include 'inc/functions.php';
?><link rel="stylesheet" href="inc/css/core.css"><?php

session_start();

if (loggedIn()) {
    header ('Location: index.php');
    exit();
}

include 'header.php';

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['submit'])) {
    $pwd = trim($_POST['password']);
    $uid = trim($_POST['uid']);

    $errors = array();

    if ($query = mysqli_query($conn, "SELECT * FROM users WHERE (email='$uid') or (username='$uid')")) {
        if (mysqli_num_rows($query) > 0) {
            while ($row = mysqli_fetch_assoc($query)) { 
                $pwd_hashed = $row['password'];
                $pwd_peppered = hash_hmac("sha256", $pwd, $pepper);
                if (password_verify($pwd_peppered, $pwd_hashed)) {
                    //start session
                    $_SESSION['userID'] = $row['id'];
                    $_SESSION['username'] = $row['username'];

                    //rediret to home page
                    header('location: index.php');
                    //echo 'logged in';
                    
                    exit();

                } else {
                    //password incorrect
                    array_push($errors,'password incorrect');//error
                }
            }
        } else {
            //username/email invalid
            array_push($errors, 'invalid username/email');//error
            
        }
    }
}

?>
<div class="container"> 
<h2>Login</h2>
<?php
    //prints all errors if there are any
    if (!empty($registered)) {
        if ($registered == "success") {
            echo '<p>Registered</p>';
        }
    }

    if (!empty($errors)) {
        $max = sizeof($errors);
        for ($i=0; $i<$max; $i++) { 
            echo "<p>$errors[$i]</p>"; 
        }
    }
?>


<form action="login.php" method="post">
    <input class="loginfeild" type="text" name="uid" placeholder="Email / Username"/><br />
    <input class="pwdfeild" type="password" name="password" placeholder="Password"/><br />
    <input type="submit" name=submit value="Login">
    <p>Don't have an account? <a href="register.php">Register Now</a>.</p>
</form>

</div>