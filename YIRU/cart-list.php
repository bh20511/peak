<?php require '../yeh/parts/connect-db.php';
$pageName = 'cart';

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}
if (!isset($_SESSION['rCart'])) {
    $_SESSION['rCart'] = [];
}
if (!isset($_SESSION['camCart'])) {
    $_SESSION['camCart'] = [];
}
if (!isset($_SESSION['renCart'])) {
    $_SESSION['renCart'] = [];
}

?>
<?php include '../yeh/parts/html-head.php'; ?>
<?php include '../yeh/parts/nav-m.php'; ?>
<style>
    .btn-primary:hover {
        --bs-btn-hover-bg: #cfe2ff;
        --bs-btn-hover-color: #084298;
        --bs-btn-active-bg: #cfe2ff
    }

    .coll {
        margin-bottom: 20px;
    }

    .text {
        text-align: center;
    }

    .form-select {
        width: 60%;
        display: inline-block;
    }

    .alert {
        display: flex;
        justify-content: space-between;
        margin-top: 15px;
    }

    .alert p {
        margin-bottom: 0;
    }

    .form1 {
        display: none;
    }
</style>
<form class="form1">
    <input type="text" name="sid" id="sid">
    <input type="text" name="tPrice" id="tPrice">
</form>
<div class="container">
    <div class="row">
        <div class="alert alert-primary text" role="alert">
            商品
        </div>
        <div class="coll" id="rental">
            <div class="card card-body">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">
                                <i class="fa-solid fa-trash-can"></i>
                            </th>
                            <th scope="col">封面</th>
                            <th scope="col">商品名稱</th>
                            <th scope="col">單價</th>
                            <th scope="col">數量</th>
                            <th scope="col">金額</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($_SESSION['cart'] as $p) :

                        ?>
                            <tr data_sid="<?= $p['product_sid'] ?>" class="item">
                                <td>
                                    <a href="javascript: delete_it(<?= $p['product_sid'] ?>)" data_sid="<?= $p['product_sid'] ?>">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </a>
                                </td>
                                <td>
                                    <img src="../ZX/picture/<?= $p['picture'] ?>" alt="" width="150px">
                                </td>
                                <td><?= $p['product_name'] ?></td>
                                <td class="price">$<?= $p['product_price'] ?></td>
                                <td>

                                    <select class="form-select" onchange="change()">
                                        <?php for ($i = 1; $i <= 10; $i++) : ?>
                                            <option value="<?= $i ?>" <?= $p['qty'] == $i ? "selected" : "" ?> class="op"><?= $i ?></option>
                                        <?php endfor; ?>
                                    </select>
                                </td>
                                <td class="total"></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="alert alert-primary text" role="alert">
            租借商品
        </div>
        <div class="coll" id="products">
            <div class="card card-body">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">
                                <i class="fa-solid fa-trash-can"></i>
                            </th>
                            <th scope="col">封面</th>
                            <th scope="col">商品名稱</th>
                            <th scope="col">單價</th>
                            <th scope="col">數量</th>
                            <th scope="col">金額</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($_SESSION['renCart'] as $ren) :

                        ?>
                            <tr data_sid="<?= $ren['rental_product_sid'] ?>" class="item">
                                <td>
                                    <a href="javascript: delete_it3(<?= $ren['rental_product_sid'] ?>)" data_sid="<?= $ren['rental_product_sid'] ?>">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </a>
                                </td>
                                <td>
                                    <img src="../bert/rental/<?= $ren['rental_img'] ?>" alt="" width="150px">
                                </td>
                                <td><?= $ren['rental_product_name'] ?></td>
                                <td class="price">$<?= $ren['rental_price'] ?></td>
                                <td>

                                    <select class="form-select" onchange="change()">
                                        <?php for ($i = 1; $i <= 10; $i++) : ?>
                                            <option value="<?= $i ?>" <?= $ren['qty'] == $i ? "selected" : "" ?> class="op"><?= $i ?></option>
                                        <?php endfor; ?>
                                    </select>
                                </td>
                                <td class="total"></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="alert alert-primary text" role="alert">
            活動
        </div>
        <div class="coll" id="campaign">
            <div class="card card-body">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">
                                <i class="fa-solid fa-trash-can"></i>
                            </th>
                            <th scope="col">封面</th>
                            <th scope="col">商品名稱</th>
                            <th scope="col">單價</th>
                            <th scope="col">數量</th>
                            <th scope="col">金額</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($_SESSION['camCart'] as $cam) : ?>
                            <tr data_sid="<?= $cam['sid'] ?>" class="item">
                                <td>
                                    <a href="javascript: delete_it4(<?= $cam['sid'] ?>)" data_sid="<?= $cam['sid'] ?>">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </a>
                                </td>
                                <td>
                                    <img src="./imgs/<?= $cam['mainImage'] ?>" alt="" width="150px">
                                </td>
                                <td><?= $cam['name'] ?></td>
                                <td class="price">$<?= $cam['price'] ?></td>
                                <td>

                                    <select class="form-select" onchange="change()">
                                        <?php for ($i = 1; $i <= 10; $i++) : ?>
                                            <option value="<?= $i ?>" <?= $cam['qty'] == $i ? "selected" : "" ?> class="op"><?= $i ?></option>
                                        <?php endfor; ?>
                                    </select>
                                </td>
                                <td class="total"></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="alert alert-primary text" role="alert">
            房間
        </div>
        <div class="coll" id="room">
            <div class="card card-body">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">
                                <i class="fa-solid fa-trash-can"></i>
                            </th>
                            <th scope="col">封面</th>
                            <th scope="col">房名</th>
                            <th scope="col">價錢</th>
                            <th scope="col">人數</th>
                            <th scope="col">入住時間</th>
                            <th scope="col">離開時間</th>
                            <th scope="col">金額</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($_SESSION['rCart'] as $r) :
                        ?>
                            <tr data_sid="<?= $r['room_sid'] ?>" class="item">
                                <td>
                                    <a href="javascript: delete_it2(<?= $r['room_sid'] ?>)" data_sid="<?= $r['room_sid'] ?>">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </a>
                                </td>
                                <td>
                                    <img src="../wei/uploads/<?= $r['room_img'] ?>" alt="" width="150px">
                                </td>
                                <td><?= $r['room_name'] ?></td>
                                <td class="price">$<?= $r['room_price'] ?></td>
                                <td>
                                    <select class="form-select" onchange="change()">
                                        <?php for ($i = 1; $i <= 10; $i++) : ?>
                                            <option value="<?= $i ?>" <?= $r['qty'] == $i ? "selected" : "" ?> class="op"><?= $i ?></option>
                                        <?php endfor; ?>
                                    </select>
                                </td>
                                <td><?= $r['start'] ?></td>
                                <td><?= $r['end'] ?></td>
                                <td class="total"></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="alert alert-info" role="alert">
                <p>總金額：</p><span class="toAll"></span>
            </div>
        </div>
    </div>
    <button type="button" class="btn btn-info" onclick="toBuy()">結帳</button>
