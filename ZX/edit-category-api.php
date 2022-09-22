<?php

require '../yeh/parts/admin-req.php';
require '../yeh/parts/connect-db.php';
header('Content-Type: application/json');


$output = [
    'success' => false,
    'error' => '',
    'code' => 0,
    'postData' => $_POST // 除錯用的
];


if (empty($_POST['product_category'])) {
    $output['error'] = '參數不足';
    $output['code'] = 400;
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
}



$sql = "UPDATE `product_category` SET 
    `product_category`=?,
    `gender`=?
    where product_category_sid=?";

$stmt = $pdo->prepare($sql);



try {
    $stmt->execute([
        $_POST['product_category'],
        $_POST['gender'],
        $_POST['product_category_sid']
    ]);
} catch (PDOException $ex) {
    $output['error'] = $ex->getMessage();
}







if ($stmt->rowCount()) {
    $output['success'] = true;
} else {
    if (empty($output['error']))
        $output['error'] = '資料沒有修改';
}


echo json_encode($output, JSON_UNESCAPED_UNICODE);
