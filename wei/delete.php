<?php
require '../yeh/parts/connect-db.php';

$sid = isset($_GET['room_sid']) ? intval($_GET['room_sid']) : 0;

$sql = "DELETE FROM room WHERE room_sid=$sid";

$pdo->query($sql);

$come_from = 'list.php';


//HTTP_REFERER 伺服器request 中有紀錄從哪來
if (!empty($_SERVER['HTTP_REFERER'])) {
    $come_from = $_SERVER['HTTP_REFERER'];
}

header("Location: {$come_from}");
