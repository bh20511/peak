<?php
require '../yeh/parts/admin-req.php';
require '../yeh/parts/connect-db.php';
$pageName = 'edit';


$sid = isset($_GET['room_sid']) ? intval($_GET['room_sid']) : 0;
if (empty($sid)) {
    header('Location:list.php');
    exit;
}

$sql = "SELECT * FROM room 
JOIN mountain ON mountain.mountain_sid=room.mountain_sid
JOIN location ON location.sid=room.location_sid
WHERE `room_sid`=$sid";

$r = $pdo->query($sql)->fetch();
if (empty($r)) {
    header('Location:list.php');
    exit;
}

?>

<?php
$M_rows = [];

$M_sid = isset($_POST['mountain_sid']) ? intval($_POST['mountain_sid']) : 0;

$M_sql = "SELECT * FROM `mountain` JOIN room ON room.mountain_sid=mountain.mountain_sid WHERE mountain_sid=$M_sid";

// echo $M_sql;

// $M_rows = $pdo->query($M_sql)->fetchAll();
$test = "SELECT * FROM `mountain` 
JOIN `location` 
ON location.sid=mountain.location_sid
where ";

$L_rows = [];
$L_sql = "SELECT * FROM `location`";

$L_rows = $pdo->query($L_sql)->fetchAll();

?>

<?php require  '../yeh/parts/html-head.php'; ?>
<?php include  '../yeh/parts/nav.php'; ?>
<div class="container">
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"> 修改房型資料</h5>
                    <form name="form1" onsubmit="checkForm(); return false">
                        <input type="hidden" name="room_sid" value="<?= $r['room_sid'] ?>">
                        <div class="mb-3">
                            <img src="uploads/<?= $r['room_img'] ?>" alt="" id="pic" style="width: 300px;display:flex;margin:auto ;"><br>
                            <label for="img" class="form-label">上傳照片</label>
                            <input type="file" class="form-control" id="img" name="img" multiple accept="image/png,image/jpeg">
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">房型名稱</label>
                            <input type="text" class="form-control" id="name" name="room_name" value="<?= htmlentities($r['room_name']) ?>">
                        </div>
                        <div class="mb-3">
                            <label for="location" class="form-label">地區</label>
                            <select name="location" id="location" class="form-select" aria-label="Default select example">
                                <?php foreach ($L_rows as $L_r) : ?>
                                    <option value="<?= $L_r['sid']  ?>" <?= $L_r['sid'] == $r['sid'] ? 'selected' : '' ?>>
                                        <?= $L_r['name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="mountain" class="form-label">山名</label>
                            <select name="mountain" id="mountain" class="form-select" aria-label="Default select example">
                                <option value="<?= $r['mountain_sid']  ?>"><?= $r['mountain_name'] ?></option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="startdate" class="form-label">開始日期</label>
                            <input type="date" class="form-control" id="startdate" name="startdate" value="<?= $r['room_start_date'] ?>">
                        </div>
                        <div class="mb-3">
                            <label for="enddate" class="form-label">結束日期</label>
                            <input type="date" class="form-control" id="enddate" name="enddate" value="<?= $r['room_end_date'] ?>">
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label">價格</label>
                            <input type="text" class="form-control" id="price" name="price" value="<?= $r['room_price'] ?>">
                        </div>
                        <div class="mb-3">
                            <label for="qty" class="form-label">數量</label>
                            <input type="text" class="form-control" id="qty" name="qty" value="<?= $r['room_qty'] ?>">
                        </div>
                        <div class="mb-3">
                            <label for="details" class="form-label">房型介紹</label>
                            <textarea class="form-control" name="details" id="details" cols="50" rows="3"><?= htmlentities($r['room_details']) ?>
                            </textarea>
                        </div>

                        <button type="submit" class="btn btn-primary" id="sweet">保存</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
<?php include  '../yeh/parts/scripts.php'; ?>
<script>
    function checkForm() {
        const fd = new FormData(document.form1);

        //不透過form直接送出 需要給method,body
        fetch('edit-api.php', {
                method: 'POST',
                body: fd
            })
            .then(r => r.json())
            .then(obj => {
                if (!obj.success) {
                    Swal.fire({
                        icon: 'error',
                        title: '房型修改失敗',
                        showConfirmButton: false,
                        timer: 2000
                    })
                    setTimeout("window.location.href = 'list.php';", 2500)
                } else {
                    Swal.fire({
                        icon: 'success',
                        title: '房型修改成功',
                        showConfirmButton: false,
                        timer: 2000
                    })
                    setTimeout("window.location.href = 'list.php';", 2000)
                }
            })
    }

    const img = document.querySelector("#img");
    const pic = document.querySelector("#pic");

    img.addEventListener("change", event => {
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
    selMountain.addEventListener("mouseover", event => {

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
<?php include '../yeh/parts/html-foot.php'; ?>