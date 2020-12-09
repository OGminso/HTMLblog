<?php

session_start();

session_destroy();

$_SESSION = array();

session_abort();
session_unset();

header ('Location: index.php');