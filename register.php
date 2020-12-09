<?php
include 'inc/functions.php';

session_start();

?><link rel="stylesheet" href="inc/css/core.css"><?php


if (loggedIn()) {
    header ('Location: index.php');
    exit();
}

include 'header.php';


if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['submit'])) {
    $uid = trim($_POST['username']);
    $email = trim($_POST['email']);
    $pwd = trim($_POST['password']);
    $rpwd = trim($_POST['repeatpassword']);

    $errors = array();

    //if password is shorter than 6 characters
    if (strlen($pwd) < 6 || strlen($rpwd) < 6 ) {
        array_push($errors,"Password must be longer than 6 characters.");
    }
    //passwords do not match
    if ($pwd != $rpwd) {
        array_push($errors,"Passwords do not match.");
    }
    //checks if email is already in the system
    if ($equery = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'")) {
        if (mysqli_num_rows($equery)>0) {
            array_push($errors,"Email is already registered.");
        }
    }
    //checks if username is already in the system
    if ($equery = mysqli_query($conn, "SELECT * FROM users WHERE username='$uid'")) {
        if (mysqli_num_rows($equery)>0) {
            array_push($errors,"Username is already in use.");
        }
    }
    //checls if all feilds are empty
    if (empty($uid) || empty($email) || empty($pwd) || empty($rpwd)) {
        array_push($errors,"All feilds must be filled out.");
    }

    //if no errors then register user
    if (empty($errors)) {
        $pwd_hashed = encyrptPassword($pwd);
        $date = date('Y-m-d H:i:s');
        //inserts regestration into database
        mysqli_query($conn, "INSERT INTO `users` (`id`, `username`, `email`, `password`, `created`) VALUES (NULL, '$uid', '$email', '$pwd_hashed', '$date')");

        //redirects to login page
        //change to session variables -----------------
        header ('Location: login.php?registered=success');
        exit();
    }

}

?>
<div class="container">
<h1>Register</h1>
    <?php
    //prints all errors if there are any
    if (!empty($errors)) {
        $max = sizeof($errors);
        for ($i=0; $i<$max; $i++) { 
            echo "<p>$errors[$i]</p><br />"; 
        }
    }
?>

<form action="register.php" method="post">
    <input type="text" name="username" placeholder="Username" required><br/>
    <input type="email" name="email" placeholder="Email"required><br/>
    <input type="password" name="password" placeholder="Password" required><br/>
    <input type="password" name="repeatpassword" placeholder="Repeat Password" required><br/>
    <input type="submit" name="submit" value="Register"><br/>
    <p>Already have an account? <a href="login.php">Login</a></p>
</form>
</div>