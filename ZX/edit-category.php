<?php require '../yeh/parts/admin-req.php'; ?>
<?php require '../yeh/parts/connect-db.php'; ?>
<?php
$pagename = 'edit-category';



$sid = isset($_GET['sid']) ? intval($_GET['sid']) : 0;
if (empty($sid)) {
    header('Location: list.php');
    exit;
}

$sql = "SELECT * FROM `product_category` WHERE product_category_sid=$sid";
$r = $pdo->query($sql)->fetch();
if (empty($r)) {
    header('Location: list-product.php');
    exit;
}



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
                <form name="form1" onsubmit="checkForm();return false;">

                    <input type="hidden" name="product_category_sid" value="<?= $r['product_category_sid'] ?>">

                    <div class="mb-3">
                        <label for="product_category" class="form-label">種類</label>
                        <input type="text" class="form-control" id="product_category" name="product_category" value="<?= $r['product_category'] ?>">
                    </div>

                    <div class="mb-3">
                        <label for="gender" class="form-label">性別</label>
                        <input type="text" class="form-control" id="gender" name="gender" value="<?= $r['gender'] ?>">
                    </div>


                    <button type="submit" class="btn btn-primary">送出檔案</button>


                </form>
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







    function checkForm() {
        const fd = new FormData(document.form1);
        fetch('edit-category-api.php', {
            method: 'POST',
            body: fd,
        }).then(r => r.json()).then(obj => {
            if (!obj.success) {
                console.log(obj.postData)
                Swal.fire({
                    icon: 'error',
                    title: '修改失敗，沒更改到資料',
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
                setTimeout("location.href = 'list-category.php';", 1500);

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