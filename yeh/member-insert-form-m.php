
<?php require __DIR__ . '/parts/connect-db.php'; ?>
<?php
$pageName = "members";
?>
<?php require __DIR__ . '/parts/html-head.php'; ?>
<?php require __DIR__ . '/parts/styles.php'; ?>
<?php require __DIR__ . '/parts/nav-m.php'; ?>

<div class="container">
    <div class="row mt-4">
        <div class="col-lg-6 mx-auto">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title text-center">新增會員資料</h4>
                    <form name="form1" onsubmit="checkForm(); return false;"  enctype="multipart/form-data" novalidate>
                        <div class="previewbox">
                            <img id="preview" src="" alt="">
                        </div>
                        <div class="mb-3">
                            <label for="formFile" class="form-label">上傳頭像</label>
                            <input class="form-control" type="file" id="formFile" name="single" accept="image/png,image/jpeg">
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">姓名</label>
                            <input type="text" class="form-control" id="name" name="name" value="陳力誠">
                        </div>
                        <div class="mb-3">
                            <label for="nickname" class="form-label">暱稱</label>
                            <input type="text" class="form-control" id="nickname" name="nickname" value="阿誠">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">密碼 (6 位數以上，並且至少包含 大寫字母、小寫字母、數字、符號 各一)</label>
                            <input type="password" class="form-control" id="exampleInputPassword1" name="password" value ="Chen123*">
                            <input type="checkbox" name="showpass" id="showpass" onclick="showPw()">
                            <label for="showpass">顯示密碼</label>
                        </div>

                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">密碼確認</label>
                            <input type="password" class="form-control" id="exampleInputPassword2">
                        </div>
                        <div class="mb-3">
                            <label for="mobile" class="form-label">手機號碼</label>
                            <input type="text" class="form-control" id="mobile" name="mobile" pattern="09\d{2}-?\d{3}-?\d{3}" value="0911223344">
                            <!-- pattern可以做regex的驗證 不用倒斜線直接 "" -->
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">電子信箱</label>
                            <input type="text" class="form-control" id="email" name="email" value="chen@test.com">
                        </div>
                        <div class="mb-3">
                            <label for="birthday" class="form-label">生日</label>
                            <input type="date" class="form-control" id="birthday" name="birthday">
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">地址</label>
                            <textarea name="address" class="form-control" id="address" cols="50" rows="3"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">新增資料</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require __DIR__ . '/parts/scripts.php'; ?>
<script>
    function checkForm() {
        const pass = document.getElementById("exampleInputPassword1");
        const pass2 = document.getElementById("exampleInputPassword2");
        if(pass.value !== pass2.value){
            alert("請輸入正確的確認密碼");
            return false;
        }

        const fd = new FormData(document.form1);
        fetch('member-insert-api-m.php', {
            method: 'POST',
            body: fd
        }).then(r => r.json()).then(obj => {
            console.log(obj);
            if (!obj.success) {
                alert(obj.error);
            } else {
                alert("新增資料成功");
                location.href = 'login-form-m.php';
            }
        })
    }

    function showPw() {
        let pass = document.getElementById("exampleInputPassword1");
        let pass2 = document.getElementById("exampleInputPassword2");
        if (pass.type === "password") {
            pass.type = "text";
            pass2.type = "text";
        } else {
            pass.type = "password";
            pass2.type = "password";
        }
    }

    function Preview() {
        const preview = document.querySelector("#preview");
        const getImg = document.querySelector("#formFile");

        getImg.addEventListener("change", (event)=>{
            const photo = event.target.files[0];
            preview.src = URL.createObjectURL(photo);
        })
    }
    Preview();

    function PreDisplay() {
        const preview = document.querySelector("#preview");
        const getImg = document.querySelector("#formFile");

        getImg.addEventListener("change", (event)=>{
            preview.style.width = "100%";
            preview.style.height = "100%";
            preview.style.objectFit = "cover";
        })
    }
    PreDisplay();

</script>
<?php require __DIR__ . '/parts/html-foot.php'; ?>