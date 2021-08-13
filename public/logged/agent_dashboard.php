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
    <div class="alert alert-primary" role="alert">
        <?php 
        if($_SESSION['accept']) {
            echo "Quase lá, agora você precisa aguardar nossa aprovação para começar a criar anúncios!";
        }else {
            $name = $_SESSION['name'] ?? "";
            echo "Bem vindo $name!";
        } ?>
    </div>
</main>
<body>

</body>

</html>