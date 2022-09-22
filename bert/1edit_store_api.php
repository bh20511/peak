<?php 
require __DIR__ . '/parts/connect_db2.php';
$folder = __DIR__. '/store/';

header('Content-Type: application/json');

//照片判斷
// 副檔名對應



if(empty($_POST['store_name'])){
    $output['error'] = '參數不足';
    $output['code'] = 400;
    echo json_encode($output, JSON_UNESCAPED_UNICODE); 
    exit;
}

// $sql = "SELECT * FROM store WHERE store_sid=$store_sid";
// TODO: 檢查欄位資料


if(empty($_FILES['single']['name'])){
    $sql = "UPDATE `store` SET 
    `store_name`=?,
    `store_address`=?
    WHERE store_sid=?";  
    $stmt = $pdo->prepare($sql);

    try {
        $stmt->execute([
            $_POST['store_name'],
            $_POST['store_address'],
            $_POST['store_sid']
        ]);
    } catch(PDOException $ex) {
        $output['error'] = $ex->getMessage();
    }
}else{
    $extMap = [
        'image/jpeg' => '.jpg',
        'image/png' => '.png',
    ];
    
    $ext = $extMap[$_FILES['single']['type']];
    if(empty($ext)){
        $output['error'] = '檔案格式錯誤: 要 jpeg, png';
        echo json_encode($output, JSON_UNESCAPED_UNICODE);
        exit;
    }
    
       
    // 隨機檔名
    $filename = md5($_FILES['single']['name']. uniqid()). $ext;
    $output['filename'] = $filename;
    
    
    if(! 
        move_uploaded_file(
            $_FILES['single']['tmp_name'],
            $folder. $filename
        )
    ) {
        $output['error'] = '無法移動上傳檔案, 注意資料夾權限問題';
        echo json_encode($output, JSON_UNESCAPED_UNICODE);
        exit;
    }
    
    $output = [
        'success' => false,
        'error' => '',
        'code' => 0,
        'postData' => $_POST['store_sid'],
        'files' => $_FILES,
         // 除錯用的
    ];
    
    $sql = "UPDATE `store` SET 
    `store_name`=?,
    `store_address`=?,
    `store_img`=?
    WHERE store_sid=?";

$stmt = $pdo->prepare($sql);

try {
    $stmt->execute([
        $_POST['store_name'],
        $_POST['store_address'],
        $filename,
        $_POST['store_sid']
    ]);
} catch(PDOException $ex) {
    $output['error'] = $ex->getMessage();
}
}




if($stmt->rowCount()){
    $output['success'] = true;
} else {
    if(empty($output['error']))
        $output['error'] = '資料沒有修改';
}
echo json_encode($output, JSON_UNESCAPED_UNICODE); 