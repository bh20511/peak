<?php require '../yeh/parts/connect-db.php';

$pageName = 'order';

$order = "SELECT * FROM `order`";
$order_stmt = $pdo->query($order)->fetchAll();

?>
<?php include '../yeh/parts/html-head.php'; ?>
<?php include '../yeh/parts/nav-m.php'; ?>


<div class="container">
    <div class="row">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th scope="col">訂單編號</th>
                    <th scope="col">金額</th>
                    <th scope="col">詳細訂單</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($order_stmt as $o) : ?>
                    <tr>
                        <td><?= $o['order_num'] ?></td>
                        <td><?= $o['total'] ?></td>
                        <td><button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                                檢視訂單
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include '../yeh/parts/scripts.php'; ?>

<?php include '../yeh/parts/html-foot.php'; ?>