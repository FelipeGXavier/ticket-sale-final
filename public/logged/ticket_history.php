<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php require_once(PATH . '\public\layout\bootstrap.php') ?>
    <?php require_once(PATH . '\public\layout\menu.php') ?>
</head>

<main class="wrapper-menu">
    <div class="row d-flex justify-content-center">
        <div class="col-md-10">
            <h4>Ingressos comprados</h4>
            <?php foreach($tickets as $ticket) { ?>
            <div class="card mt-3 p-3">
                <h4><?php echo $ticket['title'] ?></h4>
                <div class="space-box">
                    <span><i class="far fa-clock icon-mr"></i>
                        <?php echo "Ocorre em: " . ((new DateTime($ticket['start_date']))->format('d/m/Y')) . "<b> até </b>" . ((new DateTime($ticket['end_date']))->format('d/m/Y')); ?>
                    </span>
                </div>
                <div class="space-box">
                    <span><i class="fas fa-map-marker-alt icon-mr"></i><?php echo $ticket['address'] ?></span>
                </div>
                <div>Provido por: <b><?php echo $ticket['fantasy_name'] ?></b></div>
                <div>Tipo do ingresso: <b><?php echo $ticket['description'] ?></b></div>
                <div>Comprado em: <b><?php echo $ticket['purchased_at'] ?></b></div>
                <div>Comprado por: R$<b><?php echo $ticket['price_purchased'] ?></b></div>
            </div>
            <?php } ?>
        </div>
    </div>

</main>

<body>

</body>

</html>