<?php
if (!isset($_SESSIONS)) {
    session_start();
}

$from = $_SERVER['REQUEST_URI'];

if (empty($_SESSION['admin'])) {
    header("Location: ../yeh/login-form.php?from=$from");
 exit;
 
}
