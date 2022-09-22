<?php require __DIR__ . '/parts/connect_db.php';
// unset($_SESSION['lo']);

// if (!isset($_SESSION['lo'])) {
//     $_SESSION['lo'] = [];
// };

// $M_sid = isset($_POST['mountain_sid']) ? intval($_POST['mountain_sid']) : 0;

$location = isset($_POST['location']) ? intval($_POST['location']) : 0;
// echo $location;

$sql = "SELECT * FROM mountain WHERE location_sid=$location";
$row = $pdo->query($sql)->fetchAll();

// $_SESSION['lo'] = $row;

echo json_encode($row);
