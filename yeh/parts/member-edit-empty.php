<?php

//檢查欄位
if(empty($_POST['name'])){
    $output['error'] = '請輸入姓名';
    $output['code'] = 400;
    echo json_encode($output, JSON_UNESCAPED_UNICODE); 
    exit;
}

if(empty($_POST['nickname'])){
    $output['error'] = '請輸入暱稱';
    $output['code'] = 400;
    echo json_encode($output, JSON_UNESCAPED_UNICODE); 
    exit;
}

if(empty($_POST['mobile'])){
    $output['error'] = '請輸入手機號碼';
    $output['code'] = 400;
    echo json_encode($output, JSON_UNESCAPED_UNICODE); 
    exit;
}

if(empty($_POST['email'])){
    $output['error'] = '請輸入Email';
    $output['code'] = 400;
    echo json_encode($output, JSON_UNESCAPED_UNICODE); 
    exit;
}

if(empty($_POST['birthday'])){
    $output['error'] = '請選擇生日';
    $output['code'] = 400;
    echo json_encode($output, JSON_UNESCAPED_UNICODE); 
    exit;
}

if(empty($_POST['address'])){
    $output['error'] = '請輸入地址';
    $output['code'] = 400;
    echo json_encode($output, JSON_UNESCAPED_UNICODE); 
    exit;
}

?>