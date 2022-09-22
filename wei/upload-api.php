<?php
// require __DIR__ . '/parts/admin-required.php';
require __DIR__ . '/parts/connect_db.php';

header('Content-Type:application/json');

$folder = __DIR__ . '/uploads/'; //上傳檔案的資料夾

$extMap = [
    'image/jpeg' => '.jpg',
    'image/png' => '.png'
];

$output = [
    'success' => false,
    'data' => [],
    'error' => '',
    'files' => $_FILES, //除錯用
];


if (empty($_FILES['img'])) {
    $output['error'] = '沒有上傳檔案';
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
}

//$ext副檔名
//副檔名對應
$ext = $extMap[$_FILES['img']['type']];
if (empty($ext)) {
    $output['error'] = '檔案格式錯誤：要jpeg, png';
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
}

//隨機檔名

$filename = md5($_FILES['img']['name'] . uniqid()) . $ext;
$output['filename'] = $filename;


if (!move_uploaded_file(
    $_FILES['img']['tmp_name'],
    $folder . $filename
)) {
    $output['error'] = '無法移動上傳檔案，注意資料夾權限';
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
}

$output['success'] = true;


$sql = "INSERT INTO `room`(
    `room_name`, 
    `location_sid`, 
    `mountain_sid`, 
    `room_start_date`, 
    `room_end_date`, 
    `room_price`,
    `room_qty`, 
    `room_details`, 
    `room_img`)
    VALUES(?,?,?,?,?,?,?,?,?)";

$stmt = $pdo->prepare($sql);

try {
    $stmt->execute([
        $_POST['name'],
        $_POST['location'],
        $_POST['mountain'],
        $_POST['startdate'],
        $_POST['enddate'],
        $_POST['price'],
        $_POST['qty'],
        $_POST['details'],
        $filename,
    ]);
} catch (PDOException $ex) {
    $output['error'] = $ex->getMessage();
};


if ($stmt->rowCount()) {
    $output['success'] = true;
} else {
    if (empty($output['error']))
        $output['error'] = '資料沒有新增';
}

echo json_encode($output, JSON_UNESCAPED_UNICODE);
