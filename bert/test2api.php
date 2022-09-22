<?php require __DIR__ . '/parts/connect_db2.php';

$sql = "SELECT COUNT(1) FROM `mountain` GROUP BY `level` ";

$rows = $pdo->query($sql)->fetchAll();
// print_r($rows);
echo $rows
?>