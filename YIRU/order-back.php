<?php require '../yeh/parts/admin-req.php';
require '../yeh/parts/connect-db.php';


$pageName = 'order-back-list';

$order = "SELECT * FROM `order` ORDER BY `order_sid` DESC";
$order_stmt = $pdo->query($order)->fetchAll();

//商品
$sql = "SELECT * FROM `order`join `product_order` on order.order_num = product_order.order_num 
join product on product_order.products_sid= product.product_sid";
$product_order_product = $pdo->query($sql)->fetchAll();

//訂房
$sql2 = "SELECT * FROM `order`join `booking_order` on order.order_num = booking_order.order_num 
join room on booking_order.room_sid= room.room_sid";
$product_order_room = $pdo->query($sql2)->fetchAll();



//租借
$sql3 = "SELECT * FROM `order`join `rental_order` on order.order_num = rental_order.order_num 
join rental on rental_order.rental_sid= rental.sid";
$product_order_retal = $pdo->query($sql3)->fetchAll();

//活動
$sql4 = "SELECT * FROM `order`join `campaign_order` on order.order_num = campaign_order.order_num 
join campaign on campaign_order.campaign_sid= campaign.sid";
$product_order_camp = $pdo->query($sql4)->fetchAll();




?>
<?php include '../yeh/parts/html-head.php'; ?>
<style>
    .accordion-button {
        display: flex;
    }

    .accordion-button div {
        width: 33.33%;
        align-items: center;
    }

    div.accordion-body.product {
        background-color: lightpink;

    }

    div.accordion-body.room {
        background-color: lightyellow;

    }

    div.accordion-body.rental {
        background-color: lightblue;

    }

    div.accordion-body.camp {
        background-color: lightgreen;

    }

    .accordion-h {
        border: 1px solid black;
        padding: 15px;
        border-radius: 10px;
        background-color: #91B493;
        font-weight: 600;
    }

    .qq {
        font-weight: 900;
    }

    .fa-trash-can {
        color: #F7C242;
        margin-right: 10px;
    }

    .right {
        margin-right: 20px;
    }

    .right-div {
        display: flex;
        justify-content: flex-end;
    }
</style>
<?php include '../yeh/parts/nav.php'; ?>




