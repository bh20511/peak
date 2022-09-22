<?php require __DIR__ . '/parts/connect_db2.php';
$pageName = 'insert';
?>
<?php require __DIR__ . '/parts/html-head.php'; ?>
<?php include __DIR__ . '/parts/navbar.php'; ?>
<div class="container">
    <div class="row">
        <div class="col-lg-6">
            <div class="card">

                <div class="card-body">
                    <h5 class="card-title">新增店點資料</h5>

                    <img id="myimg" src="" alt="" width="300">

                    <form name="form1" onsubmit="checkForm(); return false;">
                        <input type="file" name="single" accept="image/png,image/jpeg" id="imgg">
                        <div class="mb-3">
                            <label for="name" class="form-label">店點名稱</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label">店點地址</label>

                            <textarea class="form-control" name="address" id="address" cols="50" rows="3"></textarea>
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


    function checkForm() {
        const fd = new FormData(document.form1);
       
        fetch(`1add_store_api.php`, {
            method: 'POST',
            body: fd
        }).then(r => r.json()).then(obj => {
            console.log(obj);
            alert("新增完成");
            location.href = "1add_store.php";
        })
    }
</script>


<?php include __DIR__ . '/parts/html-foot.php'; ?>