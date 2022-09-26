<?php
require '../yeh/parts/connect-db.php';

header('Content-Type: application/json');
$folder = __DIR__ . '/camp_uploads/'; //上傳檔案的資料夾


//設定上傳之後的副檔名
$extMap = [
    'image/jpeg' => '.jpg',
    'image/png' => '.png'
];


$output = [
    'success' => false,
    'error' => '',
    'data' => [],
    'files' => $_FILES, //除錯用的
];


if (empty($_FILES['mainImage'])) {
    $output['error'] = '沒有上傳檔案1';
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
}

if (empty($_FILES['bigImage'])) {
    $output['error'] = '沒有上傳檔案2';
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
}
if (empty($_FILES['detailImage'])) {
    $output['error'] = '沒有上傳檔案3';
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
}

//檢查副檔名
$extm = $extMap[$_FILES['mainImage']['type']];
$extb = $extMap[$_FILES['bigImage']['type']];
$extd = $extMap[$_FILES['detailImage']['type']];



if (empty($extm)) {
    $output['error'] = '檔案格式錯誤1,  要 jpeg, png';
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
}

if (empty($extb)) {
    $output['error'] = '檔案格式錯誤2,  要 jpeg, png';
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
}

if (empty($extd)) {
    $output['error'] = '檔案格式錯誤3,  要 jpeg, png';
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
}

//隨機檔名
$filenamemain = md5($_FILES['mainImage']['name'] . uniqid()) . $extm;
$filenamebig = md5($_FILES['bigImage']['name'] . uniqid()) . $extb;
$filenamedetail = md5($_FILES['detailImage']['name'] . uniqid()) . $extd;

$output['filenamemain'] = $filenamemain;
$output['filenamebig'] = $filenamebig;
$output['filenamedetail'] = $filenamedetail;


if (!move_uploaded_file(
    $_FILES['mainImage']['tmp_name'],
    $folder . $filenamemain
)) {
    $output['error'] = '無法移動上傳檔案, 注意資料夾權限問題';
    echo json_encode($output . JSON_UNESCAPED_UNICODE);
    exit;
}

if (!move_uploaded_file(
    $_FILES['bigImage']['tmp_name'],
    $folder . $filenamebig
)) {
    $output['error'] = '無法移動上傳檔案, 注意資料夾權限問題';
    echo json_encode($output . JSON_UNESCAPED_UNICODE);
    exit;
}

if (!move_uploaded_file(
    $_FILES['detailImage']['tmp_name'],
    $folder . $filenamedetail
)) {
    $output['error'] = '無法移動上傳檔案, 注意資料夾權限問題';
    echo json_encode($output . JSON_UNESCAPED_UNICODE);
    exit;
}

if (empty($_POST['name'])) {
    $output['error'] = '參數不足';
    $output['code'] = 400;
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
}

//TODO： 檢查欄位資料


//新增一筆在sql database
$sql =
    "INSERT INTO `campaign`(`name`, `location_sid`, `campaign_type_sid`, `price`, `camp_startdate`, `camp_enddate`, `brife_describe`, `schedule_describe`, `qty`, `mainImage`, `bigImage`, `detailImage`)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $pdo->prepare($sql); //prepare 先準備sql跟檢查sql的語法有沒有問題


try {
    $stmt->execute([
        $_POST['name'],
        $_POST['location_sid'],
        $_POST['campaign_type_sid'],
        $_POST['price'],
        $_POST['camp_startdate'],
        $_POST['camp_enddate'],
        $_POST['brife_describe'],
        $_POST['schedule_describe'],
        $_POST['qty'],
        $filenamemain,
        $filenamebig,
        $filenamedetail
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
