<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require_once(PATH .  LINE_SEPARATOR .'public' . LINE_SEPARATOR . 'layout' . LINE_SEPARATOR . 'bootstrap.php') ?>
    <?php require_once(PATH .  LINE_SEPARATOR .'public' .  LINE_SEPARATOR . 'layout' .  LINE_SEPARATOR . 'menu.php') ?>
    <?php if ($_SESSION['user_type'] !== 0) header("Location: login"); ?>
    <?php if ($_SESSION['accept'] == false) header("Location: welcome"); ?>
    <title>Document</title>
</head>
<style>
</style>

<body>
    <main class="wrapper-menu">
        <div class="row d-flex justify-content-center">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/export-csv">Exportar Excel</a></li>
                </ol>
            </nav>
        </div>
        <div class="row d-flex justify-content-center" style="width: 80%; margin: 0 auto;">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Evento</th>
                        <th scope="col">Endereço</th>
                        <th scope="col">Editar Evento</th>
                        <th scope="col">Editar Ingressos</th>
                        <th scope="col">Página</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        foreach($shows as $show) {
                    ?>
                    <tr>
                        <td><?php echo $show['id'] ?></td>
                        <td><?php echo $show['title'] ?></td>
                        <td><?php echo $show['address'] ?></td>
                        <td><?php $id = $show['id']; echo "<a href='/show?id=$id' class='btn btn-success'>Alterar</a>" ?>
                        </td>
                        <td><?php $id = $show['id']; echo "<a href='/ticket-show?id=$id' class='btn btn-info'>Alterar</a>" ?>
                        </td>
                        <td><?php $id = $show['id']; echo "<a target='_blank'  href='/detail?id=$id'>Ver</a>" ?></td>

                    </tr>
                    <?php 
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </main>
</body>

</html>