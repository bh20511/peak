<?php require '../yeh/parts/connect-db.php';
$pageName = 'campaign';


$sql = sprintf(
    "SELECT * FROM `campaign` ORDER BY `sid` DESC"
);
// $rows = [];
$rows = $pdo->query($sql)->fetchAll();


?>
<?php include '../yeh/parts/html-head.php';?>
<?php include '../yeh/parts/nav-m.php';?>
<form class="form1">
    <input type="text" name="sid" id="sid">
    <input type="text" name="qty" id="qty">
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
            <div class="card" style="width: 18rem;">
                <img src="./imgs/<?= $r['mainImage'] ?>" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title"><?= $r['name'] ?></h5>
                    <div>
                        <p class="card-text">
                            <i class="fa-solid fa-dollar-sign"></i>
                            <?= $r['price'] ?>
                        </p>
                        <select class="form-select">
                            <?php for ($i = 1; $i <= 10; $i++) : ?>
                                <option value="<?= $i ?>"><?= $i ?></option>
                            <?php endfor; ?>
                        </select>
                        <button type="button" class="btn btn-primary" data_sid="<?= $r['sid'] ?>" onclick="addToCar(event)"><i class="fa-solid fa-cart-plus"></i></button>
                    </div>
                </div>

            </div>
        <?php endforeach ?>
    </div>
</div>
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
        fetch('./cart-api/camCart.php', {
                method: "POST",
                body: fd
            })
            .then(r => r.json())
            .then(function(data){
                count(data)
                console.log(data)
            }
            )
        Swal.fire({
            icon: 'success',
            title: '已加入購物車',
            showConfirmButton: false,
            timer: 1000,
        });

    }
</script>



<?php include '../yeh/parts/scripts.php';?>
<?php include '../yeh/parts/html-foot.php';?>