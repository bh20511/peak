<?php require '../yeh/parts/connect-db.php';

$sql = "SELECT p.`product_category` as pname , COUNT(1) as number
FROM `rental` 
JOIN `product_category` AS p
ON `rental`.`product_category_sid` = p.`product_category_sid`
GROUP BY rental.`product_category_sid`";

$rows = $pdo->query($sql)->fetchAll();
$output = [
    'labels' => array(),
    'data' => array(),
];

foreach ($rows as $r) {
    array_push($output['labels'],$r['pname']);
    array_push($output['data'],$r['number']);
};



echo json_encode($output, JSON_UNESCAPED_UNICODE); 
?>