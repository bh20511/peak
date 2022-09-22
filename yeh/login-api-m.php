<?php
require __DIR__ . '/parts/connect-db.php';
header('Content-Type: application/json');

$output = [
    'success' => false,
    'error' => '',
    'code' => 0,
];

//檢查是否有輸入email和password
if(empty($_POST['email']) or empty($_POST['password'])){
    $_output['error'] = '請輸入電子信箱和密碼';
    echo json_encode($_output, JSON_UNESCAPED_UNICODE);
    exit;
    //錯誤的話就回傳錯誤訊息並結束api
}

$sql = "SELECT * FROM members WHERE email=?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$_POST['email']]);
$row = $stmt->fetch();

//no account
if(empty($row)){
    $output['error'] = '電子信箱或密碼錯誤'; 
    $output['code'] = 401;
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit; // 結束程式
}

//wrong password
if(password_verify($_POST['password'], $row['password'])){
    $output['success'] = true;
    $_SESSION['member'] = [
        'member_sid' => $row['member_sid'],
        'nickname' => $row['nickname']
    ];
} else {
    $output['error'] = '電子信箱或密碼錯誤';
    $output['code'] = 421;
}

echo json_encode($output, JSON_UNESCAPED_UNICODE);