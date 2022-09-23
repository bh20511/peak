<?php require '../yeh/parts/connect-db.php';


$pageName = 'products';

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
//查詢總共有幾筆
$p_sql = "SELECT COUNT(1) FROM `product`";
// fetch(PDO::FETCH_NUM)[0]; //去掉欄位 .[0]只取值 得到有幾行的資料
$totalrows = $pdo->query($p_sql)->fetch(PDO::FETCH_NUM)[0];
// //每頁放4筆
$perpage = 12;
// //總共有幾頁 
$totalpage = ceil($totalrows / $perpage);


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


    //查詢資料 降冪排序 LIMIT 0,5 
    $sql = sprintf(
        "SELECT * FROM `product` ORDER BY `product_sid` DESC LIMIT %s,%s",
        ($page - 1) * $perpage,
        $perpage
    );
    // $rows = [];
    $rows = $pdo->query($sql)->fetchAll();
}

$output = [
    'totalrows' => $totalrows,
    'totalrows' => $totalpage,
    'page' => $page,
    'row' => $rows,
    'prepage' => $perpage,
];

?>
<?php include '../yeh/parts/html-head.php'; ?>

<?php include '../yeh/parts/nav-m.php'; ?>

<style>
    .form-select {
        width: 30%;
        display: inline-block;
    }

    .fa-cart-plus {
        /* font-size: 30px; */
        color: white;
    }

    .card-text {
        font-size: 25px;
    }

    .form1 {
        /* display: none; */
    }

    .card-body {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
</style>
<form class="form1">
    <input type="text" name="sid" id="sid">
    <input type="text" name="qty" id="qty">
</form>
<div class="container">
    <div class="row">
        <nav aria-label="Page navigation example">
            <ul class="pagination">

                <li class="page-item <?= 1 == $page ? 'disabled' : 0 ?>">
                    <a class="page-link" href="?page=<?= $page - 1 ?>">
                        <i class="fa-solid fa-caret-left"></i>
                    </a>
                </li>

                <?php for ($i = 1; $i <= $totalpage; $i++) : ?>
                    <li class="page-item <?= $i == $page ? 'active' : 0 ?>">
                        <a class="page-link" href=" ?page=<?= $i ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>

                <li class="page-item <?= $totalpage == $page ? 'disabled' : 0 ?>">
                    <a class="page-link" href="?page=<?= $page + 1 ?>">
                        <i class="fa-solid fa-caret-right"></i>
                    </a>
                </li>

            </ul>
        </nav>

        <!-- <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li class="page-item">
                    <a class="page-link" href="#">
                        <i class="fa-solid fa-caret-left"></i>
                    </a>
                </li>
                <li class="page-item"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item">
                    <a class="page-link" href="#">
                        <i class="fa-solid fa-caret-right"></i>
                    </a>
                </li>
            </ul>
        </nav> -->
        <?php foreach ($rows as $r) : ?>

            <div class="card" style="width: 18rem;">
                <img src="../ZX/picture/<?= $r['picture'] ?>" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title"><?= $r['product_name'] ?></h5>
                    <div>
                        <p class="card-text">
                            <i class="fa-solid fa-dollar-sign"></i>
                            <?= $r['product_price'] ?>
                        </p>
                        <select class="form-select">
                            <?php for ($i = 1; $i <= 10; $i++) : ?>
                                <option value="<?= $i ?>"><?= $i ?></option>
                            <?php endfor; ?>
                        </select>
                        <button type="button" class="btn btn-primary" data_sid="<?= $r['product_sid'] ?>" onclick="addToCar(event)"><i class="fa-solid fa-cart-plus"></i></button>
                    </div>
                </div>

            </div>

        <?php endforeach; ?>

    </div>
</div>


<?php include '../yeh/parts/scripts.php'; ?>
<script>
    function addToCar(event) {
        let btnE = event.currentTarget;
        let sid = btnE.getAttribute("data_sid");
        let qty = btnE.parentNode.querySelector('.form-select').value;
        let fs = document.querySelector('#sid');
        let fq = document.querySelector('#qty');
        fs.value = sid;
        fq.value = qty
        let fd = new FormData(document.querySelector('.form1'));
        let cartNum = 0;
        let badge = document.querySelector('.badge');
        fetch('./cart-api/proCart.php', {
                method: "POST",
                body: fd
            })
            .then(r => r.json())
            .then(function(data) {
                count(data)
                console.log(data)
            })
        Swal.fire({
            icon: 'success',
            title: '已加入購物車',
            showConfirmButton: false,
            timer: 1000,
        });

    }
</script>
<?php include '../yeh/parts/html-foot.php'; ?>