<?php
require '../yeh/parts/admin-req.php';
require '../yeh/parts/connect-db.php';
$pageName = 'room_list';
?>
<?php require '../yeh/parts/html-head.php'; ?>
<?php include '../yeh/parts/nav.php'; ?>

<?php
$M_rows = [];
$M_sql = "SELECT * FROM `mountain` ";

$M_rows = $pdo->query($M_sql)->fetchAll();

$L_rows = [];
$L_sql = "SELECT * FROM `location`";

$L_rows = $pdo->query($L_sql)->fetchAll();

?>


<div class="container">
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">新增房型資料</h5>
                    <form name="form1" onsubmit="checkForm(); return false">
                        <div class="mb-3">
                            <label for="name" class="form-label">房型名稱</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="img" class="form-label">上傳照片</label>
                            <input type="file" class="form-control" id="img" name="img" multiple accept="image/png,image/jpeg">
                        </div>
                        <img src="" alt="" id="pic" style="width: 300px;">
                        <div class="mb-3">
                            <label for="location" class="form-label">地區</label>
                            <select name="location" id="location" class="form-select">
                                <option selected>請選擇地區</option>
                                <?php foreach ($L_rows as $L_r) : ?>
                                    <option value="<?= $L_r['sid'] ?>">
                                        <?= $L_r['name'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="mountain" class="form-label">山名</label>
                            <select name="mountain" id="mountain" class="form-select">
                                <option selected value="">請選擇山名</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="startdate" class="form-label">開始日期</label>
                            <input type="date" class="form-control" id="startdate" name="startdate">
                        </div>
                        <div class="mb-3">
                            <label for="enddate" class="form-label">結束日期</label>
                            <input type="date" class="form-control" id="enddate" name="enddate">
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label">價格</label>
                            <input type="text" class="form-control" id="price" name="price">
                        </div>
                        <div class="mb-3">
                            <label for="qty" class="form-label">數量</label>
                            <input type="text" class="form-control" id="qty" name="qty">
                        </div>
                        <div class="mb-3">
                            <label for="details" class="form-label">房型介紹</label>
                            <textarea class="form-control" name="details" id="details" cols="50" rows="3"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary" id="sweet">送出</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
<?php include '../yeh/parts/scripts.php'; ?>
<script>
    function checkForm() {
        const fd = new FormData(document.form1);

        //不透過form直接送出 需要給method,body
        fetch('upload-api.php', {
                method: 'POST',
                body: fd
            })
            .then(r => r.json())
            .then(obj => {
                console.log(obj)
                if (!obj.success) {
                    console.log(obj.error);
                } else {
                    Swal.fire({
                        icon: 'success',
                        title: '房型新增成功',
                        showConfirmButton: false,
                        timer: 2000
                    })
                    setTimeout("window.location.href = 'list.php';", 2000);

                }
            })
    }

    const pic = document.querySelector("#pic");
    const img = document.querySelector("#img");
    img.addEventListener("change", (event) => {
        const photo = event.target.files[0];
        pic.src = URL.createObjectURL(photo)
    });

    const selLocation = document.querySelector("#location");
    const selMountain = document.querySelector("#mountain");


    selLocation.addEventListener("change", event => {
        selMountain.options.length = 0;
        const district = selLocation.options[selLocation.selectedIndex].value;
        console.log(district)
        let fd = new FormData(document.form1)
        fetch('select-api.php', {
                method: 'POST',
                body: fd
            })
            .then(r => r.json())
            .then(obj => {
                console.log(obj)
                obj.forEach(element => {
                    const {
                        mountain_name,
                        mountain_sid
                    } = element;
                    console.log(element);
                    selMountain.options.add(new Option(mountain_name, mountain_sid))
                });
            })

    })
</script>
<?php include  '../yeh/parts/html-foot.php'; ?>