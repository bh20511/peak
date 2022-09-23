<?php require '../yeh/parts/admin-req.php'; ?>
<?php require '../yeh/parts/connect-db.php'; ?>
<?php
$pageName = 'edit-product';



$sid = isset($_GET['sid']) ? intval($_GET['sid']) : 0;
if (empty($sid)) {
    header('Location: list.php');
    exit;
}

$sql = "SELECT * FROM product WHERE product_sid=$sid";
$r = $pdo->query($sql)->fetch();
if (empty($r)) {
    header('Location: list-product.php');
    exit;
}

//取得當初的種類名稱
$sql = "SELECT `product_category_sid`,`product_category` 
            FROM product_category";
$rows = $pdo->query($sql)->fetchAll();



$sql2 = "SELECT * FROM `brand` ";
$rows2 = $pdo->query($sql2)->fetchAll();

?>






<?php require '../yeh/parts/html-head.php'; ?>


<style>
    .wrap {
        border-radius: 10px;
        border: 1px solid black;
        padding: 10px;
    }

    .uuu {
        border: 5px solid red;
    }
</style>

<?php include '../yeh/parts/nav.php'; ?>

<div class="container">
    <div class="row">
        <div class="col-6">



            <div class="wrap">





                <p>目前圖片</p>
                <img id="myimg" src="./picture/<?= ($r['picture']) ?>" alt="" width="300">

                <form name="form1" onsubmit="checkForm();return false;">


                    <input type="hidden" name="product_sid" value="<?= $r['product_sid'] ?>">


                    <input type="file" name="single" accept="image/png,image/jpeg" id="btn">
                    <div class="mb-3">
                        <label for="product_name" class="form-label">品名</label>
                        <input type="text" class="form-control" id="product_name" name="product_name" value="<?= htmlentities($r['product_name']) ?>">
                    </div>



                    <div class="mb-3">
                        <label for="product_category_sid" class="form-label">種類</label>
                        <br>
                        <select name="product_category_sid" id="product_category_sid">
                            <?php foreach ($rows as $x) : ?>
                                <option value="<?= $x['product_category_sid'] ?>" <?= $x['product_category_sid'] == $r['product_category_sid'] ? 'selected' : '' ?>>
                                    <?= $x['product_category'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>


                    <div class="mb-3">
                        <label for="brand_sid" class="form-label">品牌</label>
                        <br>
                        <select name="brand_sid" id="brand_sid">
                            <?php foreach ($rows2 as $q) : ?>
                                <option value="<?= $q['brand_sid'] ?>" <?= $q['brand_sid'] == $r['brand_sid'] ? 'selected' : '' ?>>
                                    <?= $q['brand_name'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>



                    <div class="mb-3">
                        <label for="product_price" class="form-label">價格</label>
                        <input type="text" class="form-control" id="product_price" name="product_price" value="<?= ($r['product_price']) ?>">
                    </div>
                    <div class="mb-3">
                        <label for="product_inventory" class="form-label">庫存</label>
                        <input type="text" class="form-control" id="product_inventory" name="product_inventory" value="<?= ($r['product_inventory']) ?>">
                    </div>
                    <div class="mb-3">
                        <label for="product_description" class="form-label">商品說明</label>
                        <input type="text" class="form-control" id="product_description" name="product_description" value="<?= ($r['product_description']) ?>">
                    </div>

                    <button type="submit" class="btn btn-primary">更改檔案</button>


                </form>

                <!-- <form name="form2" style="display:none">
                    <label for="">圖片</label>

                </form>
                <div>請先填寫以上欄位，再上傳圖檔</div>
                <button onclick="document.form2.single.click()"> 選檔案上傳圖檔</button>
                <img id="myimg" src="" alt="" width="300"> -->
            </div>



        </div>
    </div>
</div>



<?php

// //篩選圖片最新編號
// $select_sql =
//     "SELECT  `picture` FROM `product`  ORDER BY `sid` DESC LIMIT 1;";
// $pic_lastid = $pdo->query($select_sql)->fetch(PDO::FETCH_NUM)[0];
// echo $pic_lastid;
// //取代雙引號
// $pic_last_id = str_replace('"', '', $pic_lastid);
// //只取數字
// $pic_int_id = substr($pic_last_id, 2, 4);


// echo 'pg' . ($pic_int_id + 1);
// 
?>


<?php include '../yeh/parts/scripts.php'; ?>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // let sel = document.querySelector('#category');
    // let category_sid = document.querySelector('#product_category_sid');


    // console.log(category_sid.value);

    // sel.addEventListener('change', () => {
    //     let category_name = sel.options[sel.selectedIndex].value;
    //     console.log(category_name);
    //     console.log(category_name);
    //     if (category_name == '登山杖') {
    //         category_sid.value = 1;
    //     } else if (category_name == '帽子') {
    //         category_sid.value = 2;
    //     } else if (category_name == '鞋子') {
    //         category_sid.value = 3;
    //     } else if (category_name == '背包') {
    //         category_sid.value = 4;
    //     } else if (category_name == '護具') {
    //         category_sid.value = 5;
    //     } else if (category_name == '打火機') {
    //         category_sid.value = 6;
    //     } else if (category_name == '防水袋') {
    //         category_sid.value = 7;
    //     }
    // })



    // category_sid.value = category_name.innerText;


    const btn = document.querySelector('#btn');
    const pic = document.querySelector('#myimg');
    btn.addEventListener('change', () => {
        const photo = event.target.files[0];
        pic.src = URL.createObjectURL(photo);
    })




    function checkForm() {
        const fd = new FormData(document.form1);
        fetch('edit-product-api.php', {
            method: 'POST',
            body: fd,
        }).then(r => r.json()).then(obj => {
            if (!obj.success) {
                console.log(obj.postData)
                Swal.fire({
                    icon: 'error',
                    title: '修改失敗',
                    text: 'Something went wrong!',
                })

            } else {
                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: '修改成功',
                    showConfirmButton: false,
                    timer: 1500
                })
                setTimeout("location.href = 'list-product.php';", 1500);
                // document.form2.single.addEventListener('change', function() {
                //     console.log(this.files);
                //     const fd = new FormData(document.form2);
                //     fetch('upload.php', {
                //         method: 'POST',
                //         body: fd,
                //     }).then(r => r.json()).then(obj => {
                //         console.log(obj);
                //         if (obj.success) {
                //             myimg.src = './picture/' + obj.filename;
                //             Swal.fire({
                //                 position: 'top-end',
                //                 icon: 'success',
                //                 title: 'Your work has been saved',
                //                 showConfirmButton: false,
                //                 timer: 1500
                //             })
                //         }
                //     })
                // })
            }
        })
    }
</script>
<?php include '../yeh/parts/html-foot.php'; ?>