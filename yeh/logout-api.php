<?php require __DIR__ . '/parts/admin-req.php'; ?>
<?php

session_start(); //啟用session

unset($_SESSION['admin']);

header('Location: login-form.php');