<?php require '../yeh/parts/admin-req.php'; ?>
<?php require '../yeh/parts/connect-db.php'; ?>


<?php
$pageName = 'product-list'; // 設置當前所在頁面
$prepage = 5; // 每頁5個
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;  //設置第幾頁面，如果沒有預設都是第一頁

$price = isset($_GET['price']) ? intval($_GET['price']) : 1;






$t_sql = sprintf("SELECT count(1) FROM product WHERE product_price >= %s order by product_price", $price);







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
    $sql = sprintf("SELECT * FROM product where product_price >= %s ORDER BY `product_price` DESC LIMIT %s,%s", $price, ($page - 1) * $prepage, $prepage);

    //取出所有的資料
    $rows = $pdo->query($sql)->fetchAll();



    $sql2 = "SELECT  *  FROM product_category";
    $rows2 = $pdo->query($sql2)->fetchAll();

    $sql3 = "SELECT  *  FROM brand ";
    $rows3 = $pdo->query($sql3)->fetchAll();
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
<?php include '../yeh/parts/nav.php'; ?>





<div class="container">
    <input type="text" name="price" id="price" placeholder="請輸入金額">
    <button onclick="filter()" class="btn btn-primary">送出</button>
    <div class="row">
        <div class="col" style="display:flex; justify-content:space-between;">
            <nav aria-label="Page navigation example">
                <ul class="pagination">

                    <li class="page-item <?= 1 == $page ? 'disabled' : 0 ?>">
                        <a class="page-link" href="?page=<?= $page - 1 ?>&price=<?= $price ?>">
                            <i class="fa-solid fa-circle-arrow-left"></i>
                        </a>
                    </li>

                    <?php for ($i = 1; $i <= $totalpage; $i++) : ?>
                        <li class="page-item <?= $i == $page ? 'active' : 0 ?>">
                            <a class="page-link" href=" ?page=<?= $i ?>&price=<?= $price ?>"><?= $i ?></a>
                        </li>
                    <?php endfor; ?>

                    <li class="page-item <?= $totalpage == $page ? 'disabled' : 0 ?>">
                        <a class="page-link" href="?page=<?= $page + 1 ?>&price=<?= $price ?>">
                            <i class="fa-solid fa-circle-arrow-right"></i>
                        </a>
                    </li>

                </ul>
            </nav>
            <button id="insert" type="button" class="btn btn-primary">新增商品</button>
        </div>

        <div class="row">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th scope="col">
                            <i class="fa-solid fa-trash-can"></i>
                        </th>

                        <th scope="col">#</th>
                        <th scope="col">品名</th>
                        <th scope="col">種類</th>
                        <th scope="col">品牌</th>
                        <th scope="col">價格</th>
                        <th scope="col">庫存</th>
                        <th scope="col">產品說明</th>
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
                                <a href="javascript: delete_it(<?= $r['product_sid'] ?>)">
                                    <i class="fa-solid fa-trash-can"></i>
                                </a>
                            </td>

                            <td><?= $r['product_sid'] ?></td>
                            <td><?= $r['product_name'] ?></td>

                            <?php foreach ($rows2 as $x) : ?>
                                <?php if ($x['product_category_sid'] == $r['product_category_sid']) : ?>
                                    <td><?= $x['product_category'] ?></td>
                                <?php endif; ?>
                            <?php endforeach; ?>

                            <?php foreach ($rows3 as $q) : ?>
                                <?php if ($q['brand_sid'] == $r['brand_sid']) : ?>
                                    <td><?= $q['brand_name'] ?></td>
                                <?php endif; ?>
                            <?php endforeach; ?>


                            <td><?= $r['product_price'] ?></td>
                            <td><?= $r['product_inventory'] ?></td>
                            <td><?= $r['product_description'] ?></td>
                            <td><img src="./picture/<?= $r['picture'] ?>" alt="" style="width: 150px;"></td>

                            <td>
                                <a href="edit-product.php?sid=<?= $r['product_sid'] ?>">
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






<?php include '../yeh/parts/scripts.php'; ?>
<script>
    function delete_it(sid) {
        if (confirm(`確定要刪除編號為${sid}的資料嗎?`)) {
            location.href = `delete_product.php?sid=${sid}`;
        }
    }

    const insert = document.querySelector("#insert");
    insert.addEventListener("click", event => {
        location.href = 'insert-product.php'
    })

    function filter() {
        const price = document.querySelector("#price").value;
        location.href = 'list-product2.php?price=' + price;
    }
</script>
<?php include '../yeh/parts/html-foot.php'; ?>