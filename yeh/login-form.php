<?php require __DIR__ . '/parts/connect-db.php'; ?>
<?php $pageName = "login";

if (!empty($_SESSION['admin'])) {
    header('Location: ../yeh/members-list.php');
    exit;
}
?>
<?php require __DIR__ . '/parts/html-head.php'; ?>
<?php require __DIR__ . '/parts/styles.php'; ?>
<?php require __DIR__ . '/parts/nav.php'; ?>

<div class="container">
    <div class="row mt-5">
        <div class="col-lg-6 mx-auto">
            <div class="card">
                <div class="card-body">
                    <H4 class="card-title text-center">管理者登入</H4>

                    <form name="loginForm" onsubmit="checkForm(); return false;">
                        <div class="mb-3">
                            <label for="account" class="form-label">帳號</label>
                            <input type="text" class="form-control" id="account" name="account">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">密碼</label>
                            <input type="password" class="form-control" id="password" name="password">
                            <input type="checkbox" name="showpass" id="showpass" onclick="showPw()">
                            <label for="showpass">顯示密碼</label>
                        </div>
                        <button type="submit" class="btn btn-primary">登入</button>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require __DIR__ . '/parts/scripts.php'; ?>

<script>
    async function checkForm() {

        const fd = new FormData(document.loginForm);

        const r = await fetch('login-api.php', {
            method: 'POST',
            body: fd
        });

        const obj = await r.json();
        if (obj.success) {
            alert("登入成功");
            // swal("登入成功!", "", "success");
            // location.href = 'members-list.php';
            if (<?= $_GET['from'] ?>) {
                location.href = '<?= $_GET['from'] ?>';
            } else {
                location.href = 'members-list.php';
            }
            // location.reload();

        } else {
            alert(obj.error);
        }

    }

    function showPw() {
        let pass = document.getElementById("password");
        if (pass.type === "password") {
            pass.type = "text";
        } else {
            pass.type = "password";
        }
    }
</script>
<?php require __DIR__ . '/parts/html-foot.php'; ?>