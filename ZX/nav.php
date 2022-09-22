<style>
    nav.navbar .nav-item .nav-link {
        margin: 0 10px;
    }

    nav.navbar .nav-item .nav-link.active {
        border-radius: 5px;
        background-color: #f00;
        color: #fff;
        font-weight: 700;
    }
</style>

<body>
    <nav class="navbar navbar-expand-lg bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">後台管理</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link " aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link <?= $pagename == 'product-list' ? 'active' : ''; ?>" href="./list-product.php">商品</a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link <?= $pagename == 'category-list' ? 'active' : ''; ?>" href="./list-category.php">種類</a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link <?= $pagename == 'brand-list' ? 'active' : ''; ?>" href="./list-brand.php">品牌</a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link <?= $pagename == 'insert-product' ? 'active' : ''; ?>" href="./insert-product.php">新增產品</a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link <?= $pagename == 'insert-category' ? 'active' : ''; ?>" href="./insert-category.php">新增產品種類</a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link <?= $pagename == 'insert-brand' ? 'active' : ''; ?>" href="./insert-brand.php">品牌</a>
                    </li>
                    <li class="nav-item ">


                    <li class="nav-item dropdown">

                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Action</a></li>
                            <li><a class="dropdown-item" href="#">Another action</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="#">Something else here</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                    </li>
                </ul>
                <form class="d-flex" role="search">

                    <button class="btn btn-outline-success" type="submit">登入</button>
                </form>
            </div>
        </div>
    </nav>