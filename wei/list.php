<?php
require '../yeh/parts/admin-req.php';
require '../yeh/parts/connect-db.php';

$perPage = 15; //固定一頁有幾筆
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$pageName = 'list';

//算資料的總筆數

$t_sql = "SELECT COUNT(1) FROM room";

$totalRows = $pdo->query($t_sql)->fetch(PDO::FETCH_NUM)[0]; //索引式陣列

$totalPages = ceil($totalRows / $perPage);

$rows = []; //給預設值

//如果有資料的話才執行 
if ($totalRows) {

    //page小於1或大於總頁數的時候跳轉
    if ($page < 1) {
        header('Location: ?page=1');
        exit;
    }
    if ($page > $totalPages) {
        header('Location: ?page=' . $totalPages);
        exit;
    }

    $sql = sprintf("SELECT * FROM room JOIN mountain ON mountain.mountain_sid=room.mountain_sid JOIN location ON location.sid=room.location_sid ORDER BY room_sid DESC LIMIT %s, %s", ($page - 1) * $perPage, $perPage);

    $rows = $pdo->query($sql)->fetchAll();
}

$output = [
    'totalRows' => $totalRows,
    'totalpages' => $totalPages,
    'page' => $page,
    'rows' => $rows,
    'perpage' => $perPage,
];


// echo json_encode($output);
// exit; // 後面的都不執行
?>
<?php require  '../yeh/parts/html-head.php'; ?>
<?php include  '../yeh/parts/navbar copy.php'; ?>

<div class="container">
    <div class="row">
        <div class="col">
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    <li class="page-item <?php echo 1 == $page ? 'disabled' : '' ?>">
                        <a class="page-link" href="?page=<?= $page - 1 ?>">
                            <i class="fa-sharp fa-solid fa-arrow-left"></i>
                        </a>
                    </li>
                    <?php for ($i = $page - 5; $i <= $page + 5; $i++) :
                        if ($i >= 1 and $i <= $totalPages) : ?>
                            <li class="page-item <?php echo $i == $page ? 'active' : '' ?>">
                                <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                            </li>
                    <?php
                        endif;
                    endfor; ?>
                    <li class="page-item <?php echo $totalPages == $page ? 'disabled' : '' ?>">
                        <a class="page-link" href="?page=<?= $page + 1 ?>">
                            <i class="fa-sharp fa-solid fa-arrow-right"></i>
                        </a>
                    </li>
                </ul>
            </nav>
            <button id="insert" type="button" class="btn btn-primary">新增房型</button>
        </div>
    </div>

</div>


<?php include '../yeh/list-table-admin.php'; ?>
<?php include '../yeh/parts/scripts.php'; ?>

<script>
    const table = document.querySelector('table');

    function delete_it(sid) {
        if (confirm(`你確定要刪除編號${sid}的資料嗎？`)) {
            location.href = `delete.php?room_sid=${sid}`
        }
    }

    const insert = document.querySelector("#insert");
    insert.addEventListener("click", event => {
        location.href = 'insert-form.php'
    })
</script>
<?php include '../yeh/parts/html-foot.php'; ?>