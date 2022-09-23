<?php require '../yeh/parts/admin-req.php'; ?>
<?php require '../yeh/parts/connect-db.php'; ?>


<?php
$pageName = 'brand-list'; // 設置當前所在頁面
$prepage = 30; // 每頁5個
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;  //設置第幾頁面，如果沒有預設都是第一頁
$t_sql = "SELECT count(1) FROM brand ";


//輸出時是陣列 用pdo fetch_num去掉欄位，[0] 只取值 ，得到有幾行資料
$totalrows = $pdo->query($t_sql)->fetch(PDO::FETCH_NUM)[0];
//  $totalRows 當php從資料庫讀取出來的數字為字串  Ceil 無條件進位
$totalpage = ceil($totalrows / $prepage);
//總共幾筆 除以 每頁幾筆 取得 總共的頁數 


// 判斷資料是否有傳進來  >> 如果有再判斷頁數是否 小於1 or 大於總頁數，調整頁數上下限
if ($totalrows) {
    if ($page < 1) {
        header('Location: ?page=1');
        exit;
    }
    if ($page > $totalpage) {
        header('Location: ?page=' . $totalpage);
        exit;
    }
    //因後方有%s 需要帶入 並用sprintf 來解決 sprintf(format,arg1,arg2,arg++)
    //litmit(起始index, 往後算多少個)
    $sql = sprintf("SELECT * FROM brand  LIMIT %s,%s", ($page - 1) * $prepage, $prepage);

    //取出所有的資料
    $rows = $pdo->query($sql)->fetchAll();
}


$output = [
    'totalrows' => $totalrows,
    'totalrows' => $totalpage,
    'page' => $page,
    'row' => $rows,
    'prepage' => $prepage,
];




?>


<?php require '../yeh/parts/html-head.php'; ?>

<style>
    img {
        width: 200px;
        text-align: center;
    }
</style>

<?php include '../yeh/parts/nav.php'; ?>

<div class="container">
    <div class="row">
        <div class="col">
            <nav aria-label="Page navigation example">
                <ul class="pagination">

                    <li class="page-item <?= 1 == $page ? 'disabled' : 0 ?>">
                        <a class="page-link" href="?page=<?= $page - 1 ?>">Previous</a>
                    </li>

                    <?php for ($i = 1; $i <= $totalpage; $i++) : ?>
                        <li class="page-item <?= $i == $page ? 'active' : 0 ?>">
                            <a class="page-link" href=" ?page=<?= $i ?>"><?= $i ?></a>
                        </li>
                    <?php endfor; ?>

                    <li class="page-item <?= $totalpage == $page ? 'disabled' : 0 ?>">
                        <a class="page-link" href="?page=<?= $page + 1 ?>">Next</a>
                    </li>

                </ul>
            </nav>
            <h1>品牌</h1>
            <table class="table table-dark -columns">
                <thead>
                    <tr>
                        <th scope="col">
                            <i class="fa-solid fa-trash-can"></i>
                        </th>
                        <th scope="col">編號</th>
                        <th scope="col">品牌</th>
                        <th scope="col">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($rows as $r) : ?>
                        <tr>
                            <td>
                                <a href="javascript: delete_it(<?= $r['brand_sid'] ?>)">
                                    <i class="fa-solid fa-trash-can"></i>
                                </a>
                            </td>
                            <td><?= $r['brand_sid'] ?></td>
                            <td><?= $r['brand_name'] ?></td>
                            <td>
                                <a href="edit-brand.php?sid=<?= $r['brand_sid'] ?>">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                            </td>
                        <?php endforeach; ?>
                </tbody>

            </table>
        </div>

    </div>
</div>






<?php include '../yeh/parts/scripts.php'; ?>
<script>
    function delete_it(sid) {
        if (confirm(`確定要刪除編號為${sid}的資料嗎?`)) {
            location.href = `delete_brand.php?sid=${sid}`;
        }
    }
</script>
<?php include '../yeh/parts/html-foot.php'; ?>