<?php require '../yeh/parts/connect-db.php';


if (!isset($_SESSION)) {
    session_start();
}
header('Content-Type: application/json');

if (!isset($_SESSION['tPrice'])) {
    $_SESSION['tPrice'] = [];
}
$_SESSION['tPrice'] = $_POST['tPrice'];
$memberSid = $_SESSION['member']['member_sid'];

$output = [
    'success' => false,
    'error' => '',
];


//新增母訂單
$order = "INSERT INTO `order`( 
    `order_num`, 
    `member_sid`, 
    `total`,
    `created_time`
    ) VALUES (
        ?,
        ?,
        ?,
        NOW())";
$stmt = $pdo->prepare($order);
//抓當前時間
$date = new DateTime();
//轉換格式
$date = explode("/", date('Y/m/d/h/i/s'));
//時間轉換字串陣列
list($Y, $M, $D, $H, $I, $S) = $date;
//陣列透過PHP的implode()變成一個字串
$order_num = implode('', $date);



$stmt->execute([
    $order_num,
    $memberSid,
    $_SESSION['tPrice'],
]);
//回傳結果
// if ($stmt->rowCount()) {
//     $output['success'] = true;
// }

//如果產品購物車不是空的 新增產品訂單
if (!empty($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $p) {
        $p_order = "INSERT INTO `product_order`( 
            `order_num`, 
            `products_sid`, 
            `qty`, 
            `total`, 
            `created_time`) VALUES (
                ?,
                ?,
                ?,
                ?,
                NOW())";
        $p_stmt = $pdo->prepare($p_order);
        $p_total = $p['qty'] * $p['product_price'];
        $p_stmt->execute([
            $order_num,
            $p['product_sid'],
            $p['qty'],
            $p_total
        ]);
    }
}

if (!empty($_SESSION['rCart'])) {
    foreach ($_SESSION['rCart'] as $r) {
        $r_order = "INSERT INTO `booking_order`( 
            `order_num`, 
            `room_sid`,
            `start`,
            `end`,
            `qty`,
            `total`, 
            `created_time`) VALUES (
                ?,
                ?,
                ?,
                ?,
                ?,
                ?,
                NOW())";
        $r_stmt = $pdo->prepare($r_order);
        $r_total = $r['qty'] * $r['room_price'];

        $r_stmt->execute([
            $order_num,
            $r['room_sid'],
            $r['start'],
            $r['end'],
            $r['qty'],
            $r_total
        ]);
    }
}

if (!empty($_SESSION['renCart'])) {
    foreach ($_SESSION['renCart'] as $ren) {
        $ren_order = "INSERT INTO `rental_order`( 
            `order_num`, 
            `rental_sid`,
            -- `store_sid1`,
            -- `store_sid2`,
            -- `out_date`,
            -- `back_date`,
            `qty`, 
            `total`, 
            `created_time`) VALUES (
                ?,
                ?,
                -- ?,
                -- ?,
                -- ?,
                -- ?,
                ?,
                ?,
                NOW())";
        $ren_stmt = $pdo->prepare($ren_order);
        $ren_total = $ren['qty'] * $ren['rental_price'];
        $ren_stmt->execute([
            $order_num,
            $ren['rental_product_sid'],
            // "",
            // "",
            // "",
            // "",
            $ren['qty'],
            $ren_total
        ]);
    }
}

if (!empty($_SESSION['camCart'])) {
    foreach ($_SESSION['camCart'] as $cam) {
        $cam_order = "INSERT INTO `campaign_order`( 
            `order_num`,
            `campaign_sid`, 
            -- `campaign_type_sid`,
            -- `date_start`, 
            -- `date_end`, 
            `total`, 
            `created_time`) VALUES (
                ?,
                ?,
                -- ?,
                -- ?,
                -- ?,
                ?,
                NOW())";
        $cam_stmt = $pdo->prepare($cam_order);
        $cam_total = $cam['qty'] * $cam['price'];
        $cam_stmt->execute([
            $order_num,
            $cam['sid'],
            // "",
            // "",
            // "",
            $cam_total
        ]);
    }
}



// echo json_encode($output, JSON_UNESCAPED_UNICODE);
