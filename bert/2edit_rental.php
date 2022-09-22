<?php require __DIR__ . '/parts/connect_db2.php';
$pageName = 'edit';

$rental_product_sid = isset($_GET['rental_product_sid']) ? intval($_GET['rental_product_sid']) : 0;
if(empty($rental_product_sid)){
    header('Location: 2list_rental.php');
    exit;
}

$sql = "SELECT * FROM rental 
JOIN product_category 
ON product_category_sid = sid 
JOIN brand
ON brand.brand_sid= rental.brand_sid 
WHERE rental_product_sid= $rental_product_sid
";

$r = $pdo->query($sql)->fetch();
if(empty($r)){
    header('Location: 2list_rental.php');
    exit;
}

$sql2 = "SELECT * from product_category";
$rows = $pdo->query($sql2)->fetchAll();

$sql3 = "SELECT * from brand";
$rows2 = $pdo->query($sql3)->fetchAll();

?>
<?php require __DIR__ . '/parts/html-head.php'; ?>
<?php include __DIR__ . '/parts/navbar.php'; ?>
<div class="container">
    <div class="row">
        <div class="col-lg-6">
            <div class="card"> 

                <div class="card-body">
                    <h5 class="card-title">修改資料</h5>
                    <img src="./rental/<?= $r['rental_img'] ?>" alt="" style="width:100px;" id="myimg">

                    
                    <form name="form1" onsubmit="checkForm(); return false;" novalidate>
                        <input type="hidden" name="rental_product_sid" value="<?= $r['rental_product_sid'] ?>">

                        <input type="file" name="single" accept="image/png,image/jpeg" id="imgg">
                         
                        <div class="mb-3">
                            <label for="name" class="form-label">租借品名</label>
                            <input type="text" class="form-control" id="rental_product_name" name="rental_product_name" required value="<?= htmlentities($r['rental_product_name']) ?>">
                        </div>

                        <div class="mb-3">
                            <label for="product_category_sid" class="form-label">租借種類</label>
                            <select name="product_category_sid" id="product_category_sid">
                                <?php foreach ($rows as $x) : ?>
                                <option value="<?= $x['sid'] ?> "  <?= $x['sid'] == $r['product_category_sid']  ? 'selected' : ''  ;   ?>    >
                                <?= $x['product_category'] ?> 
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="brand_sid" class="form-label">租借品牌</label>
                            <select name="brand_sid" id="brand_sid">
                                <?php foreach ($rows2 as $q) : ?>
                                <option value="<?= $q['brand_sid'] ?> "  <?= $q['brand_sid'] == $r['brand_sid']  ? 'selected' : ''  ;   ?>    >
                                <?= $q['brand_name'] ?> 
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="name" class="form-label">每日租價</label>
                            <input type="text" class="form-control" id="rental_price" name="rental_price" required value="<?= htmlentities($r['rental_price']) ?>">
                        </div>

                        <div class="mb-3">
                            <label for="name" class="form-label">數量</label>
                            <input type="text" class="form-control" id="rental_qty" name="rental_qty" required value="<?= htmlentities($r['rental_qty']) ?>">
                        </div>

                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
<?php include __DIR__ . '/parts/scripts.php'; ?>
<script>
    let imgg = document.querySelector("#imgg");
    let myimg = document.querySelector("#myimg");
    imgg.addEventListener("change",(e)=>{
        const file = e.target.files[0];
        myimg.src = URL.createObjectURL(file)
    })

    function checkForm(){
    
        const fd = new FormData(document.form1);
        fetch('2edit_rental_api.php', {
            method: 'POST',
            body: fd
        }).then(r=>r.json()).then(obj=>{
            console.log(obj);
            if(! obj.success){
                alert(obj.error);
            } else {
                alert('修改成功')
                location.href = '2list_rental.php';
            }
        })


    }
</script>
<?php include __DIR__ . '/parts/html-foot.php'; ?>