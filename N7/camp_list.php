<?php 
require '../yeh/parts/admin-req.php';
require '../yeh/parts/connect-db.php';
$pageName = 'camp_list';

$perpage = 5; //設定一頁有幾筆

$page = isset($_GET['page']) ? intval($_GET['page']) : 1; //判斷是否有設定第幾頁，沒有是第一頁


//第一步 先算資料的總比數
$t_sql = "SELECT COUNT(1) FROM campaign";

$totalRows = $pdo->query($t_sql)->fetch(PDO::FETCH_NUM)[0];

$totalPages = ceil($totalRows / $perpage);

$rows = [];

//如果有資料的話才做事
if ($totalRows) {
    if ($page < 1) {
        //如果page<1 跳轉到page1
        header('Location: ?page=1');
        exit;
    }
    if ($page > $totalPages) {
        //如果page>大於最後一頁 跳轉到最後一頁
        header('Location: ?page=' . $totalPages);
        exit;
    }

    $sql = sprintf(
        "SELECT * FROM campaign  ORDER BY sid DESC  LIMIT %s, %s",
        ($page - 1) * $perpage,
        $perpage
    ); // 索引值0, 開始取perpage比數的資料

    $rows = $pdo->query($sql)->fetchAll();
}


$sqlct = "SELECT * FROM `campaign_type`";
$rowsct = $pdo->query($sqlct)->fetchAll();

$sqllo = "SELECT * FROM `location`";
$rowslo = $pdo->query($sqllo)->fetchAll();



$output = [
    'totalRows' => $totalRows,
    'totalPages' => $totalPages,
    'page' => $page,
    'rows' => $rows,
    'perpage' => $perpage,
];

//echo json_encode($output);//測試用


?>
<?php require '../yeh/parts/html-head.php'; ?>
<?php include '../yeh/parts/nav.php'; ?>




<div class="container">
    <div class="row">
        <div class="col">
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    <li class="page-item <?= 1 == $page ? 'disabled' : '' ?>">
                        <a class="page-link" href="?page=<?= $page - 1 ?>">
                            <i class="fa-solid fa-circle-left"></i>
                        </a>
                    </li>
                    <?php for ($i = $page - 5; $i <=  $page + 5; $i++) :
                        if ($i >= 1 and $i <= $totalPages) :
                    ?>
                            <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                                <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                            </li>
                    <?php
                        endif;
                    endfor; ?>
                    <li class="page-item disabled">
                    <li class="page-item <?= $totalPages == $page ? 'disabled' : '' ?>">
                        <a class="page-link" href="?page=<?= $page + 1 ?>">
                            <i class="fa-solid fa-circle-right"></i>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>



    <div class="row">
        <div class="col">
            <button type="button" class="btn btn-info <?= $page_name == 'camp_list' ? 'active' : '' ?>">
                <a class="nav-link" href="camp_insert_form.php">新增活動</a>
            </button>
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th scope="col">
                            <i class="fa-regular fa-trash-can"></i>
                        </th>
                        <th scope="col">#</th>
                        <th scope="col">活動名稱</th>
                        <th scope="col">地點</th>
                        <th scope="col">活動分類</th>
                        <th scope="col">活動售價</th>
                        <th scope="col">活動起始日</th>
                        <th scope="col">活動結束日</th>
                        <th scope="col">活動介紹</th>
                        <th scope="col">行程規劃</th>
                        <th scope="col">庫存數量</th>
                        <th scope="col">活動主圖</th>
                        <th scope="col">活動大圖</th>
                        <th scope="col">活動細圖</th>

                        <th scope="col">
                            <i class="fa-regular fa-pen-to-square"></i>
                        </th>

                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rows as $r) : ?>

                        <tr>
                            <!-- 假連結  -->
                            <td><a href="javascript: delete_it(<?= $r['sid'] ?>)">
                                    <i class="fa-regular fa-trash-can"></i>
                                </a></td>
                            <td><?= $r['sid'] ?></td>
                            <td><?= $r['name'] ?></td>

                            <?php foreach ($rowslo as $rlo) : ?>
                                <?php if ($r['location_sid'] == $rlo['sid']) : ?>
                                    <td>
                                        <?= $rlo['name'] ?>
                                    </td>
                                <?php endif; ?>
                            <?php endforeach; ?>

                            <?php foreach ($rowsct as $rct) : ?>
                                <?php if ($r['campaign_type_sid'] == $rct['sid']) : ?>
                                    <td>
                                        <?= $rct['name'] ?>
                                    </td>
                                <?php endif; ?>
                            <?php endforeach; ?>

                            <td><?= $r['price'] ?></td>
                            <td><?= $r['camp_startdate'] ?></td>
                            <td><?= $r['camp_enddate'] ?></td>
                            <td><?= $r['brife_describe'] ?></td>

                            <!-- 跳脫html -->
                            <td><?= htmlentities($r['schedule_describe'])  ?></td>

                            <!-- 會去掉html tag <td><?= strip_tags($r['schedule_describe']) ?></td>  -->

                            <td><?= $r['qty'] ?></td>

                            <td>
                                <img src="./camp_uploads/<?= $r['mainImage'] ?>" alt="" style="width:160px;">
                            </td>

                            <td>
                                <img src="./camp_uploads/<?= $r['bigImage'] ?>" alt="" style="width:160px" ;>

                            </td>

                            <td>
                                <img src="./camp_uploads/<?= $r['detailImage'] ?>" alt="" style="width:160px" ;>

                            </td>

                            <td><a href="camp_edit_form.php?sid=<?= $r['sid'] ?>">
                                    <i class="fa-regular fa-pen-to-square"></i>
                                </a></td>
                        </tr>


                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php


?>

<script>
    const table = document.querySelector('table');

    // 假連結的function
    function delete_it(sid) {
        if (confirm(`確定要刪除campaign表單編號為sid= ${sid}的資料嗎?`)) {
            location.href = `camp_delete.php?sid=${sid}`;
        }
    }



    /*  table.addEventListener('click', function(event) {
        const t = event.target;
        console.log(t);
        if (t.classList.contains('fa-trash-can')) {
            t.closest('tr').remove();
        }
        if (t.classList.contains('fa-pen-to-square')) {
            console.log(t.closest('tr').childNodes[3].textContent);
        }
    });  */
</script>
<?php include '../yeh/parts/scripts.php'; ?>
<?php include '../yeh/parts/html-foot.php'; ?>