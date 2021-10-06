<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php require_once(PATH .  LINE_SEPARATOR .'public' . LINE_SEPARATOR . 'layout' . LINE_SEPARATOR . 'bootstrap.php') ?>
    <?php if ($_SESSION['user_type'] !== 0) header("Location: login"); ?>
    <?php if ($_SESSION['welcome'] == true) header("Location: welcome"); ?>
</head>
<style>
#title {
    text-align: center;
    font-size: 2rem;
}
</style>

<body>
    <?php require_once(PATH . LINE_SEPARATOR . 'public '. LINE_SEPARATOR . 'layout' . LINE_SEPARATOR . 'nav.php') ?>
    <h4 id="title">Antes de prosseguir você deve cadastrar sua agência</h4>
    <main id="container">
        <div class="row d-flex justify-content-center form-box">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">Informações da agência</div>
                    <div class="box">
                        <?php
                            if (!empty($message)) {
                                echo "<div class='alert alert-danger'><b>$message</b></div>";
                            }
                        ?>
                        <form action="/create-agency" method="POST">
                            <div class="form-group">
                                <label>Nome Fantasia:</label>
                                <input name="fantasy_name" type="text" class="form-control" placeholder="Nome Fantasia">
                            </div>
                            <div class="form-group">
                                <label>CNPJ (Somente números): </label>
                                <input name="cnpj" type="text" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Telefone:</label>
                                <input name="phone" type="text" class="form-control" placeholder="(00) 00000-0000)">
                            </div>
                            <div class="form-group">
                                <label>E-mail profissional:</label>
                                <input name="professional_mail" type="text" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Segmentos:</label>
                                <select class="form-control" name="segment[]" multiple>
                                    <?php 
                                    foreach($segments as $segment) {
                                        echo "<option value=" . $segment['id'] . ">" .$segment['title'] . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Estado:</label>
                                <select class="form-control" name="uf">
                                    <option value="AC">Acre</option>
                                    <option value="AL">Alagoas</option>
                                    <option value="AP">Amapá</option>
                                    <option value="AM">Amazonas</option>
                                    <option value="BA">Bahia</option>
                                    <option value="CE">Ceará</option>
                                    <option value="DF">Distrito Federal</option>
                                    <option value="ES">Espírito Santo</option>
                                    <option value="GO">Goiás</option>
                                    <option value="MA">Maranhão</option>
                                    <option value="MT">Mato Grosso</option>
                                    <option value="MS">Mato Grosso do Sul</option>
                                    <option value="MG">Minas Gerais</option>
                                    <option value="PA">Pará</option>
                                    <option value="PB">Paraíba</option>
                                    <option value="PR">Paraná</option>
                                    <option value="PE">Pernambuco</option>
                                    <option value="PI">Piauí</option>
                                    <option value="RJ">Rio de Janeiro</option>
                                    <option value="RN">Rio Grande do Norte</option>
                                    <option value="RS">Rio Grande do Sul</option>
                                    <option value="RO">Rondônia</option>
                                    <option value="RR">Roraima</option>
                                    <option value="SC">Santa Catarina</option>
                                    <option value="SP">São Paulo</option>
                                    <option value="SE">Sergipe</option>
                                    <option value="TO">Tocantins</option>
                                </select>
                            </div>
                            <div style="margin-bottom: 20px;">
                                <label for="previous_experience" style="display: block;">Possui experiência com eventos?</label>
                                <input type="radio" name="previous_experience" value="0" checked>Não</input>
                                <input type="radio" name="previous_experience" value="1">Sim</input>
                            </div>
                            <button class="btn btn-success" type="submit">Prosseguir</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
</body>

</html>