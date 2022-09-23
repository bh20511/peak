<?php 
session_start();

// header('Content-Type: text/plain');

header('Content-Type: application/json');
// $cam = $_SESSION['camCart'];
// $ren = $_SESSION['renCart'];
// $c = $_SESSION['cart'];
// $r = $_SESSION['rCart'];

// $tt = [];
// $tt = [$cam,$ren,$c,$r];

echo json_encode($_SESSION , JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);