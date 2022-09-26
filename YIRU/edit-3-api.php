<?php

require '../yeh/parts/connect-db.php';

$num = intval($_POST['num']);

//查詢該筆訂單的商品單價
$sql = "SELECT `rental_price` FROM `rental` join `rental_order` on `rental`.`rental_product_sid` = `rental_order`.`rental_sid` WHERE `order_num`= $num";
$sql_stmt = $pdo->query($sql)->fetch();

//重新計算總額
$total = $sql_stmt['rental_price'] * $_POST['qty'];

//更新
$p_sql = "UPDATE `rental_order` SET 
    `qty`= ?,
    `total`=?
    WHERE `order_num` = $num";
    $p_stmt = $pdo->prepare($p_sql);
        $p_stmt->execute([
            $_POST['qty'],
            $total
        ]);


$p_total = "SELECT SUM(`total`) FROM `product_order` WHERE`order_num` = $num";
$p_total_stmt = $pdo->query($p_total)->fetch();

$b_total = "SELECT SUM(`total`) FROM `booking_order` WHERE`order_num` = $num";
$b_total_stmt = $pdo->query($b_total)->fetch();

$r_total = "SELECT SUM(`total`) FROM `rental_order` WHERE`order_num` = $num";
$r_total_stmt = $pdo->query($r_total)->fetch();

$c_total = "SELECT SUM(`total`) FROM `campaign_order` WHERE`order_num` = $num";
$c_total_stmt = $pdo->query($c_total)->fetch();

empty($p_total_stmt) ? 0 : (int)$p_total_stmt['SUM(`total`)'];
empty($b_total_stmt) ? 0 : (int)$b_total_stmt['SUM(`total`)'];
empty($r_total_stmt) ? 0 : (int)$r_total_stmt['SUM(`total`)'];
empty($c_total_stmt) ? 0 : (int)$c_total_stmt['SUM(`total`)'];


$order_total = (int)$p_total_stmt['SUM(`total`)'] + (int)$b_total_stmt['SUM(`total`)'] + (int)$r_total_stmt['SUM(`total`)'] + (int)$c_total_stmt['SUM(`total`)'];


$order = "UPDATE `order` SET 
`total`=?
WHERE `order_num` = $num";
$order_stmt = $pdo->prepare($order);
$order_stmt->execute([
    $order_total
]);



