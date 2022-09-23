<?php require '../yeh/parts/connect-db.php';

$num = isset($_GET['num']) ? intval($_GET['num']) : 0;

//母訂單
$order = "SELECT * FROM `order` WHERE `order_num` = $num";
$order_stmt = $pdo->query($order)->fetch();

if($order_stmt['order_num'] == $num){
    echo 1;
}

//產品訂單
$p_order = "SELECT * FROM `product_order` WHERE `order_num` = $num";
$p_order_stmt = $pdo->query($p_order)->fetch();

if($p_order_stmt['order_num'] == $num){
    echo 2;
}

//訂房訂單
$room_order = "SELECT * FROM `booking_order` WHERE `order_num` = $num";
$room_order_stmt = $pdo->query($room_order)->fetch();

if($room_order_stmt['order_num'] == $num){
    echo 3;
}

//租借訂單
$ren_order = "SELECT * FROM `rental_order` WHERE `order_num` = $num";
$ren_order_stmt = $pdo->query($ren_order)->fetch();

if($ren_order_stmt['order_num'] == $num){
    echo 4;
}

//活動
$cam_order = "SELECT * FROM `campaign_order` WHERE `order_num` = $num";
$cam_order_stmt = $pdo->query($cam_order)->fetch();

if($cam_order_stmt['order_num'] == $num){
    echo 5;
}


// echo json_encode($order_stmt['order_num']);











?>