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

if (empty($_POST['product_name'])) {
    $output['error'] = '參數不足';
    $output['code'] = 400;
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
}



$folder = __DIR__ . '/picture/'; //上傳檔案的資料夾



$extMap = [
    'image/jpeg' => '.jpg',
    'image/png' => '.png',
];



if (empty($_FILES['single'])) {
    $output['error'] = '沒有上傳成功';
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
}
//副檔名對應 
$ext = $extMap[$_FILES['single']['type']];
if (empty($ext)) {
    $output['error'] = '檔案格式錯誤: 放jpeg、png';
    echo  json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
}

//隨機檔名
$filename = md5($_FILES['single']['name'] . uniqid()) . $ext;
$output['filename'] = $filename;


if (!move_uploaded_file(
    $_FILES['single']['tmp_name'],
    $folder . $filename
)) {
    $output['error'] = '無法移動上傳檔案，注意資料夾權限問題';
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
}






// TODO: 檢查欄位資料

$sql = "INSERT INTO `product`
( `product_name`, `product_category_sid`, 
`product_price`, `product_inventory`,`picture`,`product_description`,`brand_sid`) VALUES (?, ?, ?, ?, ?,?,?)";

$stmt = $pdo->prepare($sql);





// //篩選圖片最新編號
// $select_sql =
//     "SELECT  `picture` FROM `product`  ORDER BY `sid` DESC LIMIT 1;";
// $pic_lastid = $pdo->query($select_sql)->fetch(PDO::FETCH_NUM)[0];

// //取代雙引號
// $pic_last_id = str_replace('"', '', $pic_lastid);
// //只取數字
// $pic_int_id = substr($pic_last_id, 2, 4);


try {
    $stmt->execute([
        $_POST['product_name'],
        $_POST['product_category_sid'],
        $_POST['product_price'],
        $_POST['product_inventory'],
        $filename,
        $_POST['product_description'],
        $_POST['brand_sid']
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
