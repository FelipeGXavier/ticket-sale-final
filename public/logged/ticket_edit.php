<!DOCTYPE html>
<html lang="en">

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

<main class="wrapper-menu">
    <div class="row d-flex justify-content-center">
        <div class="col-md-10">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/show-list">Voltar</a></li>
                </ol>
            </nav>
            <h4>Alterar Ingressos do Evento</h4>
            <?php foreach($tickets as $ticket) { ?>
            <div class="card mt-3 p-3">
                <form method="POST"
                    action="<?php $show = $ticket['show_id']; $id = $ticket['id']; echo "/update-ticket?show=$show&id=$id";?>">
                    <div class="form-group">
                        <label>Descrição do Ingresso:</label>
                        <input value="<?php echo $ticket['description']; ?>" name="desc_ticket" type="text"
                            class="form-control" placeholder="VIP Completo">
                        <label>Preço do Ingresso:</label>
                        <input value="<?php echo $ticket['price']; ?>" name="price_ticket" type="text"
                            class="form-control" placeholder="33.50">
                        <label>Quantidade lote:</label>
                        <input value="<?php echo $ticket['qtd_ticket']; ?>" name="qtd_ticket" type="number"
                            class="form-control" placeholder="300">
                        <label style="display: block;">Disponível?</label>
                        <input type="radio" name="active" value="1" <?php if($ticket['active']) echo "checked";?>>Sim</input>
                        <input type="radio" name="active" value="0" <?php if(!$ticket['active']) echo "checked";?>>Não</input>
                    </div>
                    <button class="btn btn-success" type="submit">Salvar</button>
                </form>
            </div>
            <?php } ?>
        </div>
    </div>

</main>

<body>

</body>

</html>