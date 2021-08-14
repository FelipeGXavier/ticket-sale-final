<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php require_once(PATH . '\public\layout\bootstrap.php') ?>
    <?php require_once(PATH . '\public\layout\menu.php') ?>
    <?php if ($_SESSION['user_type'] != 2) header("Location: login"); ?>

</head>

<main class="wrapper-menu">
    <div class="row d-flex justify-content-center">
        <div class="col-md-10">
          <?php if(!empty($pendings)) { ?>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">CNPJ</th>
                        <th scope="col">Nome Fantasia</th>
                        <th scope="col">Email</th>
                        <th scope="col">Ação</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                      foreach($pendings as $pending) { 
                        $cnpj = $pending['cnpj'];
                        $fantasy_name = strtoupper($pending['fantasy_name']);
                        $email = $pending['email'];
                        $userId =  $pending['user_id'];
                        echo "<tr>";
                        echo "<td>$cnpj</td>";
                        echo "<td>$fantasy_name</td>";
                        echo "<td><a href='mailto: $email'>$email</a></td>";
                        echo "<td><a href='/approve-agent?id=$userId'>Aprovar</a></td>";
                      }
                    ?>
                </tbody>
            </table>
          <?php } else {
            echo "<h4 style='text-align: center'>Nenhuma aprovação pendente";
          } ?>
        </div>
    </div>

</main>

<body>

</body>

</html>