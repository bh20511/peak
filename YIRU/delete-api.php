<?php require '../yeh/parts/connect-db.php';

$num = isset($_GET['num']) ? intval($_GET['num']) : 0;



//母訂單
// $order = "SELECT * FROM `order` WHERE `order_num` = $num";
// $order_stmt = $pdo->query($order)->fetch();

$order = "DELETE FROM `order` WHERE `order_num` = $num";
$pdo->query($order);


//產品訂單
$p_order = "SELECT COUNT(1) FROM `product_order` WHERE `order_num` = $num";
$p_order_stmt = $pdo->query($p_order)->fetch(PDO::FETCH_NUM)[0];

if($p_order_stmt){
    $d_p_order = "DELETE FROM `product_order` WHERE `order_num` = $num";
    $pdo->query($d_p_order);
}

//訂房訂單
$room_order = "SELECT COUNT(1) FROM `booking_order` WHERE `order_num` = $num";
$room_order_stmt = $pdo->query($room_order)->fetch(PDO::FETCH_NUM)[0];

if($room_order_stmt){
    $d_room_order = "DELETE FROM `booking_order` WHERE `order_num` = $num";
    $pdo->query($d_room_order);
}

//租借訂單
$ren_order = "SELECT COUNT(1) FROM `rental_order` WHERE `order_num` = $num";
$ren_order_stmt = $pdo->query($ren_order)->fetch(PDO::FETCH_NUM)[0];

if($ren_order_stmt){
    $d_ren_order = "DELETE FROM `rental_order` WHERE `order_num` = $num";
    $pdo->query($d_ren_order);
}

//活動
$cam_order = "SELECT COUNT(1) FROM `campaign_order` WHERE `order_num` = $num";
$cam_order_stmt = $pdo->query($cam_order)->fetch(PDO::FETCH_NUM)[0];

if($cam_order_stmt){
    $d_cam_order = "DELETE FROM `campaign_order` WHERE `order_num` = $num";
    $pdo->query($d_cam_order);
}

$back = 'order-back.php';

header("Location: {$back}");











?>