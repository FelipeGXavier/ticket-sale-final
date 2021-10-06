<!DOCTYPE html>
<html lang="en">
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php require_once(PATH . '\public\layout\bootstrap.php') ?>
    <?php require_once(PATH . '\public\layout\menu.php') ?>
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
                <div class="row">
                    <div class="col-md-6">
                        <div id="chart_div_click"></div>
                    </div>
                    <div class="col-md-6">
                        <div id="chart_div_click_show"></div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>

<script type="text/javascript">
function fetchTrackingData() {
    return fetch("/ajax/tracking_stats.php", {
        method: 'GET'
    });
}

google.charts.load('current', {
    'packages': ['corechart']
});

google.charts.setOnLoadCallback(drawChart);


function drawChart() {

    fetchTrackingData().then(res => res.json()).then(info => {
        const elementClick = document.getElementById('chart_div_click');
        const elementClickView = document.getElementById('chart_div_click_show');

        if (info == null || info['click_show'].length == 0 && info['click_day'].length == 0) {
            elementClick.innerHTML = "Nenhuma Informação para exibir";
            return;
        }

        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Dia');
        data.addColumn('number', 'Clicks');
        data.addRows(info['click_day']);

        var dataClickShow = new google.visualization.DataTable();
        dataClickShow.addColumn('string', 'Evento');
        dataClickShow.addColumn('number', 'Clicks');
        dataClickShow.addRows(info['click_show']);

        var options = {
            'width': 800,
            'height': 600
        };

        var chartClick = new google.visualization.LineChart(document.getElementById('chart_div_click'));
        var chartClickShow = new google.visualization.ColumnChart(document.getElementById('chart_div_click_show'));
        chartClick.draw(data, Object.assign(options, {title: 'Cliques por dia'}));
        chartClickShow.draw(dataClickShow, Object.assign(options, {title: 'Eventos mais acessados'}));
    });



}
</script>

</html>