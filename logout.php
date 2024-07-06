<?php

session_start();

if (isset($_SESSION['uname'])) {
    unset($_SESSION['privillage']);
    unset($_SESSION['uname']);
    unset($_SESSION['name']);
    header("Location: login.php");
}
?>