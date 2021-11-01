<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php require_once(PATH .  LINE_SEPARATOR .'public' . LINE_SEPARATOR . 'layout' . LINE_SEPARATOR . 'bootstrap.php') ?>
</head>

<style>
.box {
    padding: 1rem;
}

body {
    overflow: hidden;
}

.form-box {
    margin-top: 2rem;
}

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

    <?php require_once(PATH . LINE_SEPARATOR . 'public'. LINE_SEPARATOR . 'layout' . LINE_SEPARATOR . 'nav.php') ?>
    <main id="container">
        <div class="row d-flex justify-content-center form-box">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">Entrar</div>
                    <div class="box">
                    <?php
                      if (!empty($message)) {
                        echo "<div class='alert alert-danger'><b>$message</b></div>";
                    }
                    ?>
                        <form action="/login" method="POST">
                            <div class="form-group">
                                <label>Email</label>
                                <input name="email" type="email" class="form-control" placeholder="Enter email">
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input name="password" type="password" class="form-control" placeholder="Password">
                            </div>
                            <button class="btn btn-success" type="submit">Entrar</button>
                            <a style="display: block; float: right;" href="create-login" class="register-link">Criar Conta</a>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
</body>

</html>