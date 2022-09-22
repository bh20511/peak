<?php

require '../yeh/parts/admin-req.php';

require '../yeh/parts/connect-db.php';
$sid = isset($_GET['sid']) ? intval($_GET['sid']) : 0;

$sql = "DELETE  FROM `brand` WHERE `brand_sid`={$sid}";


$pdo->query($sql);

$come_from = 'brand-list';

if (!empty($_SERVER['HTTP_REFERER'])) {
    $come_from = $_SERVER['HTTP_REFERER'];
}
header("Location: {$come_from}");
