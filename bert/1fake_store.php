<?php
require __DIR__. '/parts/connect_db2.php';

$stname = ["力誠店","鎧維店","亦儒店","恩齊店","潛之店","柏宏店","柏翰店","宇軒店","家瑋店","冠霖店","雅婷店"];

$areas = ["臺北","新北","桃園","臺中","臺南","高雄","新竹","苗栗","彰化","南投","雲林","嘉義","屏東","宜蘭","花蓮","臺東","澎湖","金門","連江","基隆","新竹"];

$sql = "INSERT INTO `store`(
        `store_name`, 
        `store_address`  
    ) VALUES (
        ?,
        ?
    )";

$stmt = $pdo->prepare($sql);

for($i=0; $i<10; $i++){
    shuffle($stname);
    shuffle($areas);
    $store_name = $areas[0]. $stname[0];
    
    $address = $areas[0];

    $stmt->execute([
        $store_name,
        $address,
    ]);
    
}

echo json_encode([
    $stmt->rowCount(), // 影響的資料筆數
    $pdo->lastInsertId(), // 最新的新增資料的主鍵
]);


/*
https://www.ntdtv.com/b5/2017/05/14/a1324156.html


let d = `01李 02王 03張 04劉 05陳 06楊 07趙 08黃 09周 10吳
11徐 12孫 13胡 14朱 15高 16林 17何 18郭 19馬 20羅
21梁 22宋 23鄭 24謝 25韓 26唐 27馮 28於 29董 30蕭
31程 32曹 33袁 34鄧 35許 36傅 37沈 38曾 39彭 40呂`.split('').sort().slice(119);
JSON.stringify(d);

// ---------------------
https://freshman.tw/namerank

let ar = [];
$('table').eq(0).find('tr>td:nth-of-type(2)').each(function(i, el){
    ar.push(el.innerText);
});
$('table').eq(1).find('tr>td:nth-of-type(2)').each(function(i, el){
    ar.push(el.innerText);
});
JSON.stringify(ar);

// -------------------
https://www.president.gov.tw/Page/106
let ar = [];
$('.btn.btn-default.alluser').each(function(i, el){
    ar.push(el.innerText);
});
JSON.stringify(ar);

*/