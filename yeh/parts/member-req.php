<?php
if(! isset($_SESSIONS)){
    session_start();
}

if(empty($_SESSION['member'])){
    header('Location: login-form-m.php');
    exit;
}