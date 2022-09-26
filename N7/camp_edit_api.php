<?php

require '../yeh/parts/connect-db.php';

$folder = __DIR__ . '/camp_uploads/';


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

$sqll = "SELECT `mainImage`,`bigImage`,`detailImage` FROM `campaign` WHERE sid =" . $_POST['sid'];

$answer = $pdo->query($sqll)->fetch();
// echo json_encode($answer);
// exit;
if (!empty($_FILES['mainImage']['name'])) {
    $filenamemain = md5($_FILES['mainImage']['name'] . uniqid());
    move_uploaded_file(
        $_FILES['mainImage']['tmp_name'],
        $folder . $filenamemain
    );
    
} else {
    $filenamemain = $answer['mainImage'];
    
};

if (!empty($_FILES['bigImage']['name'])) {
    $filenamebig = md5($_FILES['bigImage']['name'] . uniqid());
    move_uploaded_file(
        $_FILES['bigImage']['tmp_name'],
        $folder . $filenamebig
    );
} else {
    $filenamebig = $answer['bigImage'];
};

if (!empty($_FILES['detailImage']['name'])) {
    $filenamedetail = md5($_FILES['detailImage']['name'] . uniqid());
    move_uploaded_file(
        $_FILES['detailImage']['tmp_name'],
        $folder . $filenamedetail
    );
} else {
    $filenamedetail = $answer['detailImage'];
};

$sql =
    "UPDATE `campaign` SET `name`=?,`location_sid`=?,`campaign_type_sid`=?,`price`=?, `camp_startdate`=?, `camp_enddate`=?, `brife_describe`=?,`schedule_describe`=?, `qty`=?, `mainImage`=?, `bigImage`=?, `detailImage`=? WHERE sid=?";

$stmt  = $pdo->prepare($sql);
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
        $filenamedetail,
        $_POST['sid']
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
