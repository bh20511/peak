<?php require __DIR__ . '/parts/connect_db2.php';
$pageName = 'list';

$perPage = 20; // 一頁有幾筆
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;

// 算總筆數
$t_sql = "SELECT COUNT(1) FROM rental ";
$totalRows = $pdo->query($t_sql)->fetch(PDO::FETCH_NUM)[0];

$totalPages = ceil($totalRows / $perPage);

$rows = [];
// 如果有資料
if ($totalRows) {
    if ($page < 1) {
        header('Location: ?page=1');
        exit;
    }
    if ($page > $totalPages) {
        header('Location: ?page=' . $totalPages);
        exit;
    }

    $sql = sprintf(
        "SELECT * FROM rental  
        JOIN product_category 
        ON rental.product_category_sid=product_category.sid 
        JOIN brand
        ON brand.brand_sid= rental.brand_sid
        ORDER BY rental_product_sid 
        DESC LIMIT %s, %s ",
        ($page - 1) * $perPage,
        $perPage
    );
    // $sql = "SELECT * FROM rental";
    $rows = $pdo->query($sql)->fetchAll();
}

$output = [
    'totalRows' => $totalRows,
    'totalPages' => $totalPages,
    'page' => $page,
    'rows' => $rows,
    'perPage' => $perPage,
];

// echo json_encode($output); exit;

?>
<?php require __DIR__ . '/parts/html-head.php'; ?>
<?php include __DIR__ . '/parts/navbar.php'; ?>
<div class="container">
    <div class="row">
        <div class="col">
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    <li class="page-item <?= 1 == $page ? 'disabled' : '' ?>">
                        <a class="page-link" href="?page=<?= $page - 1 ?>">
                            <i class="fa-solid fa-circle-arrow-left"></i>
                        </a>
                    </li>

                    <?php for ($i = $page - 5; $i <= $page + 5; $i++) :
                        if ($i >= 1 and $i <= $totalPages) :
                    ?>
                            <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                                <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                            </li>
                    <?php
                        endif;
                    endfor; ?>

                    <li class="page-item <?= $totalPages == $page ? 'disabled' : '' ?>">
                        <a class="page-link" href="?page=<?= $page + 1 ?>">
                            <i class="fa-solid fa-circle-arrow-right"></i>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>


    <div class="row">
        <div class="col">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th scope="col">
                            <i class="fa-solid fa-trash-can"></i>
                        </th>
                        <th scope="col">租借品名</th>
                        <th scope="col">種類</th>
                        <th scope="col">品牌</th>
                        <th scope="col">每日租價</th>
                        <th scope="col">數量</th>
                        <th scope="col">圖片</th>
                        <th scope="col">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rows as $r) : ?>
                        <tr>
                            <td>
                                <a href="javascript: delete_it(<?= $r['rental_product_sid'] ?> ,'<?=$r['rental_product_name']  ?>' )">
                                    <i class="fa-solid fa-trash-can"></i>
                                </a>
                            </td>
                            <td><?= $r['rental_product_name'] ?></td>
                            <td><?= $r['product_category'] ?></td>
                            <td><?= $r['brand_name'] ?></td>
                            <td><?= $r['rental_price'] ?></td>
                            <td><?= $r['rental_qty'] ?></td>
                            <td><img src="./rental/<?= $r['rental_img'] ?>" alt="" style="width:100px;"></td>

                            <td>
                                <a href="2edit_rental.php?rental_product_sid=<?= $r['rental_product_sid'] ?>">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>

            </table>


        </div>
    </div>

</div>
<?php include __DIR__ . '/parts/scripts.php'; ?>
<script>
    const table = document.querySelector('table');

    function delete_it(a,b) {
        if (confirm(`確定要刪除編號為 ${b} 的資料嗎?`)) {
            location.href = `2delete_rental.php?rental_product_sid=${a}`;
        }
    }
</script>
<?php include __DIR__ . '/parts/html-foot.php'; ?>