<?php require __DIR__ . '/parts/admin-req.php'; ?>
<?php require __DIR__ . '/parts/connect-db.php'; ?>
<?php
$pageName = "members";

$perPage = 10;

$find = isset($_GET['find']) ? $_GET['find'] : "";
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;

// echo $find;

$t_sql = "";
if ($find == "") {
    $t_sql = "SELECT COUNT(1) FROM `members`";
} else {
    // $t_sql = sprintf("SELECT * FROM `members` WHERE `mobile`LIKE "%s%"" , $find);
    $t_sql = "SELECT COUNT(1) FROM `members` WHERE `mobile` LIKE '".$find."%'" ;
}

// print_r($t_sql);

$totalRows = $pdo->query($t_sql)->fetch(PDO::FETCH_NUM)[0];

// echo $totalRows ;

$totalPages = ceil($totalRows / $perPage);

$row = [];

if ($totalRows) {
    if ($page < 1) {
        header('Location: ?page=1');
        exit;
    }
    if ($page > $totalPages) {
        header('Location: ?page=' . $totalPages);
        exit;
    }

    // // 在SQL資料庫中該page要選取的資料範圍(沒有find)
    if ($find == "") {
        $sql = sprintf(
            "SELECT * FROM `members` ORDER BY `member_sid` DESC LIMIT %s, %s",
            ($page - 1) * $perPage,
            $perPage
        );
    } else {
    //     $sql = sprintf(
    //         "SELECT * FROM `members` ORDER BY `member_sid` WHERE `name` LIKE %s DESC LIMIT %s, %s",
    //         $find,
    //         ($page - 1) * $perPage,
    //         $perPage
    //     );
        //  $pageIndex = ($page - 1) * $perPage;
        //  $sql = "SELECT * FROM `members` ORDER BY `member_sid` WHERE `mobile` LIKE'".$find."%' DESC LIMIT "
        //  .$pageIndex.",".$perPage.""; 
        $sql1 = "SELECT * FROM `members` WHERE `mobile` LIKE '".$find."%'"."ORDER BY `member_sid` DESC";
        $sql2 = sprintf(" LIMIT %s, %s",($page - 1) * $perPage, $perPage);
        $sql = $sql1.$sql2;
        
    }
    // echo $sql;
    $row = $pdo->query($sql)->fetchAll();
    // print_r($row);
}

?>
<?php require __DIR__ . '/parts/html-head.php'; ?>
<?php require __DIR__ . '/parts/styles.php'; ?>
<?php require __DIR__ . '/parts/nav.php'; ?>
<div class="container">
    <!-- pagination -->
    <div class="row  mt-5 mx-auto"></div>
    <h4 class="text-center">會員資料列表</h4>
    <div class="col d-flex justify-content-between">
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li class="page-item <?= 1 == $page ? 'disabled' : '' ?>">
                    <a class="page-link" href="?page=<?= $page - 1 ?>">
                        <i class="fa-solid fa-circle-arrow-left"></i>
                    </a>
                </li>
                <!-- 用for生成pagination並設定連結 -->
                <!-- 避免頁碼連結過多 最常只取前5頁~後5頁 -->
                <?php for ($i = $page - 5; $i <= $page + 5; $i++) :
                    if ($i >= 1 and $i <= $totalPages) :
                ?>
                        <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                            <a class="page-link" href="?page=<?= $i ?>&find=<?= $find ?>"><?= $i ?></a>
                        </li>
                <?php
                    endif;
                endfor; ?>
                <li class="page-item <?= $totalPages == $page ? 'disabled' : '' ?>">
                    <a class="page-link" href="?page=<?= $page + 1 ?>">
                        <i class="fa-solid fa-circle-arrow-right"></i>
                    </a>
                </li>
            </ul>
        </nav>
        <div>
        <input type="text" id="find" name="find">
            <button type="button" class="btn btn-secondary" onclick="find()">
                以手機搜尋
            </button>
        
        <a href="member-insert-form.php">
            <button type="button" class="btn btn-primary">
                新增資料
            </button>
        </a>
        </div>
    </div>
    <!-- tables -->
    <div class="row">
        <div class="col">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th scope="col">
                            <i class="fa-solid fa-trash-can"></i>
                        </th>
                        <th scope="col">#</th>
                        <th scope="col">姓名</th>
                        <th scope="col">手機</th>
                        <th scope="col">電子信箱</th>
                        <th scope="col">生日</th>
                        <th scope="col">地址</th>
                        <th scope="col">暱稱</th>
                        <!-- <th scope="col">會員等級</th>
                    <th scope="col">高度總計</th> -->
                        <th scope="col">頭像</th>
                        <th scope="col">創建時間</th>
                        <th scope="col">訂單</th>
                        <th scope="col">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($row as $r) : ?>
                        <tr>
                            <td>
                                <a href="javascript: delete_it(<?= $r['member_sid'] ?>)">
                                    <i class="fa-solid fa-trash-can"></i>
                                </a>
                            </td>
                            <td><?= $r['member_sid'] ?></td>
                            <td><?= htmlentities($r['name']) ?></td>
                            <td><?= $r['mobile'] ?></td>
                            <td><?= $r['email'] ?></td>
                            <td><?= $r['birthday'] ?></td>
                            <td><?= htmlentities($r['address']) ?></td>
                            <td><?= htmlentities($r['nickname']) ?></td>
                            <!-- <td><?= $r['member_level'] ?></td>
                        <td><?= $r['total_height'] ?></td> -->
                            <td>
                                <?php if (!empty($r['avatar'])) : ?>
                                    <div class="previewbox">
                                        <img id="preview2" src="./avatars/<?= $r['avatar'] ?>" alt="">
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td><?= $r['created_at'] ?></td>
                            <td><a href="member-order.php?member_sid=<?= $r['member_sid'] ?>&page=<?= $page ?>&find=<?= $find ?>">瀏覽</a></td>
                            <td>
                                <a href="member-edit-form.php?member_sid=<?= $r['member_sid'] ?>&page=<?= $page ?>">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>

            </table>
        </div>
    </div>

</div>
</div>
</div>
<?php require __DIR__ . '/parts/scripts.php'; ?>
<script>
    function delete_it(member_sid) {
        if (confirm(`是否刪除#${member_sid}的資料?`)) {
            location.href = `member_delete.php?member_sid=${member_sid}`;
        }
    }

    function find(){
        let find = document.querySelector("#find").value;
        console.log(find);
        location.href = `members-list.php?find=${find}`;
    }
</script>
<?php require __DIR__ . '/parts/html-foot.php'; ?>