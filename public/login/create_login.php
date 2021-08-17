<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php require_once(PATH . '\public\layout\bootstrap.php') ?>
</head>

<style>
    .register-link {
    color: black;
    text-decoration: none;
}

.register-link:hover {
    color: black;
    text-decoration: none;
}
</style>

<body>
    <?php require_once(PATH . '\public\layout\nav.php') ?>
    <main id="container">
        <div class="row d-flex justify-content-center form-box">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">Criar Conta</div>
                    <div class="box">
                    <?php
                      if (!empty($message)) {
                        echo "<div class='alert alert-danger'><b>$message</b></div>";
                    }
                    ?>
                        <form action="/create-login" method="POST">
                            <div class="form-group">
                                <label>Email</label>
                                <input name="email" type="email" class="form-control" placeholder="Enter email">
                            </div>
                            <div class="form-group">
                                <label>Nome</label>
                                <input name="name" type="text" class="form-control" placeholder="Enter name">
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input name="password" type="password" class="form-control" placeholder="Password">
                            </div>
                            <div class="form-group">
                                <label>Data de Nascimento:</label>
                                <input name="birth" type="date" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Tipo de Usuário:</label>
                                <select form-control name="user_type" id="user_type">
                                    <option value="0">Agente</option>
                                    <option value="1">Cliente</option>
                                </select>
                            </div>

                            <button class="btn btn-success" type="submit">Registrar</button>
                            <a style="display: block; float: right;" href="login" class="register-link">Entrar</a>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
</body>

</html>