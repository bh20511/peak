
<?php
require __DIR__ . '/parts/connect-db.php';

header('Content-Type: application/json');

$folder = __DIR__ . '/avatars/'; //target folder

$extMap = [
    'image/jpeg' => '.jpg',
    'image/png' => '.png',
];

$output = [
    'success' => false,
    'error' => '',
    'code' => 0,
    'postData' => $_POST, // 除錯用的
    'files' => $_FILES,
];

// TODO 各種欄位驗證

//檢查空欄位
?>
<?php require __DIR__ . '/parts/member-insert-empty.php'; ?>
<?php

//驗證資料正確

//密碼
$regexPw = " /^(?=.*[^a-zA-Z0-9])(?=.*[A-Z])(?=.*[a-z])(?=.*\d).{6,}$/";
if (! preg_match($regexPw, $_POST['password'])){
    $output['error'] = "密碼格式錯誤";
    $output['code'] = 400;
    echo json_encode($output, JSON_UNESCAPED_UNICODE); 
    exit;
}

//手機
$regexMb = "/^09\d{2}-?\d{3}-?\d{3}$/";
$mobile = null;
if (preg_match($regexMb, $_POST['mobile'])){
    $mobile = str_replace("-", "", $_POST['mobile']);
}
else {
    $output['error'] = "手機號碼格式錯誤";
    $output['code'] = 400;
    echo json_encode($output, JSON_UNESCAPED_UNICODE); 
    exit;
}

//信箱
// $regexEm = "/^([a-zA-Z0-9._%-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4})*$/";
$regexEm = "/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/";
if (! preg_match($regexEm, $_POST['email'])){
    $output['error'] = "Email格式錯誤";
    $output['code'] = 400;
    echo json_encode($output, JSON_UNESCAPED_UNICODE); 
    exit;
}

//生日
$birthday = null;
if(strtotime($_POST['birthday'])!==false){
    $birthday = $_POST['birthday'];
} else {
    $output['error'] = "生日格式錯誤";
    $output['code'] = 400;
    echo json_encode($output, JSON_UNESCAPED_UNICODE); 
    exit;
}

//上傳檔案格式
if(! empty($_FILES['single']['name'])){
    $ext = $extMap[$_FILES['single']['type']];
    if(empty($ext)){
        $output['error'] = '檔案格式錯誤, 須為jpeg, png';
        echo json_encode($output, JSON_UNESCAPED_UNICODE);
        exit;
    }
    }

//信箱已經使用
$email = $_POST['email'];
$stmtMail = $pdo->prepare("SELECT * FROM members WHERE email=?");
$stmtMail->execute([$email]); 
$user = $stmtMail->fetch();
if($user){
    $output['error'] = '信箱已使用';
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
}

//密碼加密
$password = $_POST['password'];
$hash = password_hash("$password", PASSWORD_DEFAULT);

//隨機檔名
$filename = NULL;
if(! empty($_FILES['single']['name'])){
    $filename = md5($_FILES['single']['name']. uniqid()). $ext;
} 
$output['filename'] =$filename;




$sql =
    "INSERT INTO `members`(
    `member_sid`, 
    `name`, 
    `password`, 
    `email`, 
    `mobile`, 
    `address`, 
    `birthday`, 
    `nickname`,
    `avatar`
    ) VALUES (
        NULL, ?, ?, ?, ?, ?, ?, ?, ?
    )";
$stmt = $pdo->prepare($sql);

try {
    $stmt->execute([
        //使用insert-form post進insert-api.的資料
        $_POST['name'],
        $hash,
        $_POST['email'],
        $mobile,
        $_POST['address'],
        $birthday,
        $_POST['nickname'],
        $filename
    ]);
} catch(PDOException $ex) {
    $output['error'] = $ex->getMessage();
}

if($filename !== NULL){
if(! move_uploaded_file(
    $_FILES['single']['tmp_name'], $folder. $filename
)){
    $out['error'] = "無法移動上傳檔案, 注意資料夾權限";
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
}
}

if($stmt->rowCount()){
    $output['success'] = true;
}else {
    $output['error'] = '資料新增失敗';
}

echo json_encode($output, JSON_UNESCAPED_UNICODE); 