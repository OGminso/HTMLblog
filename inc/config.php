<?php

$db_host = 'localhost';
$db_username = 'root';
$db_password = '';
$db_database = 'BLOG';

$pepper = '1DerfgS1sFSfg4gfLdw';

$conn = mysqli_connect($db_host, $db_username, $db_password, $db_database);

if ($conn === false) {
    die("ERROR: Couldn't connect. " . mysqli_connect_error());
}