<!-- ---------------------- -->
<div class="container" style="margin-top: 20px;">
    <div class="row">
        <div class="col">
            <form class="product" style="display:none ;">
                <input type="text" name="num" id="nump">
                <input type="text" name="qty" id="qty">
            </form>
            <?php foreach ($order_stmt as $o) : ?>
                <div class="accordio" id="accordionExample">
                    <div class="accordion-item">
                        <h2 class="accordion-h" id="headingOne">
                            <button class="accordion-button  " type=" button" data-bs-toggle="collapse" data-bs-target="#C<?= $o['order_num'] ?>" aria-expanded="false" aria-controls="collapseOne">
                                <a href="javascript: delete_it(<?= $o['order_num'] ?>)"><i class="fa-solid fa-trash-can"></i></a>
                                <div class="qq"> 會員編號 :<?= $o['member_sid'] ?></div>
                                <div class="qq"> 訂單編號 <?= $o['order_num'] ?></div>
                                <div class="qq">金額 :<?= $o['total'] ?></div>
                                <div class="qq">訂單日期 :<?= $o['created_time'] ?></div>
                            </button>
                        </h2>
                        <div id="C<?= $o['order_num'] ?>" class="accordion-collapse collapse " aria-labelledby="headingOne" data-bs-parent="#accordionExample">

                            <!-- -------------------------產品-------------------------- -->

                            <?php foreach ($product_order_product as $q) : ?>
                                <?php if ($o['order_num'] == $q['order_num']) : ?>
                                    <div class="accordion-body  product">
                                        商品： <?= $q['product_name'] ?>
                                    </div>
                                    <div class="accordion-body product">
                                        單價： <?= $q['product_price'] ?>
                                    </div>
                                    <div class="accordion-body product p_qty">
                                        數量： <span><?= $q['qty'] ?></span>
                                    </div>
                                    <div class="accordion-body product">
                                        總計金額 ：<?= $q['total']  ?>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                            <?php foreach ($product_order_product as $q) : ?>
                                <?php if ($o['order_num'] == $q['order_num']) : ?>
                                    <div class="accordion-body product right-div product">
                                        <button type="button" class="btn btn-dark right" onclick="edit1()" num="<?= $q['order_num'] ?>">編輯</button>
                                    </div>
                                    <?php break; ?>
                                <?php endif ?>
                            <?php endforeach; ?>


                            <!-- -------------------------訂房-------------------------- -->

                            <?php foreach ($product_order_room as $q) : ?>
                                <?php if ($o['order_num'] == $q['order_num']) : ?>
                                    <div class="accordion-body room">
                                        訂房資訊： <?= $q['room_name'] ?>
                                    </div>
                                    <div class="accordion-body room">
                                        入住時間： <?= $q['start'] ?>
                                    </div>
                                    <div class="accordion-body room">
                                        退房時間： <?= $q['end'] ?>
                                    </div>
                                    <div class="accordion-body room">
                                        單價： <?= $q['room_price'] ?>
                                    </div>
                                    <div class="accordion-body room room_qty">
                                        人數： <span><?= $q['qty'] ?></span>
                                    </div>
                                    <div class="accordion-body room">
                                        總計金額 ：<?= $q['total']  ?>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                            <?php foreach ($product_order_room as $q) : ?>
                                <?php if ($o['order_num'] == $q['order_num']) : ?>
                                    <div class="accordion-body product right-div room">
                                        <button type="button" class="btn btn-dark right" onclick="edit2()" num="<?= $q['order_num'] ?>">編輯</button>
                                    </div>
                                    <?php break; ?>
                                <?php endif ?>
                            <?php endforeach; ?>

                            <!-- --------------------------租借------------------------- -->
                            <?php foreach ($product_order_retal as $q) : ?>
                                <?php if ($o['order_num'] == $q['order_num']) : ?>
                                    <div class="accordion-body rental">
                                        租借商品： <?= $q['rental_product_name'] ?>
                                    </div>
                                    <div class="accordion-body rental">
                                        單價： <?= $q['rental_price'] ?>
                                    </div>
                                    <div class="accordion-body rental ren_qty">
                                        數量： <span><?= $q['qty'] ?></span>
                                    </div>
                                    <div class="accordion-body rental">
                                        總計金額 ：<?= $q['total']  ?>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                            <?php foreach ($product_order_retal as $q) : ?>
                                <?php if ($o['order_num'] == $q['order_num']) : ?>
                                    <div class="accordion-body product right-div rental">
                                        <button type="button" class="btn btn-dark right" onclick="edit3()" num="<?= $q['order_num'] ?>">編輯</button>
                                    </div>
                                    <?php break; ?>
                                <?php endif; ?>
                            <?php endforeach; ?>

                            <!-- --------------------------活動------------------------- -->
                            <?php foreach ($product_order_camp as $q) : ?>
                                <?php if ($o['order_num'] == $q['order_num']) : ?>
                                    <div class="accordion-body camp">
                                        活動資訊： <?= $q['name'] ?>
                                    </div>
                                    <div class="accordion-body camp">
                                        總計金額 ：<?= $q['total']  ?>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>




