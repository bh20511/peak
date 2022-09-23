<?php
require '../yeh/parts/connect_-db.php';

$sid = isset($_GET['sid']) ? intval($_GET['sid']) : 0; //要有那個sid 才可以抓到那個sid

$sql = "DELETE FROM `campaign` WHERE sid={$sid}"; //要有那個資料才有辦法刪除

$pdo->query($sql);

$come_form = 'camp_list.php';

if (!empty($_SERVER['HTTP_REFERER'])) {
    $come_form = $_SERVER['HTTP_REFERER'];
}

header("Location: {$come_form}");//刪完之後回list.php 原本刪除的的那一頁
