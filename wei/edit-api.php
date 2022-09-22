<?php
require '../yeh/parts/admin-req.php';
require '../yeh/parts/connect-db.php';

header('Content-Type: application/json');

if (!empty($_FILES['img']['name'])) {
    $folder = __DIR__ . '/uploads/'; //上傳檔案的資料夾

    $extMap = [
        'image/jpeg' => '.jpg',
        'image/png' => '.png'
    ];

    $output = [
        'success' => false,
        'error' => '',
        'data' => [],
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

    if (empty($_POST['room_name'])) {
        $output['error'] = '參數不足';
        $output['code'] = 400;
        echo json_encode($output, JSON_UNESCAPED_UNICODE);
        exit;
    }

    if (!move_uploaded_file(
        $_FILES['img']['tmp_name'],
        $folder . $filename
    )) {
        $output['error'] = '無法移動上傳檔案，注意資料夾權限';
        echo json_encode($output, JSON_UNESCAPED_UNICODE);
        exit;
    }

    //TODO: 檢查欄位資料

    $sql = "UPDATE `room` SET 
    `room_name`=?,
    `location_sid`=?,
    `mountain_sid`=?,
    `room_start_date`=?,
    `room_end_date`=?,
    `room_price`=?,
    `room_details`=?,
    `room_qty`=?,
    `room_img`=?
    WHERE room_sid=?";

    $stmt = $pdo->prepare($sql);

    try {
        $stmt->execute([
            $_POST['room_name'],
            $_POST['location'],
            $_POST['mountain'],
            $_POST['startdate'],
            $_POST['enddate'],
            $_POST['price'],
            $_POST['details'],
            $_POST['qty'],
            $filename,
            $_POST['room_sid']
        ]);
    } catch (PDOException $ex) {
        $output['error'] = $ex->getMessage();
    };
} else {
    $sql = "UPDATE `room` SET 
    `room_name`=?,
    `location_sid`=?,
    `mountain_sid`=?,
    `room_start_date`=?,
    `room_end_date`=?,
    `room_price`=?,
    `room_details`=?,
    `room_qty`=?
    WHERE room_sid=?";

    $stmt = $pdo->prepare($sql);

    try {
        $stmt->execute([
            $_POST['room_name'],
            $_POST['location'],
            $_POST['mountain'],
            $_POST['startdate'],
            $_POST['enddate'],
            $_POST['price'],
            $_POST['details'],
            $_POST['qty'],
            $_POST['room_sid']
        ]);
    } catch (PDOException $ex) {
        $output['error'] = $ex->getMessage();
    };
}


//rowCount會去計算0 or 1
if ($stmt->rowCount()) {
    $output['success'] = true;
} else {
    if (empty($output['error']))
        $output['error'] = '資料沒有修改';
}

echo json_encode($output, JSON_UNESCAPED_UNICODE);
