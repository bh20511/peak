<?php
require '../../yeh/parts/connect-db.php';

header('Content-Type: application/json');

$sid = isset($_POST['sid']) ? intval($_POST['sid']) : 0;


if(! isset($_SESSION['cart'])){
    $_SESSION['cart'] = [];
    $_SESSION['rCart'] = [];
    $_SESSION['renCart'] =[];
    $_SESSION['camCart'] =[];
    $_SESSION['tPrice'] =[];
}

$cam = $_SESSION['camCart'][$sid]['qty'];
$ren = $_SESSION['renCart'][$sid]['qty'];
$c = $_SESSION['cart'][$sid]['qty'];
$r = $_SESSION['rCart'][$sid]['qty'];

$tt = [];
$tt = [$cam,$ren,$c,$r];


echo json_encode($tt , JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);




?>