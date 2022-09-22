<?php require __DIR__ . '/parts/connect_db2.php';
$pageName = 'edit';

$store_sid = isset($_GET['store_sid']) ? intval($_GET['store_sid']) : 0;
if(empty($store_sid)){
    header('Location: 1list_store.php');
    exit;
}

$sql = "SELECT * FROM store WHERE store_sid=$store_sid";
$r = $pdo->query($sql)->fetch();
if(empty($r)){
    header('Location: 1list_store.php');
    exit;
}



?>
<?php require __DIR__ . '/parts/html-head.php'; ?>
<?php include __DIR__ . '/parts/navbar.php'; ?>
<div class="container">
    <div class="row">
        <div class="col-lg-6">
            <div class="card"> 

                <div class="card-body">
                    <h5 class="card-title">修改資料</h5>
                    <img src="./store/<?= $r['store_img'] ?>" alt="" style="width:100px;" id="myimg">

                    
                    <form name="form1" onsubmit="checkForm(); return false;" novalidate>
                        <input type="hidden" name="store_sid" value="<?= $r['store_sid'] ?>">
                        <input type="file" name="single" accept="image/png,image/jpeg" id="imgg">
                         
                        <div class="mb-3">
                            <label for="name" class="form-label">店名</label>
                            <input type="text" class="form-control" id="store_name" name="store_name" required value="<?= htmlentities($r['store_name']) ?>">
                        </div>
                        
                        <div class="mb-3">
                            <label for="store_address" class="form-label">店址</label>

                            <textarea class="form-control" name="store_address" id="store_address" 
                            cols="50" rows="3"><?= $r['store_address'] ?></textarea>
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
        fetch('1edit_store_api.php', {
            method: 'POST',
            body: fd
        }).then(r=>r.json()).then(obj=>{
            console.log(obj);
            if(! obj.success){
                alert(obj.error);
            } else {
                alert('修改成功')
                location.href = '1list_store.php';
            }
        })


    }
</script>
<?php include __DIR__ . '/parts/html-foot.php'; ?>