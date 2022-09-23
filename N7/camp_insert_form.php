<?php
require '../yeh/parts/admin-req.php';
require '../yeh/parts/connect-db.php';
$pageName = 'camp_insert_form';
?>

<?php require  '../yeh/parts/html-head.php'; ?>
<?php include  '../yeh/parts/nav.php'; ?>

<?php
$sqlct = "SELECT * FROM `campaign_type`";
$rowsct = $pdo->query($sqlct)->fetchAll();

$sqllo = "SELECT * FROM `location`";
$rowslo = $pdo->query($sqllo)->fetchAll();
?>

<div class="container">
    <div class="row">
        <div class="col-lg-6">
            <button type="button" class="btn btn-info <?= $page_name == 'camp_list' ? 'active' : '' ?>">
                <a class="nav-link" href="camp_list.php">活動列表</a>
            </button>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">新增活動資料</h5>

                    <form name="form1" onsubmit="checkForm(); return false">
                        <div class="mb-3">
                            <label for="name" class="form-label">活動名稱</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>

                        <div class="mb-3">
                            <label for="location_sid" class="form-label">活動地點</label>
                            <select class="form-select" name="location_sid" id="location_sid" aria-label="Default select example">
                                <option selected>請選擇地點</option>
                                <?php foreach ($rowslo as $rlo) : ?>
                                    <option value="<?= $rlo['sid'] ?>">
                                        <?= $rlo['name'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="campaign_type_sid" class="form-label">活動分類</label>
                            <select class="form-select" name="campaign_type_sid" id="campaign_type_sid" aria-label="Default select example">
                                <option selected>請選擇分類</option>
                                <?php foreach ($rowsct as $rct) : ?>
                                    <option value="<?= $rct['sid'] ?>">
                                        <?= $rct['name'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>

                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label">活動售價</label>
                            <input type="number" class="form-control" id="price" name="price">
                        </div>
                        <div class="mb-3">
                            <label for="camp_startdate" class="form-label">活動起始日</label>
                            <input type="date" class="form-control" id="camp_startdate" name="camp_startdate">
                        </div>
                        <div class="mb-3">
                            <label for="camp_enddate" class="form-label">活動結束日</label>
                            <input type="date" class="form-control" id="camp_enddate" name="camp_enddate">
                        </div>
                        <div class="mb-3">
                            <label for="brife_describe" class="form-label">活動簡介</label>
                            <textarea class="form-control" name="brife_describe" id="brife_describe" cols="50" rows="5"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="schedule_describe" class="form-label">行程規劃</label>
                            <textarea class="form-control" name="schedule_describe" id="schedule_describe" cols="50" rows="5"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="qty" class="form-label">活動庫存</label>
                            <input type="number" class="form-control" id="qty" name="qty">
                        </div>

                        <div class="mb-3">
                            <label for="mainImage" class="form-label">活動主圖</label>
                            <img class="theimage" id="mainImage" src="" alt="" width="300">
                            <input type="file" class="form-control theimage1" id="mainImage1" name="mainImage" accept="image/png,image/jpeg">
                        </div>

                        <div class="mb-3">
                            <label for="bigImage" class="form-label">活動大圖</label>
                            <img class="theimage" id="bigImage" src="" alt="" width="300">
                            <input type="file" class="form-control theimage1" id="bigImage1" name="bigImage" accept="image/png,image/jpeg">
                        </div>

                        <div class="mb-3">
                            <label for="detailImage" class="form-label">活動細圖</label>
                            <img class="theimage" id="detailImage" src="" alt="" width="300">
                            <input type="file" class="form-control theimage1" id="detailImage1" name="detailImage" accept="image/png,image/jpeg">
                        </div>

                        <button type="submit" class="btn btn-primary">Submit</button>
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

        for (let k of fd.keys()) {
            console.log(`${k}: ${fd.get(k)}`);
        }
        fetch('camp_insert_api.php', {
                method: 'POST',
                body: fd
            })
            .then(r => r.json())
            .then(obj => {
                console.log(obj);
                if (!obj.success) {
                    alert(obj.error)
                } else {
                    alert('新增成功')
                    location.href = 'camp_list.php';
                }
            })
    }

    let imgg = document.querySelector("#mainImage1");
    let myimg = document.querySelector("#mainImage");
    let imggb = document.querySelector("#bigImage1");
    let myimgb = document.querySelector("#bigImage");
    let imggd = document.querySelector("#detailImage1");
    let myimgd = document.querySelector("#detailImage");
    imgg.addEventListener("change", (e) => {
        const file = e.target.files[0];
        myimg.src = URL.createObjectURL(file)
    })
    imggb.addEventListener("change", (e) => {
        const file = e.target.files[0];
        myimgb.src = URL.createObjectURL(file)
    })
    imggd.addEventListener("change", (e) => {
        const file = e.target.files[0];
        myimgd.src = URL.createObjectURL(file)
    })
</script>
<?php include  '../yeh/parts/html-foot.php'; ?>