</div>






<?php include '../yeh/parts/scripts.php'; ?>
<script>
    let total = document.querySelectorAll('.total');
    let price = document.querySelectorAll('.price');
    let sel = document.querySelectorAll('.form-select');
    let clean = document.querySelector(".btn-warning");
    let sid = document.querySelector('#sid');
    //清空購物車
    clean.addEventListener('click', () => {
        Swal.fire({
            title: '確定要清空嗎?',
            text: "您將清空購物車!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: '確定!',
            cancelButtonText: '取消',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                setTimeout('location.href = "clean-api.php"', 800);
                Swal.fire(
                    '已完成',
                    '',
                    'success',
                )
            }
        })
    });
    //顯示金額
    let totalAll = 0;
    let toAll = document.querySelector('.toAll');
    console.log(toAll);
    for (let i = 0; i < total.length; i++) {
        total[i].textContent = `$${Number(price[i].textContent.split('$')[1] * sel[i].value)}`;
        totalAll += Number(total[i].textContent.split('$')[1]);
    }
    //總金額
    toAll.textContent = `$${totalAll}`;
    //更換數量
    let qty = 0

    function change() {
        qty = event.target.value;
        money = event.target.parentNode.parentNode.querySelector('.price').textContent.split('$')[1];
        moneyAll = event.target.parentNode.parentNode.querySelector('.total');
        moneyAll.textContent = Number(qty) * Number(money);
        totalAll = 0;
        for (let i = 0; i < total.length; i++) {
            total[i].textContent = `$${Number(price[i].textContent.split('$')[1]) * Number(sel[i].value)}`;
            totalAll += Number(total[i].textContent.split('$')[1]);
        }
        toAll.textContent = `$${totalAll}`;
    }
    //刪除單筆商品
    function delete_it(event) {
        sid.value = event;
        let fd = new FormData(document.querySelector('.form1'))
        Swal.fire({
            title: '確定要刪除嗎?',
            text: "您將刪除此筆資料!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: '確定!',
            cancelButtonText: '取消',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                fetch('./cart-api/proCart.php', {
                        method: "POST",
                        body: fd
                    })
                    .then(r => r.json())
                    .then(obj => console.log(obj))
                Swal.fire(
                    '已完成',
                    '',
                    'success'
                )
                setTimeout('location.href="cart-list.php"', 600);
            }

        })
    }
    //刪除單筆訂房
    function delete_it2(event) {
        sid.value = event;
        let fd = new FormData(document.querySelector('.form1'))
        Swal.fire({
            title: '確定要刪除嗎?',
            text: "您將刪除此筆資料!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: '確定!',
            cancelButtonText: '取消',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                fetch('./cart-api/roomCart.php', {
                        method: "POST",
                        body: fd
                    })
                    .then(r => r.json())
                    .then(obj => console.log(obj))
                Swal.fire(
                    '已完成',
                    '',
                    'success'
                )
                setTimeout('location.href="cart-list.php"', 600);
            }

        })
    }
    //刪除單筆租借
    function delete_it3(event) {
        sid.value = event;
        let fd = new FormData(document.querySelector('.form1'))
        Swal.fire({
            title: '確定要刪除嗎?',
            text: "您將刪除此筆資料!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: '確定!',
            cancelButtonText: '取消',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                fetch('./cart-api/renCart.php', {
                        method: "POST",
                        body: fd
                    })
                    .then(r => r.json())
                    .then(obj => console.log(obj))
                Swal.fire(
                    '已完成',
                    '',
                    'success'
                )
                setTimeout('location.href="cart-list.php"', 600);
            }

        })
    }
    //刪除單筆活動
    function delete_it4(event) {
        sid.value = event;
        let fd = new FormData(document.querySelector('.form1'))
        Swal.fire({
            title: '確定要刪除嗎?',
            text: "您將刪除此筆資料!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: '確定!',
            cancelButtonText: '取消',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                fetch('./cart-api/camCart.php', {
                        method: "POST",
                        body: fd
                    })
                    .then(r => r.json())
                    .then(obj => console.log(obj))
                Swal.fire(
                    '已完成',
                    '',
                    'success'
                )
                setTimeout('location.href="cart-list.php"', 600);
            }

        })
    }
    //購物車沒商品 隱藏btn
    let td = document.querySelectorAll('td');
    let btn = document.querySelector('.btn-info')
    if (td.length == 0) {
        btn.style.display = "none"
    }

    function toBuy() {
        let tPrice = document.querySelector('#tPrice');
        tPrice.value = toAll.textContent.split('$')[1];
        let fd = new FormData(document.querySelector('.form1'));
        Swal.fire({
            title: '確定要結帳嗎?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: '確定!',
            cancelButtonText: '取消',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                fetch('buy-api.php', {
                        method: "POST",
                        body: fd
                    })
                    .then(r => r.text())
                    .then(obj => console.log(obj));
                Swal.fire(
                    '已完成',
                    '',
                    'success',
                )
                fetch('clean-api.php');
                setTimeout('location.href="order.php"', 800)
            }
        })
    }
</script>
<?php include '../yeh/parts/html-foot.php'; ?>