<?php require_once(PATH . '\public\layout\bootstrap.php') ?>
<?php require_once(PATH . '\public\layout\nav.php') ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
.wrapper {
    width: 60%;
    margin: 0 auto;
    margin-top: 3rem;
}

.space-box {
    margin-bottom: 4px;
}

.icon-mr {
    display: inline-block;
    margin-right: 5px;
}

.sale {
    padding: 1rem;
    margin-top: 1rem;
}
</style>

<body>
    <main class="wrapper">
        <h1><?php echo $show[0]['title'] ?></h1>
        <div class="space-box">
            <span><i
                    class="far fa-clock icon-mr"></i><?php echo $show[0]['start_date'] . "<b> até </b>" . $show[0]['end_date']; ?></span>
        </div>
        <div class="space-box">
            <span><i class="fas fa-map-marker-alt icon-mr"></i><?php echo $show[0]['address'] ?></span>
        </div>
        <div>Provido por: <b><?php echo $show[0]['fantasy_name'] ?></b></div>
        <hr>
        <p class="text">DESCRIÇÃO DO EVENTO</p>
        <p><?php echo $show[0]['description'] ?></p>
        <h3>Venda de ingressos: </h3>
        <?php 
            foreach($tickets as $ticket) {
        ?>
        <div class="card sale">
            <div class="row">
                <div class="col-md-6">
                    <b><?php echo $ticket['description'] ?></b>
                    <span style="display: block;">R$<?php echo $ticket['price'] ?></span>
                    <span style="display: block; margin-bottom: 5px;">Disponível:
                        <b><?php echo $ticket['qtd_ticket'] ?></b></span>
                    <button class="btn btn-success add-sale" type="submit">Adicionar</button>
                    <input type="hidden" value="<?php echo $ticket['id'] ?>">
                </div>
            </div>
        </div>
        <?php } ?>
    </main>
</body>
<script>
const addSaleBtn = [...document.getElementsByClassName("add-sale")];

addSaleBtn.forEach(btn => {
    btn.addEventListener("click", (e) => {
        const cart = JSON.parse(localStorage.getItem("checkout") || '[]');
        const ticketId = $(event.target).next().val();
        const showId = getQueryStringValue("id");
        if(cart.length == 0) {
            localStorage.setItem("checkout", JSON.stringify([{ticketId, showId}]));
        }else if (!presentInCheckout(cart, ticketId, showId)) {
            const items = cart;
            items.push({ticketId, showId});
            localStorage.removeItem("checkout");
            localStorage.setItem("checkout", JSON.stringify(items));
        }
    });
});

const presentInCheckout = (obj, ticketId, showId) => {
    const checkout = obj || [];
    const found = checkout.filter(x => {
        return x['ticketId'] == ticketId && x['showId'] == showId;
    });
    return found.length >= 1;
};

function getQueryStringValue(key) {  
  return decodeURIComponent(window.location.search.replace(new RegExp("^(?:.*[&\\?]" + encodeURIComponent(key).replace(/[\.\+\*]/g, "\\$&") + "(?:\\=([^&]*))?)?.*$", "i"), "$1"));  
}  

</script>

</html>