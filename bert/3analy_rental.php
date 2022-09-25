<?php require '../yeh/parts/admin-req.php'; ?>
<?php require '../yeh/parts/connect-db.php';
$pageName = 'rental_list';
?>
<?php require '../yeh/parts/html-head.php'; ?>
<?php include '../yeh/parts/nav.php'; ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>

<div class="container">
    <div class="row">
        <div class="buttons" style="width:120px; display:flex;">
            <button onclick="test()">查看租借商品種類數</button>
            <button onclick="test2()">查看租借商品平均價格</button>
            <button onclick="test3()">查看租借商品種類庫存</button>
        </div>
        <div style="width:350px;height:350px; border:1px solid black;">
            <canvas id="myChart" ></canvas>
        </div>
        <div style="width:350px;height:350px; border:1px solid black;">
            <canvas id="myChart2"></canvas>
        </div>
        <div style="width:350px;height:350px; border:1px solid black;">
            <canvas id="myChart3"></canvas>
        </div>
    </div>
</div>
    <script>
        function test(){
            fetch("3analy_api.php").then(r => r.json())
            .then(obj =>{
                const data = {
                            labels: obj.labels, // x軸資料
                            datasets: [{
                                label: '租借商品種類數',    //  上面標題
                                backgroundColor: 'rgb(255, 99, 132)',
                                borderColor: 'rgb(255, 99, 132)',
                                data: obj.data
                            }]
                };

                const config = {
                        type: 'bar',
                        data: data,
                };

                const myChart = new Chart(
                    document.getElementById('myChart'),
                    config
                );
            });
        };
        function test2(){
            fetch("3analy_price_api.php").then(r => r.json())
            .then(obj =>{
                const data = {
                            labels: obj.labels, // x軸資料
                            datasets: [{
                                label: '查看租借商品平均價格',    //  上面標題
                                backgroundColor: 'rgb(255, 99, 132)',
                                borderColor: 'rgb(255, 99, 132)',
                                data: obj.data
                            }]
                };

                const config = {
                        type: 'line',
                        data: data,
                };

                const myChart = new Chart(
                    document.getElementById('myChart2'),
                    config
                );
            });
        };
        function test3(){
            fetch("3analy_inventory_api.php").then(r => r.json())
            .then(obj =>{
                const data = {
                            labels: obj.labels, // x軸資料
                            datasets: [{
                                label: '查看租借商品總庫存',    //  上面標題
                                backgroundColor: 'rgb(255, 99, 132)',
                                borderColor: 'rgb(255, 99, 132)',
                                data: obj.data
                            }]
                };

                const config = {
                        type: 'radar',
                        data: data,
                };
                const mychart = document.getElementById('myChart3');
                mychart.height = 250;
                const myChart = new Chart(
                    mychart,
                    config
                );
            });
        };

    
    </script>

<?php include '../yeh/parts/scripts.php'; ?>
<?php include '../yeh/parts/html-foot.php'; ?>

