<?php

session_start(); //啟用session

unset($_SESSION['member']);

header('Location: login-form-m.php');