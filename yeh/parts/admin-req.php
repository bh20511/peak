<?php
if(! isset($_SESSIONS)){
    session_start();
}

if(empty($_SESSION['admin'])){
    header('Location: ../yeh/login-form.php');
    exit;
}