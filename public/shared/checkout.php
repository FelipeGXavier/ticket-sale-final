<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require_once(PATH . '\public\layout\bootstrap.php') ?>
    <?php require_once(PATH . '\public\layout\nav.php') ?>
    <title>Document</title>
</head>
<style>
.wrapper {
    width: 60%;
    margin: 0 auto;
    padding-top: 2rem;
}
</style>

<body>
    <main class="wrapper">
        <div class="row">
            <div class="col-md-12">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Provedor</th>
                            <th scope="col">Evento</th>
                            <th scope="col">Ingresso</th>
                            <th scope="col">Preço</th>
                            <th scope="col">Quantidade</th>
                        </tr>
                    </thead>
                   
                </table>
                <button id="checkout" class="btn btn-success">Finalizar Compra</button>
            </div>
        </div>
    </main>
</body>
<script>
    const checkoutItems = JSON.parse(localStorage.getItem("checkout")) || [];
    const showIds = [...new Set(checkoutItems.map(x => x['showId']))];
    const ticketIds = [...new Set(checkoutItems.map(x => x['ticketId']))];
    const form = new FormData();

    form.append("json", JSON.stringify({showIds, ticketIds}));
    fetch("/ajax/ticket_checkout.php", {
        method: 'POST',
        body: form
    }).then(res => res.json()).then(res => {
        const table = document.querySelector("table.table > thead");
        let html = "";
        res.tickets.forEach(ticket => {
            html += `
                <tr>
                    <td>${ticket['fantasy_name']}</td>
                    <td>${ticket['title']}</td>
                    <td>${ticket['description']}</td>
                    <td>${ticket['price']}</td>
                    <td>1</td>
                </tr>
            `;
        });
        const btn = document.getElementById("checkout");
        const prices = res.tickets.map(ticket => ticket.price);
        const totalPrice = prices.reduce((prev, curr) => prev + curr);
        const totalHtml = `<p>Total R$: <b> ${totalPrice} </b> </p>`;
        btn.insertAdjacentHTML('beforebegin', totalHtml);
        table.insertAdjacentHTML('afterend', html);
    });
</script>
</html>