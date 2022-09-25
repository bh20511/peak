<?php require '../yeh/parts/connect-db.php';

$pageName = 'order';

$m_s = $_SESSION['member']['member_sid'];
$order = "SELECT * FROM `order` WHERE member_sid = $m_s ORDER BY `sid` DESC";
$order_stmt = $pdo->query($order)->fetchAll();

//商品
$sql = "SELECT * FROM `order`join `product_order` on order.order_num = product_order.order_num 
join product on product_order.products_sid= product.product_sid where order.member_sid=$m_s";
$product_order_product = $pdo->query($sql)->fetchAll();

//訂房
$sql2 = "SELECT * FROM `order`join `booking_order` on `order`.order_num = booking_order.order_num 
join room on booking_order.room_sid= room.room_sid where order.member_sid=$m_s";
$product_order_room = $pdo->query($sql2)->fetchAll();



//租借
$sql3 = "SELECT * FROM `order`join `rental_order` on order.order_num = rental_order.order_num 
join rental on rental_order.rental_sid= rental.rental_product_sid where order.member_sid=$m_s";
$product_order_retal = $pdo->query($sql3)->fetchAll();

//活動
$sql4 = "SELECT * FROM `order`join `campaign_order` on order.order_num = campaign_order.order_num 
join campaign on campaign_order.campaign_sid= campaign.sid where order.member_sid=$m_s";
$product_order_camp = $pdo->query($sql4)->fetchAll();




?>
<?php include '../yeh/parts/html-head.php'; ?>
<style>
    .accordion-button {
        display: flex;
    }

    .accordion-button div {
        width: 50%;
        /* color:red; */
        font-weight: 900;
    }

    div.accordion-body.product {
        background-color: #F3BF88;
    }

    div.accordion-body.room {
        background-color: #E9C3DC;

    }

    div.accordion-body.rental {
        background-color: #A0CEA8;

    }

    div.accordion-body.camp {
        background-color: #A2D7DD;

    }

    .accordion-he {
        border: 1px solid black;
        padding: 15px;
        border-radius: 10px;
        /* background-color: #91B493; */
        /* background-color: #c89b40; */
        background-color: #eedeb0;
        font-weight: 600;
    }
    .col{
        padding: 0 120px;
    }
    .ero{
        margin-top: 20px;
    }
    
</style>
<?php include '../yeh/parts/nav-m.php'; ?>


<!-- ---------------------- -->
<div class="container ero">
    <div class="row">
        <div class="col">
            <?php foreach ($order_stmt as $o) : ?>
                <div class="accordio" id="accordionExample">
                    <div class="accordion-item">
                        <h2 class="accordion-he" id="headingOne">
                            <button class="accordion-button" type=" button" data-bs-toggle="collapse" data-bs-target="#C<?= $o['order_num'] ?>" aria-expanded="false" aria-controls="collapseOne">
                                <div> 訂單編號 :<?= $o['order_num'] ?></div>
                                <div>金額 :<?= $o['total'] ?></div>
                                <div>訂單日期 :<?= $o['created_time'] ?></div>
                            </button>
                        </h2>
                        <div id="C<?= $o['order_num'] ?>" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">

                            <!-- -------------------------產品-------------------------- -->
                            <?php foreach ($product_order_product as $q) : ?>
                                <?php if ($o['order_num'] == $q['order_num']) : ?>
                                    <div class="accordion-body product">
                                        商品： <?= $q['product_name'] ?>
                                    </div>
                                    <div class="accordion-body product">
                                        數量： <?= $q['qty'] ?>
                                    </div>
                                    <div class="accordion-body product">
                                        總計金額 ：<?= $q['total']  ?>
                                    </div>

                                <?php endif; ?>
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
                                        人數： <?= $q['qty'] ?>
                                    </div>
                                    <div class="accordion-body room">
                                        總計金額 ：<?= $q['total']  ?>
                                    </div>

                                <?php endif; ?>
                            <?php endforeach; ?>




                            <!-- --------------------------租借------------------------- -->

                            <?php foreach ($product_order_retal as $q) : ?>
                                <?php if ($o['order_num'] == $q['order_num']) : ?>
                                    <div class="accordion-body rental">
                                        租借商品： <?= $q['rental_product_name'] ?>
                                    </div>
                                    <div class="accordion-body rental">
                                        數量： <?= $q['qty'] ?>
                                    </div>
                                    <div class="accordion-body rental">
                                        總計金額 ：<?= $q['total']  ?>
                                    </div>

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
    const btn = document.querySelector('#btn');
    btn.addEventListener('click', () => {

    })
</script>
<?php include '../yeh/parts/html-foot.php'; ?>