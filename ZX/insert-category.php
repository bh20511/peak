<?php require '../yeh/parts/admin-req.php';?>
<?php require '../yeh/parts/connect-db.php'; ?>
<?php
$pagename = 'insert-category';
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
                    <div class="mb-3">
                        <label for="product_category" class="form-label">種類</label>
                        <input type="text" class="form-control" id="product_category" name="product_category">
                    </div>


                    <div class="mb-3">
                        <label for="gender" class="form-label">性別</label>
                        <input type="text" class="form-control" id="gender" name="gender">
                    </div>


                    <button type="submit" class="btn btn-primary">送出檔案</button>


                </form>
            </div>


        </div>
    </div>
</div>
<?php


?>


<?php include '../yeh/parts/scripts.php'; ?>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function checkForm() {
        const fd = new FormData(document.form1);
        fetch('insert-category-api.php', {
            method: 'POST',
            body: fd,
        }).then(r => r.json()).then(obj => {
            if (!obj.success) {
                Swal.fire({
                    icon: 'error',
                    title: '新增失敗',
                    text: 'Something went wrong!',
                })

            } else {
                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: '儲存成功',
                    showConfirmButton: false,
                    timer: 1500
                })
                setTimeout("location.href = 'list-category.php';", 1500);



            }
        })
    }
</script>
<?php include '../yeh/parts/html-foot.php'; ?>