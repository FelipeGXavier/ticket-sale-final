<?php require_once(PATH . '\public\layout\bootstrap.php') ?>
<?php require_once(PATH . '\public\layout\nav.php') ?>
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
                        <input name="keyword" type="text" class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Estado:</label>
                        <select class="form-control" name="uf">
                            <option value="">Selecione um estado</option>
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
            foreach($shows as $show) {
            
        ?>
        <div class="col-md-4 col-lg-4 mt-2">
            <div class="p-4 bg-white">
                <div class="d-flex flex-column">
                    <div><img class="img-fluid img-responsive" src="<?php echo "../../bin/" . $show['thumbnail'] ?>" width=""
                            height="220"></div>
                    <div class="d-flex flex-column">
                        <div class="d-flex flex-row justify-content-between align-items-center">
                            <h5><?php echo $show['title'] ?></h5>
                        </div>
                        <div><span><?php echo $show['address'] ?></span></div>
                        <div><span><?php echo ((new DateTime($show['start_date']))->format('d/m/Y')) . "<b> até </b>" . ((new DateTime($show['end_date']))->format('d/m/Y')); ?> </span></div>
                        <a href="<?php $id = $show['id']; echo "/detail?id=$id"; ?>" class="btn btn-info mt-2">Ver mais</a>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
</div>