<style>
    .container .clicked {
        background-color: #0d6efd;
        color: white;
        border-radius: 10px;
    }

    .badge:empty {
        display: inline-block;
    }

    .badge {
        background-color: #17a2b8;
    }

    .none {
        display: none;
    }

    .nav-link {
        font-size: 20px;
        font-weight: 700;
    }

    .logo {
        font-size: 30px;
        font-weight: 900;
        color: #2A52BE;
        padding: 10px;
    }
    .bg{
        background-color: #eeeeee;
        border-radius: 0 0 20px 20px;
    }
</style>

<body>
    <div class="container">
        <nav class="navbar navbar-expand-lg  bg">
            <div class="container-fluid">
                <a href="../yeh/login-form.php" style="text-decoration: none;">
                    <h1 class="logo">爬山趣</h1>
                </a>
                <!-- <a class="navbar-brand">會員介面</a> -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link <?= $pageName == 'products' ? 'clicked' : ''  ?>" href="../YIRU/products.php">商品</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= $pageName == 'room' ? 'clicked' : '' ?>" href="../YIRU/room.php">訂房</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= $pageName == 'rental' ? 'clicked' : '' ?>" href="../YIRU/rental.php">租借</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= $pageName == 'campaign' ? 'clicked' : '' ?>" href="../YIRU/campaign.php">活動</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= $pageName == 'cart' ? 'clicked' : '' ?>" href="../YIRU/cart-list.php">購物車
                                <span class="badge"></span></a>
                        </li>
                        <?php if (empty($_SESSION['member'])) : ?>
                            <li class="nav-item">
                                <a class="nav-link <?= $pageName == 'order' ? 'clicked' : '' ?>" href="javascript:;" onclick="order()">訂單</a>
                            </li>
                        <?php else : ?>
                            <a class="nav-link <?= $pageName == 'order' ? 'clicked' : '' ?>" href="../YIRU/order.php">訂單</a>
                        <?php endif ?>
                        <li class="nav-item">
                            <a class="nav-link <?= $pageName == 'members' ? 'active' : ''  ?>" href="../yeh/member-info.php">資訊修改</a>
                        </li>
                    </ul>
                    <button type="button" class="btn btn-warning <?= $pageName == 'cart' ? "" : "none" ?>">清空購物車</button>
                    <ul class="navbar-nav mb-2 mb-lg-0">
                        <?php if (empty($_SESSION['member'])) : ?>
                            <li class="nav-item">
                                <a class="nav-link <?= $pageName == 'login' ? 'active' : ''  ?>" href="../yeh/login-form-m.php">登入</a>
                            </li>
                        <?php else : ?>
                            <li class="nav-item">
                                <a class="nav-link"><?= $_SESSION['member']['nickname'] ?></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="../yeh/logout-api-m.php">登出</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
    <script>
        function order() {
            Swal.fire({
                icon: 'error',
                title: '請先登入會員',
                showConfirmButton: false,
                timer: 1000,
            });
            setTimeout("location.href = '../yeh/login-form-m.php';", 1000);
        }
    </script>