


<?php
require __DIR__ . './connect.php';
header('Content-Type: application/json');

$folder = __DIR__ . '/picture/'; //上傳檔案的資料夾

$extMap = [
    'image/jpeg' => '.jpg',
    'image/png' => '.png',
];


$output = [
    'success' => false,
    'error' => '',
    'data' => [],
    'files' => $_FILES, // 除錯用
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


//----------------------------------------------------------------------
$select_sql =
    "SELECT  `picture` FROM `product`  ORDER BY `sid` DESC LIMIT 1;";
$pic_lastid = $pdo->query($select_sql)->fetch(PDO::FETCH_NUM)[0];

//取代雙引號
$pic_last_id = str_replace('"', '', $pic_lastid);
//只取數字
$pic_int_id = substr($pic_last_id, 2, 4);

//----------------------------------------------------------------------


$filename = 'pg' . $pic_int_id . $ext;
$output['filename'] = $filename;


if (!move_uploaded_file(
    $_FILES['single']['tmp_name'],
    $folder . $filename
)) {
    $output['error'] = '無法移動上傳檔案，注意資料夾權限問題';
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
}

$output['success'] = true;


echo json_encode($output, JSON_UNESCAPED_UNICODE);
