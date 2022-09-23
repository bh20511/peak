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
    <input type="text" name="qty" id="qty">
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
                                <td style="max-width:250px ;"><?= $p['product_name'] ?></td>
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

                                    <select class="form-select" onchange="change2()">
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
                                    <img src="../N7/camp_uploads/<?= $cam['mainImage'] ?>" alt="" width="150px">
                                </td>
                                <td><?= $cam['name'] ?></td>
                                <td class="price">$<?= $cam['price'] ?></td>
                                <td>

                                    <select class="form-select" onchange="change3()">
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
                                    <select class="form-select" onchange="change4()">
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
    <?php if (!empty($_SESSION['member'])) : ?>
        <button type="button" class="btn btn-info" onclick="toBuy()">結帳</button>
    <?php else : ?>
        <button type="button" class="btn btn-info" onclick="toBuyError()">結帳</button>
    <?php endif ?>
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
    //顯示金額.總金額
    let test = () => {
        let totalAll = 0;
        let toAll = document.querySelector('.toAll');
        for (let i = 0; i < total.length; i++) {
            total[i].textContent = `$${Number(price[i].textContent.split('$')[1] * sel[i].value)}`;
            totalAll += Number(total[i].textContent.split('$')[1]);
        }
        toAll.textContent = `$${totalAll}`;
    }
    test();
    //更換商品數量
    function change() {
        qty = event.target.value;
        let f_qty = document.querySelector('#qty');
        let f_sid = event.target.parentNode.parentNode.getAttribute("data_sid");
        let money = event.target.parentNode.parentNode.querySelector('.price').textContent.split('$')[1];
        let moneyAll = event.target.parentNode.parentNode.querySelector('.total');
        f_qty.value = qty;
        sid.value = f_sid;
        let fd = new FormData(document.querySelector('.form1'));
        fetch('cart-api/proQty.php', {
                method: "POST",
                body: fd
            })
            .then(r => r.json())
            .then(obj => {
                changePrice(qty, money, moneyAll)
            });
        test()
    }
    //更換租借數量
    function change2() {
        qty = event.target.value;
        let f_qty = document.querySelector('#qty');
        let f_sid = event.target.parentNode.parentNode.getAttribute("data_sid");
        let money = event.target.parentNode.parentNode.querySelector('.price').textContent.split('$')[1];
        let moneyAll = event.target.parentNode.parentNode.querySelector('.total');
        f_qty.value = qty;
        sid.value = f_sid;
        let fd = new FormData(document.querySelector('.form1'));
        fetch('cart-api/renQty.php', {
                method: "POST",
                body: fd
            })
            .then(r => r.json())
            .then(obj => {
                changePrice(qty, money, moneyAll)
            });
        test()
    }
    //更換活動數量
    function change3() {
        qty = event.target.value;
        let f_qty = document.querySelector('#qty');
        let f_sid = event.target.parentNode.parentNode.getAttribute("data_sid");
        let money = event.target.parentNode.parentNode.querySelector('.price').textContent.split('$')[1];
        let moneyAll = event.target.parentNode.parentNode.querySelector('.total');
        f_qty.value = qty;
        sid.value = f_sid;
        let fd = new FormData(document.querySelector('.form1'));
        fetch('cart-api/camQty.php', {
                method: "POST",
                body: fd
            })
            .then(r => r.json())
            .then(obj => {
                changePrice(qty, money, moneyAll)
            });
        test()
    }
    //更換房間數量
    function change4() {
        qty = event.target.value;
        let f_qty = document.querySelector('#qty');
        let f_sid = event.target.parentNode.parentNode.getAttribute("data_sid");
        let money = event.target.parentNode.parentNode.querySelector('.price').textContent.split('$')[1];
        let moneyAll = event.target.parentNode.parentNode.querySelector('.total');
        f_qty.value = qty;
        sid.value = f_sid;
        let fd = new FormData(document.querySelector('.form1'));
        fetch('cart-api/roomQty.php', {
                method: "POST",
                body: fd
            })
            .then(r => r.json())
            .then(obj => {
                changePrice(qty, money, moneyAll)
            });
        test()
    }
    //更換數量同時更換價錢
    function changePrice(a, b, c) {
        c.textContent = `$${a * b}`
        console.log(c.textContent)
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

    function toBuyError() {
        Swal.fire({
            icon: 'error',
            title: '請先登入會員',
            showConfirmButton: false,
            timer: 1000,
        });
        setTimeout("location.href = '../yeh/login-form-m.php';", 1000);
    }

    //結帳
    function toBuy() {
        let tPrice = document.querySelector('#tPrice');
        let toAll = document.querySelector('.toAll');
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
                Swal.fire({
                    icon: 'success',
                    title: '購買成功',
                    showConfirmButton: false,
                    timer: 1000,
                });
                fetch('buy-api.php', {
                        method: "POST",
                        body: fd
                    })
                    .then(r => r.text())
                    .then(obj => {
                        if (obj.success) {
                            fetch('clean-api.php');
                        }
                    });
                setTimeout('location.href="order.php"', 800)
            }
        })
    }
</script>
<?php include '../yeh/parts/html-foot.php'; ?>