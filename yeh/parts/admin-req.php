<?php
if(! isset($_SESSIONS)){
    session_start();
}

if(empty($_SESSION['admin'])){
    header('Location: login-form.php');
    exit;
}