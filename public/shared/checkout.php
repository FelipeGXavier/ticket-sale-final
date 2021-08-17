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
                            <th scope="col">Remover</th>
                        </tr>
                    </thead>

                </table>
                <button onclick="purchase()" id="checkout" class="btn btn-success">Finalizar Compra</button>
            </div>
        </div>
    </main>
</body>
<script>
function getCheckout() {
    const checkoutItems = JSON.parse(localStorage.getItem("checkout") || '[]');
    const showIds = [...new Set(checkoutItems.map(x => x['showId']))];
    const ticketIds = [...new Set(checkoutItems.map(x => x['ticketId']))];
    const form = new FormData();
    if (showIds.length > 0 && ticketIds.length > 0) {
        form.append("json", JSON.stringify({
            showIds,
            ticketIds
        }));
        return form;
    }
    return null;
}

const checkout = getCheckout();

if (checkout != null) {



    fetch("/ajax/ticket_checkout.php", {
        method: 'POST',
        body: getCheckout()
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
                    <td><button onclick="remove(${ticket['ticket_id']}, ${ticket['show_id']})" class="btn btn-danger">X</button></td>
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

}


function remove(show, ticket) {
    const cart = JSON.parse(localStorage.getItem("checkout") || '[]');
    const newCart = [];
    cart.forEach(x => {
        if (x['ticketId'] != ticket && x['showId'] != show) {
            newCart.push(x);
        }
    })
    localStorage.clear();
    localStorage.setItem("checkout", JSON.stringify(newCart));
    window.location.href = '/checkout';
}

function purchase() {
    fetch("/ajax/ticket_purchase.php", {
        method: 'POST',
        body: getCheckout()
    }).then(res => {
        localStorage.clear();
        window.location.href = '/ticket-history';
    });
}
</script>

</html>