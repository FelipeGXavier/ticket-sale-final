<!DOCTYPE html>
<html lang="en">
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php require_once(PATH .  LINE_SEPARATOR .'public' . LINE_SEPARATOR . 'layout' . LINE_SEPARATOR . 'bootstrap.php') ?>
    <?php require_once(PATH .  LINE_SEPARATOR .'public' .  LINE_SEPARATOR . 'layout' .  LINE_SEPARATOR . 'menu.php') ?>
    <?php if ($_SESSION['user_type'] !== 0) header("Location: login"); ?>
    <?php if ($_SESSION['accept'] == false) header("Location: welcome"); ?>
</head>

<body>
    <main class="wrapper-menu">
        <div class="row d-flex justify-content-center">
            <div class="col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/stats">Voltar</a></li>
                    </ol>
                </nav>
                <div class="col-md-12 d-flex justify-content-center">
                    <div id="chart_div"></div>
                </div>
            </div>
        </div>
    </main>
</body>

<script type="text/javascript">
function fetchTrackingData() {
    return fetch("/ajax/sales_stats.php", {
        method: 'GET'
    });
}

google.charts.load('current', {
    'packages': ['corechart']
});

google.charts.setOnLoadCallback(drawChart);


function drawChart() {

    fetchTrackingData().then(res => res.json()).then(info => {

        const element = document.getElementById('chart_div');

        if (info == null || info['ticket_sales'].length == 0) {
            element.innerHTML = "Nenhuma Informação para exibir";
            return;
        }

        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Evento');
        data.addColumn('number', 'Vendas');
        data.addRows(info['ticket_sales']);

        var options = {
            'width': 800,
            'height': 600
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
        chart.draw(data, Object.assign(options, {
            title: 'Ingressos Vendidos por Evento'
        }));
    });



}
</script>

</html>