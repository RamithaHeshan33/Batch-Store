<?php
    session_start();
    ob_start();
    require './connection.php';
    require './nav/nav.php';

    if (!isset($_SESSION['email'])) {
        header('Location: login.php');
        exit;
    }
?>