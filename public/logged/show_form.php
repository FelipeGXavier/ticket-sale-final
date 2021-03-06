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
    .ticket-card {
        margin-top: 1rem;
    }
</style>
<body>
    <main class="wrapper-menu">
        <div class="row d-flex justify-content-center" style="width: 100vw">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Informações do show</div>
                    <div class="box" id="message">
                        <form method="POST">
                            <div class="form-group">
                                <label>Título:</label>
                                <input name="title" type="text" class="form-control" placeholder="Título">
                            </div>
                            <div class="form-group">
                                <label>Descrição</label>
                                <textarea name="description" class="form-control" rows="10"></textarea>
                            </div>
                            <div class="form-group">
                                <label>Thumbnail (300x300):</label>
                                <input name="thumbnail" type="file" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>CEP:</label>
                                <input id="cep" name="cep" type="text" class="form-control" placeholder="89160-000">
                            </div>
                            <div class="form-group">
                                <label>Endereço:</label>
                                <input onfocus="fetchAddress()" id="address" name="address" type="text"
                                    class="form-control" placeholder="Rua Anísio de Abreu, 26 - SC">
                            </div>
                            <div class="form-group">
                                <label>Data de ínicio:</label>
                                <input name="start_date" type="date" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Data de ínicio:</label>
                                <input name="end_date" type="date" class="form-control">
                            </div>
                            <h4>Ingressos: </h4>
                            <button id="add-ticket" style="float: right; margin: 1rem" class="btn btn-success" type="submit">+</button>
                            <hr>
                            <section id="ticket">
                                <div class="card ticket-card" style="padding: 1rem;">
                                    <div class="form-group">
                                        <label>Descrição do Ingresso:</label>
                                        <input name="desc_ticket" type="text" class="form-control" placeholder="VIP Completo">
                                        <label>Preço do Ingresso:</label>
                                        <input name="price_ticket" type="text" class="form-control" placeholder="33.50">
                                        <label>Quantidade lote:</label>
                                        <input name="qtd_ticket" type="number" class="form-control" placeholder="300">
                                    </div>
                                </div>
                            </section>
                            <button id="send" style="margin-top: 1rem" class="btn btn-success" type="submit">Salvar</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
</body>

</html>
<script>

const btn = document.getElementById('send');
const btnAddTicket = document.getElementById("add-ticket");

function fetchAddress() {
    var script = document.createElement('script');
    const cep = (document.getElementById("cep").value || "").replace("-", "");
    script.src = 'https://viacep.com.br/ws/' + cep + '/json/?callback=fillAddress';
    document.body.appendChild(script);
}

function fillAddress(content) {
    const address = document.getElementById("address");
    const addressText = `${content['logradouro']}, ${content['localidade']} - ${content['bairro']}`;
    address.value = addressText;
}

btnAddTicket.addEventListener("click", (e) => {
    e.preventDefault();
    const ticketSection = document.getElementById("ticket");
    const html = `
    <div class="card ticket-card" style="padding: 1rem;">
    <div class="form-group">
        <label>Descrição do Ingresso:</label>
        <input name="desc_ticket" type="text" class="form-control" placeholder="VIP Completo">
        <label>Preço do Ingresso:</label>
        <input name="price_ticket" type="text" class="form-control" placeholder="33.50">
        <label>Quantidade lote:</label>
        <input name="qtd_ticket" type="number" class="form-control" placeholder="300">
    </div>
    </div>`;
    ticketSection.insertAdjacentHTML('afterbegin', html);
});

btn.addEventListener('click', (e) => {
    e.preventDefault();

    const title = document.querySelector("input[name='title']").value;
    const description = document.querySelector("textarea[name='description']").value;
    const cep = document.querySelector("input[name='cep']").value;
    const address = document.querySelector("input[name='address']").value;
    const start_date = document.querySelector("input[name='start_date']").value;
    const end_date = document.querySelector("input[name='end_date']").value;
    const thumbnail = document.querySelector("input[type='file']").files[0];
    
    const ticketsRefs = [...document.querySelectorAll("div.ticket-card")];
    const tickets = [];
    ticketsRefs.forEach(ticket => {
        const descTicket = ticket.querySelector("div.form-group > input[name='desc_ticket']").value || "";
        const priceTicket = ticket.querySelector("div.form-group > input[name='price_ticket']").value || "";
        const qtdTicket = ticket.querySelector("div.form-group > input[name='qtd_ticket']").value || "";
        tickets.push({descTicket, priceTicket, qtdTicket});
    });
    const requestData = {title, description, cep, address, start_date, end_date, tickets};
    const form = new FormData()    ;

    form.append("json", JSON.stringify(requestData));
    form.append("thumbnail", thumbnail);


    fetch("/create-show", {
        method: 'POST',
        body: form
    }).then(res => {
        if(res.status != 200) {
            const box = document.getElementById("message");
            box.insertAdjacentHTML("afterbegin", `<div class='alert alert-danger'><b>Campos Inválidos</b></div>`);
            window.scrollTo(0,0);
        }else {
            window.location.href = "welcome";
        }
    }).catch(err => {
        console.log(err);
    });

    

    
});
</script>