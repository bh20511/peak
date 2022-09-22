<?php

require '../yeh/parts/admin-req.php';
require '../yeh/parts/connect-db.php';
header('Content-Type: application/json');
$folder = __DIR__ . '/picture/'; //上傳檔案的資料夾

$output = [
    'success' => false,
    'error' => '',
    'code' => 0,
    'postData' => $_POST // 除錯用的
];


if (empty($_POST['product_name'])) {
    $output['error'] = '參數不足';
    $output['code'] = 400;
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
}








$extMap = [
    'image/jpeg' => '.jpg',
    'image/png' => '.png',
];

// files 本身會空的名字(binary)
if (!empty($_FILES['single']['name'])) {

    $ext = $extMap[$_FILES['single']['type']];
    if (empty($ext)) {
        $output['error'] = '檔案格式錯誤: 放jpeg、png';
        echo  json_encode($output, JSON_UNESCAPED_UNICODE);
        exit;
    }

    //隨機檔名
    $filename = md5($_FILES['single']['name'] . uniqid()) . $ext;
    $output['filename'] = $filename;




    if ($_FILES['single']['name']) {
        if (!move_uploaded_file(
            $_FILES['single']['tmp_name'],
            $folder . $filename
        )) {
            $output['error'] = '無法移動上傳檔案，注意資料夾權限問題';
            echo json_encode($output, JSON_UNESCAPED_UNICODE);
            exit;
        }
    }


    $sql = "UPDATE `product` SET 
    `product_name`=?,
    `product_category_sid`=?,
    `product_price`=?,
    `product_inventory`=?,
    `picture`=?,
    `product_description`=?,
    `brand_sid`=?
    where sid=?";
    $stmt = $pdo->prepare($sql);
    try {
        $stmt->execute([
            $_POST['product_name'],
            $_POST['product_category_sid'],
            $_POST['product_price'],
            $_POST['product_inventory'],
            $filename,
            $_POST['product_description'],
            $_POST['brand_sid'],
            $_POST['sid']
        ]);
    } catch (PDOException $ex) {
        $output['error'] = $ex->getMessage();
    }
} else {
    $sql = "UPDATE `product` SET 
    `product_name`=?,
    `product_category_sid`=?,
    `product_price`=?,
    `product_inventory`=?,
    `product_description`=?,
    `brand_sid`=?
    where product_sid=?";

    $stmt = $pdo->prepare($sql);



    try {
        $stmt->execute([
            $_POST['product_name'],
            $_POST['product_category_sid'],
            $_POST['product_price'],
            $_POST['product_inventory'],
            $_POST['product_description'],
            $_POST['brand_sid'],
            $_POST['product_sid']
        ]);
    } catch (PDOException $ex) {
        $output['error'] = $ex->getMessage();
    }
}




//副檔名對應 




// TODO: 檢查欄位資料






if ($stmt->rowCount()) {
    $output['success'] = true;
} else {
    if (empty($output['error']))
        $output['error'] = '資料沒有修改';
}


echo json_encode($output, JSON_UNESCAPED_UNICODE);
