<?php
require '../../yeh/parts/connect-db.php';

if(! isset($_SESSION['cart'])){
    $_SESSION['cart'] = [];
}

$sid = isset($_POST['sid']) ? intval($_POST['sid']) : 0;
$qty = isset($_POST['qty']) ? intval($_POST['qty']) : 0;

if(! empty($sid)) {
    if(! empty($qty)) {
        // 新增或變更
        if(!empty($_SESSION['cart'][$sid])){
            // 已存在,變更(增加)
            $_SESSION['cart'][$sid]['qty'] = $qty;
        } else {
            // 新增
            // TODO: 檢查資料表是不是有這個商品
            $row = $pdo->query("SELECT * FROM product WHERE `product_sid`=$sid")->fetch();
            if(! empty($row)){
                $row['qty'] = $qty;  // 先把數量放進去
                $_SESSION['cart'][$sid] = $row;
            }
        }
    } else {
        // 刪除項目
        unset($_SESSION['cart'][$sid]);
    }
}


// if(!empty($sid) and !empty($qty)) {
//     $_SESSION['cart'][$sid]['qty'] = $qty;
// }


echo json_encode($_SESSION['cart'],JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES)
?>
