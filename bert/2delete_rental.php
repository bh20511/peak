<?php 
require __DIR__ . '/parts/connect_db2.php';

$rental_product_sid = isset($_GET['rental_product_sid'])? intval($_GET['rental_product_sid']):0;

$sql = "DELETE FROM rental WHERE rental_product_sid={$rental_product_sid}";

$pdo->query($sql);


$come_from = '2list_rental.php';
if(!empty($_SERVER['HTTP_REFERER'])){
    $come_from = $_SERVER['HTTP_REFERER'];
}
header("Location: {$come_from}");
?>