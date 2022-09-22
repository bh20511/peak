<?php
require '../../yeh/parts/connect-db.php';
if(! isset($_SESSION['camCart'])){
    $_SESSION['camCart'] = [];
}

$sid = isset($_POST['sid']) ? intval($_POST['sid']) : 0;
$qty = isset($_POST['qty']) ? intval($_POST['qty']) : 0;

// C: 加到購物車, sid, qty
// R: 查看購物車內容
// U: 更新, sid, qty
// D: 移除項目, sid

if(! empty($sid)) {

    if(! empty($qty)) {
        // 新增或變更
        if(!empty($_SESSION['camCart'][$sid])){
            // 已存在,變更(增加)
            $_SESSION['camCart'][$sid]['qty'] = $_SESSION['camCart'][$sid]['qty'] + $qty;
        } else {
            // 新增
            // TODO: 檢查資料表是不是有這個商品
            $row = $pdo->query("SELECT * FROM `campaign` WHERE sid=$sid")->fetch();
            if(! empty($row)){
                $row['qty'] = $qty;  // 先把數量放進去
                $_SESSION['camCart'][$sid] = $row;
            }
        }
    } else {
        // 刪除項目
        unset($_SESSION['camCart'][$sid]);
    }
}

echo json_encode($_SESSION['camCart'],JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);