<?php require '../yeh/parts/connect-db.php';
$pageName = 'room';



$sql = sprintf(
    "SELECT * FROM `room` ORDER BY `room_sid` DESC"
);
// $rows = [];
$rows = $pdo->query($sql)->fetchAll();

// echo json_encode($rows,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
// exit;
?>
<?php include '../yeh/parts/html-head.php';?>
<?php include '../yeh/parts/nav-m.php';?>
<style>
    .form-select {
        width: 30%;
        display: inline-block;
    }

    .fa-cart-plus {
        color: white;
    }

    .card-text {
        font-size: 25px;
    }

    .form1 {
        display: none;
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
    <input type="text" name="s_date" id="s_date">
    <input type="text" name="e_date" id="e_date">
</form>
<div class="container">
    <div class="row">
        <nav aria-label="Page navigation example">
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
        </nav>
        <?php foreach ($rows as $r) : ?>

            <div class="card" style="width: 20rem;">
                <img src="../wei/uploads/<?= $r['room_img'] ?>" class="card-img-top">
                <div class="card-body">
                    <h5 class="card-title"><?= $r['room_name'] ?></h5>
                    <p class="card-text"><?= $r['room_details'] ?></p>
                    <div>
                        <p class="card-text">
                            <i class="fa-solid fa-dollar-sign"></i>
                            <?= $r['room_price'] ?>
                        </p>
                        <label for="start">入住：</label>
                        <input type="date" id="start" name="start">
                        <br>
                        <label for="end">離開：</label>
                        <input type="date" id="end" name="end">
                        <br>
                        <label for="">人數：</label>
                        <select class="form-select">
                            <?php for ($i = 1; $i <= 10; $i++) : ?>
                                <option value="<?= $i ?>"><?= $i ?></option>
                            <?php endfor; ?>
                        </select>
                        <button type="button" class="btn btn-primary" data_sid="<?= $r['room_sid'] ?>" onclick="addToCar(event)"><i class="fa-solid fa-cart-plus"></i></button>
                    </div>
                </div>

            </div>

        <?php endforeach ?>

    </div>
</div>



<?php include '../yeh/parts/scripts.php';?>
<script>
    function addToCar(event) {
        let btnE = event.currentTarget;
        //POST的sid
        let sid = btnE.getAttribute("data_sid");
        //POST的數量
        let qty = btnE.parentNode.querySelector('.form-select').value;
        //POST的日期
        let s_date = document.querySelector('#s_date');
        let e_date = document.querySelector('#e_date');

        let fs = document.querySelector('#sid');
        let fq = document.querySelector('#qty');
        let start = btnE.parentNode.querySelector('#start');
        let end = btnE.parentNode.querySelector('#end');
        fs.value = sid;
        fq.value = qty;
        s_date.value = start.value;
        e_date.value = end.value;
        let fd = new FormData(document.querySelector('.form1'));
        let cartNum = 0;
        let badge = document.querySelector('.badge');
        // 對日期的判斷
        if (start.value == 0 || end.value == 0) {
            Swal.fire(
                '請選擇日期',
                '',
                'error'
            )
        } else {
            //日期不能前大後小
            if (start.value.split('-').join('') - end.value.split('-').join('') >= 0) {
                Swal.fire(
                    '請選擇正確日期',
                    '',
                    'error'
                )
            } else {
                fetch('./cart-api/roomCart.php', {
                        method: "POST",
                        body: fd
                    })
                    .then(r => r.json())
                    .then(data => {
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
        }
    }
    // fetch('./cart-api/proCart.php')
    //     .then(r => r.json())
    //     .then(function(data) {
    //         count(data)
    //         console.log(data)
    //     });
</script>



<?php include '../yeh/parts/html-foot.php';?>