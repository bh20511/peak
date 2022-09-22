<? require __DIR__ . '/parts/admin-req.php'; ?>
<?php
require __DIR__ . '/parts/connect-db.php';

$member_sid = isset($_GET['member_sid']) ? intval($_GET['member_sid']) : 0;

// 刪除avatar
$sql = "SELECT `avatar` FROM members WHERE `member_sid`={$member_sid}";
$r = $pdo->query($sql)->fetch();
$file = $r['avatar'];
unlink( __DIR__ . "/avatars/$file");


$sqldel = "DELETE FROM members WHERE `member_sid`={$member_sid}";

$pdo->query($sqldel);

// header('Location: 5.list-functions.php');

// 讓他回到原本頁面
// 沒有的話回到預設
$come_from = 'members-list.php';

if(! empty($_SERVER['HTTP_REFERER'])){
    $come_from = $_SERVER['HTTP_REFERER'];
}
header("Location: {$come_from}");