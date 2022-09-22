<?php

$db_host = 'localhost';
$db_name = 'hiking';
//變換資料庫時要修改user和pass
$db_user = 'root';
$db_pass = 'root';

//data source nama
$dsn = "mysql:host={$db_host};dbname={$db_name};charset=utf8";

$pdo_options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
];

$pdo = new PDO($dsn, $db_user, $db_pass, $pdo_options);

if(! isset($_SESSION)){
    session_start();
}
$pageName = '';
// 頁面名稱預設值(navbar 顯示用)

?>
