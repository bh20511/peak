<?php

 require '../yeh/parts/admin-req.php';
 require '../yeh/parts/connect-db.php'; 

header('Content-Type: application/json');

$output = [
    'success' => false,
    'error' => '',
    'code' => 0,
    'postData' => $_POST, // 除錯用的
];

if (empty($_POST['product_category'])) {
    $output['error'] = '參數不足';
    $output['code'] = 400;
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
}









// TODO: 檢查欄位資料

$sql2 = "INSERT INTO `product_category`(`product_category`,`gender`
    ) VALUES (?, ?)";

$stmt = $pdo->prepare($sql2);






try {
    $stmt->execute([
        $_POST['product_category'],
        $_POST['gender'],
    ]);
} catch (PDOException $ex) {
    $output['error'] = $ex->getMessage();
}


if ($stmt->rowCount()) {
    $output['success'] = true;
} else {
    if (empty($output['error']))
        $output['error'] = '資料沒有新增';
}




echo json_encode($output, JSON_UNESCAPED_UNICODE);