<?php include '../yeh/parts/scripts.php'; ?>
<script>
    //刪除母訂單
    function delete_it(num) {
        Swal.fire({
            title: `確定要刪除編號${num}嗎?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: '確定!',
            cancelButtonText: '取消',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    icon: 'success',
                    title: '刪除成功',
                    showConfirmButton: false,
                    timer: 1000,
                });
                setTimeout(`location.href = "delete-api.php?num=${num}"`, 1000)
            }

        })
    }

    //編輯商品子訂單
    function edit1() {
        let qty = event.target.parentNode.parentNode.querySelectorAll('.p_qty');
        let btn = event.target;
        //改變文字
        if (btn.textContent.indexOf('編輯') != -1) {
            btn.textContent = '完成編輯';
        }
        //改變onclick屬性
        btn.setAttribute('onclick', 'edit1_1()');
        for (let i = 0; i < qty.length; i++) {
            // console.log(qty[i].querySelector('span').textContent);
            let a = qty[i].querySelector('span').textContent;
            qty[i].innerHTML = `數量: <input type="text" value="${a}">`
        }
    }
    //送出商品編輯資料
    function edit1_1() {
        let nump = document.querySelector('#nump');
        let qty = document.querySelector('#qty')
        nump.value = event.target.getAttribute('num');
        qty.value = event.target.parentNode.parentNode.querySelector('.p_qty').querySelector('input').value
        console.log(event.target);
        let fd = new FormData(document.querySelector('.product'));
        fetch('edit-1-api.php', {
                method: 'POST',
                body: fd
            })
            .then(r => r.text())
            .then(obj => {
                console.log(obj)
            })
        Swal.fire({
            icon: 'success',
            title: '已完成修改',
            showConfirmButton: false,
            timer: 1000,
        });
        setTimeout('location.href="order-back.php"', 900)
    }
    //編輯房間子訂單
    function edit2() {
        let qty = event.target.parentNode.parentNode.querySelectorAll('.room_qty');
        let btn = event.target;
        //改變文字
        if (btn.textContent.indexOf('編輯') != -1) {
            btn.textContent = '完成編輯';
        }
        //改變onclick屬性
        btn.setAttribute('onclick', 'edit2_2()');
        for (let i = 0; i < qty.length; i++) {
            // console.log(qty[i]);
            let a = qty[i].querySelector('span').textContent;
            qty[i].innerHTML = `數量: <input type="text" value="${a}">`
        }
    }
    //送出房間編輯資料
    function edit2_2(){
        let nump = document.querySelector('#nump');
        let qty = document.querySelector('#qty')
        nump.value = event.target.getAttribute('num');
        qty.value = event.target.parentNode.parentNode.querySelector('.room_qty').querySelector('input').value
        console.log(event.target);
        let fd = new FormData(document.querySelector('.product'));
        fetch('edit-2-api.php', {
                method: 'POST',
                body: fd
            })
            .then(r => r.text())
            .then(obj => {
                console.log(obj)
            })
        Swal.fire({
            icon: 'success',
            title: '已完成修改',
            showConfirmButton: false,
            timer: 1000,
        });
        setTimeout('location.href="order-back.php"', 900)
    }

    //編輯租借子訂單
    function edit3() {
        let qty = event.target.parentNode.parentNode.querySelectorAll('.ren_qty');
        let btn = event.target;
        //改變文字
        if (btn.textContent.indexOf('編輯') != -1) {
            btn.textContent = '完成編輯';
        }
        //改變onclick屬性
        btn.setAttribute('onclick', 'edit3_3()');
        for (let i = 0; i < qty.length; i++) {
            // console.log(qty[i]);
            let a = qty[i].querySelector('span').textContent;
            qty[i].innerHTML = `數量: <input type="text" value="${a}">`
        }
    }
    //送出租借編輯資料
    function edit3_3(){
        let nump = document.querySelector('#nump');
        let qty = document.querySelector('#qty')
        nump.value = event.target.getAttribute('num');
        qty.value = event.target.parentNode.parentNode.querySelector('.ren_qty').querySelector('input').value
        console.log(event.target);
        let fd = new FormData(document.querySelector('.product'));
        fetch('edit-3-api.php', {
                method: 'POST',
                body: fd
            })
            .then(r => r.text())
            .then(obj => {
                console.log(obj)
            })
        Swal.fire({
            icon: 'success',
            title: '已完成修改',
            showConfirmButton: false,
            timer: 1000,
        });
        setTimeout('location.href="order-back.php"', 900)
    }

</script>
<?php include '../yeh/parts/html-foot.php'; ?>