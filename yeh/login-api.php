<?php
require __DIR__ . '/parts/connect-db.php';
header('Content-Type: application/json');

$output = [
    'success' => false,
    'error' => '',
    'code' => 0,
];

//檢查是否有輸入account和password
if(empty($_POST['account']) or empty($_POST['password'])){
    $_output['error'] = '請輸入帳號密碼';
    echo json_encode($_output, JSON_UNESCAPED_UNICODE);
    exit;
    //錯誤的話就回傳錯誤訊息並結束api
}

//搜尋資料庫中是否有對應的admin帳號
$sql = "SELECT * FROM admins WHERE account=?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$_POST['account']]);
$row = $stmt->fetch();

//找不到帳號
if(empty($row)){
    $output['error'] = '帳號或密碼錯誤'; 
    $output['code'] = 401;
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit; // 結束程式
}

if(password_verify($_POST['password'], $row['password_hash'])){
    $output['success'] = true;
    $_SESSION['admin'] = [
        'sid' => $row['sid'],
        'account' => $row['account']
    ];
} else {
    $output['error'] = '帳號或密碼錯誤';
    $output['code'] = 421;
}

echo json_encode($output, JSON_UNESCAPED_UNICODE);