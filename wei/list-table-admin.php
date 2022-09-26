    <div class="container">
        <div class="row">
            <div class="col">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">
                                <i class="fa-solid fa-trash-can"></i>
                            </th>
                            <th scope="col">房型編號</th>
                            <th scope="col">房型名稱</th>
                            <th scope="col">地區</th>
                            <th scope="col">山名</th>
                            <th scope="col">開始日期</th>
                            <th scope="col">結束日期</th>
                            <th scope="col">價格</th>
                            <th scope="col">數量</th>
                            <th scope="col">房型介紹</th>
                            <th scope="col">照片</th>
                            <th scope="col">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </th>
                        </tr>
                    </thead>
                    
                    <tbody>
                        <?php foreach ($rows as $r) : ?>
                            <tr>
                                <td>
                                    <a href="javascript: delete_it(<?= $r['room_sid'] ?>)">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </a>
                                </td>
                                <td><?= $r['room_sid'] ?></td>
                                <td><?= $r['room_name'] ?></td>
                                <td><?= $r['name'] ?></td>
                                <td><?= $r['mountain_name'] ?></td>
                                <td><?= $r['room_start_date'] ?></td>
                                <td><?= $r['room_end_date'] ?></td>
                                <td><?= $r['room_price'] ?></td>
                                <td><?= $r['room_qty'] ?></td>
                                <td><?= htmlentities($r['room_details']) ?></td>
                                <td><img src="uploads/<?= $r['room_img'] ?>" style="width:80px"></td>
                                <td>
                                    <a href="edit-form.php?room_sid=<?= $r['room_sid'] ?>">
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