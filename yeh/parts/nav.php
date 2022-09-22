<div class="container">
    <nav class="navbar navbar-expand-lg bg-light">
        <div class="container-fluid">
            <a class="navbar-brand">管理後台</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link <?= $pageName=='members' ? 'active' : ''  ?>" href="../yeh/members-list.php">會員</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="list-product.php">商品</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">訂房</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">租借</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">活動</a>
                    </li>
                    <!-- <li class="nav-item">
                        <a class="nav-link" href="#">訂單</a>
                    </li> -->
                </ul>
                <ul class="navbar-nav mb-2 mb-lg-0">
                    <?php if (empty($_SESSION['admin'])) : ?>
                        <li class="nav-item">
                            <a class="nav-link <?= $pageName=='login' ? 'active' : ''  ?>" href="../yeh/login-form.php">登入</a>
                        </li>
                    <?php else : ?>
                        <li class="nav-item">
                        <a class="nav-link" ><?= $_SESSION['admin']['account'] ?></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../yeh/logout-api.php">登出</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
</div>