<?php 
include 'config.php';

function encyrptPassword($pwd) {
    $pwd_peppered = hash_hmac("sha256", $pwd, $GLOBALS['pepper']);
    $pwd_hashed = password_hash($pwd_peppered, PASSWORD_BCRYPT);
    return $pwd_hashed;
}

function loggedIn() {
    return isset($_SESSION['userID']);
}

function getPosts() {
    global $conn;
	$sql = "SELECT * FROM posts ORDER BY created DESC;";
	$result = mysqli_query($conn, $sql);

	// fetch all posts as an associative array called $posts
	$posts = mysqli_fetch_all($result, MYSQLI_ASSOC);

	return $posts;
}


function getUsername($userID) {
    //error here
    if ($query = mysqli_query($GLOBALS['conn'], "SELECT * FROM users WHERE id='$userID'")) {
        if (mysqli_num_rows($query) > 0) {
            while ($row = mysqli_fetch_assoc($query)) { 
                return $row['username'];
            }
        } else {
            echo 'username not found';
        }
    }
}


function getTimeElapsed($time) {
    $timedif = time() - $time;

    if ($timedif <= 59) {//seconds
        return 'Just Now';
    } else if ($timedif >= 60 && $timedif <= 3599) {//minutes
        return intval($timedif/60).' Minutes Ago';
    } else if ($timedif >= 3600 && $timedif <= 86399) {//hours
        return intval($timedif/3600).' Hour Ago';
    } else if ($timedif >= 86400 && $timedif <= 604799) {//days
        return intval($timedif/86400).' Day Ago';
    } else if ($timedif >= 604800 && $timedif <= 2628287) {//weeks
        return intval($timedif/604800).' Week Ago';
    } else if ($timedif >= 2628000 && $timedif <= 31535999) {//months
        return intval($timedif/2628000).' Month Ago';
    } else if ($timedif >= 31536000) {//year
        return intval($timedif/31536000).' Year Ago';
    }
}