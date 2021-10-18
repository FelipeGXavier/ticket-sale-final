<style>
body {
    padding-top: 4.5rem;
    margin-bottom: 4.5rem;
}

.nav-link:hover {
    transition: all 0.4s;
}

.nav-link-collapse:after {
    float: right;
    content: '\f067';
    font-family: 'FontAwesome';
}

.nav-link-show:after {
    float: right;
    content: '\f068';
    font-family: 'FontAwesome';
}

.nav-item ul.nav-second-level {
    padding-left: 0;
}

.nav-item ul.nav-second-level>.nav-item {
    padding-left: 20px;
}

@media (min-width: 992px) {
    .sidenav {
        position: absolute;
        top: 0;
        left: 0;
        width: 230px;
        height: calc(100vh - 3.5rem);
        margin-top: 3.5rem;
        background: #343a40;
        box-sizing: border-box;
        border-top: 1px solid rgba(0, 0, 0, 0.3);
    }

    .navbar-expand-lg .sidenav {
        flex-direction: column;
    }

    .content-wrapper {
        margin-left: 230px;
    }

}
</style>

<nav class="navbar navbar-expand-lg navbar-dark fixed-top bg-dark">
    <a class="navbar-brand" href="/">Projeto</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse"
        aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav mr-auto sidenav" id="navAccordion">

            <?php if(isset($_SESSION['user_type']) && $_SESSION['user_type'] == 2) {
                echo '<li class="nav-item"><a class="nav-link" href="/approvals">Aprovações</a></li>';
            } ?>
            
            <?php 
                if(isset($_SESSION['user_type']) && $_SESSION['user_type'] == 0) {
                  if($_SESSION['accept']) {
                    echo '<li class="nav-item"><a class="nav-link" href="/show-list">Meus Anúncios</a></li>';    
                } else {
                    echo '<li class="nav-item"><a class="nav-link disabled" href="#">Meus Anúncios</a></li>';    
                }
            } ?>

            <?php 
                if(isset($_SESSION['user_type']) && $_SESSION['user_type'] == 0) {
                  if($_SESSION['accept']) {
                    echo '<li class="nav-item"><a class="nav-link" href="/create-show">Criar Show</a></li>';    
                } else {
                    echo '<li class="nav-item"><a class="nav-link disabled" href="#">Criar Show</a></li>';    
                }
            } ?>

            <?php 
                if(isset($_SESSION['user_type']) && $_SESSION['user_type'] == 1) {
                  if($_SESSION['accept']) {
                    echo '<li class="nav-item"><a class="nav-link" href="/ticket-history">Minhas Compras</a></li>';    
                } else {
                    echo '<li class="nav-item"><a class="nav-link disabled" href="#">Minhas Compras</a></li>';    
                }
            } ?>

            <?php if(isset($_SESSION['user_type']) && $_SESSION['user_type'] == 0) {
                if($_SESSION['accept']) {
                    echo '<li class="nav-item"><a class="nav-link" href="/stats">Minhas Estatística</a></li>';    
                }else {
                    echo '<li class="nav-item"><a class="nav-link disabled" href="#">Minhas Estatística</a></li>';    
                }
            } ?>
        </ul>
        <form action="/logout" method="GET" class="form-inline ml-auto mt-2 mt-md-0">
            <button class="btn btn-danger my-2 my-sm-0" type="submit">X</button>
        </form>
    </div>
</nav>

<main class="content-wrapper">
    <div class="container-fluid">
        <h1><?php
            $title = $title ?? "";
            echo $title;
        ?></h1>
    </div>
</main>