<?php require '../yeh/parts/connect-db.php';

$sql = "SELECT `rental_product_name` as `product_name`
FROM `rental`";

$rows = $pdo->query($sql)->fetchAll();

$output = [
    'product_name' => array(),
];

foreach ($rows as $r) {
    array_push($output['product_name'],$r['product_name']);
};



echo json_encode($output, JSON_UNESCAPED_UNICODE); 
?>