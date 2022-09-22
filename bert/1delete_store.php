<?php 
require __DIR__ . '/parts/connect_db2.php';

$store_sid = isset($_GET['store_sid'])? intval($_GET['store_sid']):0;

$sql = "DELETE FROM store WHERE store_sid={$store_sid}";

$pdo->query($sql);


$come_from = '1list_store.php';
if(!empty($_SERVER['HTTP_REFERER'])){
    $come_from = $_SERVER['HTTP_REFERER'];
}
header("Location: {$come_from}");
?>