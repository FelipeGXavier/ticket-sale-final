<?php require_once(PATH . LINE_SEPARATOR . 'public' . LINE_SEPARATOR . 'layout' . LINE_SEPARATOR . 'bootstrap.php') ?>
<?php require_once(PATH . LINE_SEPARATOR . 'public' . LINE_SEPARATOR . 'layout' . LINE_SEPARATOR . 'nav.php') ?>
<style>
    body {
        background-color: #eee
    }
</style>
<div class="container mt-5 mb-5">
    <div class="p-2 bg-white px-4">
        <h4>Filtros</h4>
        <form action="/" method="GET">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Palavra de Busca</label>
                        <input value="<?php echo $_GET['keyword'] ?? '' ?>" name="keyword" type="text" class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Estado:</label>
                        <select class="form-control" name="uf">
                            <?php
                            $states = array(
                                ''   => 'Selecione um estado',
                                'AC' => 'Acre',
                                'AL' => 'Alagoas',
                                'AP' => 'Amapá',
                                'AM' => 'Amazonas',
                                'BA' => 'Bahia',
                                'CE' => 'Ceará',
                                'DF' => 'Distrito Federal',
                                'ES' => 'Espirito Santo',
                                'GO' => 'Goiás',
                                'MA' => 'Maranhão',
                                'MS' => 'Mato Grosso do Sul',
                                'MT' => 'Mato Grosso',
                                'MG' => 'Minas Gerais',
                                'PA' => 'Pará',
                                'PB' => 'Paraíba',
                                'PR' => 'Paraná',
                                'PE' => 'Pernambuco',
                                'PI' => 'Piauí',
                                'RJ' => 'Rio de Janeiro',
                                'RN' => 'Rio Grande do Norte',
                                'RS' => 'Rio Grande do Sul',
                                'RO' => 'Rondônia',
                                'RR' => 'Roraima',
                                'SC' => 'Santa Catarina',
                                'SP' => 'São Paulo',
                                'SE' => 'Sergipe',
                                'TO' => 'Tocantins',
                            );
                            $uf = $_GET['uf'] ?? '';
                            foreach($states as $key => $value) {
                                if ($key == $uf) {
                                    echo "<option selected value='{$key}'>{$value}</option>";
                                }else {
                                    echo "<option value='{$key}'>{$value}</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="row d-flex justify-content-center">
                        <button style="width: 80%;" class="btn btn-successs">Buscar</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="row">
        <?php
        foreach ($shows as $show) {

        ?>
            <div class="col-md-4 col-lg-4 mt-2">
                <div class="p-4 bg-white">
                    <div class="d-flex flex-column">
                        <div><img class="img-fluid img-responsive" src="<?php echo "../../bin/" . $show['thumbnail'] ?>" width="" height="220"></div>
                        <div class="d-flex flex-column">
                            <div class="d-flex flex-row justify-content-between align-items-center">
                                <h5><?php echo $show['title'] ?></h5>
                            </div>
                            <div><span><?php echo $show['address'] ?></span></div>
                            <div><span><?php echo ((new DateTime($show['start_date']))->format('d/m/Y')) . "<b> até </b>" . ((new DateTime($show['end_date']))->format('d/m/Y')); ?> </span></div>
                            <a href="<?php $id = $show['id'];
                                        echo "/detail?id=$id"; ?>" class="btn btn-info mt-2">Ver mais</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
    <nav style="display: flex; justify-content: center;">
        <ul class="pagination">
            <?php
            function getUrlPage($page)
            {
                $query = $_GET;
                $query['page'] = $page;
                $result = http_build_query($query);
                $result = "http://" . $_SERVER['SERVER_NAME'] . "/?" . $result;
                return $result;
            }
            $start = $_GET['page'] ?? 0;
            $previous = $start == 0 ? $start : $start - 1;
            echo "<li class='page-item'><a class='page-link' href='" . getUrlPage($previous) . "' aria-label='Previous'>";
            echo "<span aria-hidden='true'>&laquo;</span><span class='sr-only'>Previous</span></a></li>";
            for ($i = 0; $i < 5; $i++) {
                $page = $start + $i;
                $showPage = $page + 1;
                if ($i == 0) {
                    echo "<li class='page-item active'><a class='page-link' href='" . getUrlPage($page) . "'>{$showPage}</a></li>";
                } else {
                    echo "<li class='page-item'><a class='page-link' href='" . getUrlPage($page) . "'>{$showPage}</a></li>";
                }
            }
            echo "<li class='page-item'><a class='page-link' href='" . getUrlPage($start + 1) . "' aria-label='Next'>
                    <span aria-hidden='true'>&raquo;</span>
                    <span class='sr-only'>Next</span>
                </a></li>";
            ?>
        </ul>
    </nav>
</div>