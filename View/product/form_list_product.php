<?php
include __DIR__ . '/../begin_html.php';
?>
<form method="post" action="/product-save">
    <input id="id" name="id" type="hidden" value="<?= $id; ?>">
    <div class="container">
        <div class="row center-block">
            <div class="col-md-4 position-relative">
                <label for="description" class="form-label"><b>Descrição</b></label>
                <input name="description" type="text" class="form-control" id="description" value="<?= $description; ?>"
                required oninvalid="this.setCustomValidity('Campo Descrição requerido')" onchange="try{setCustomValidity('')}catch(e){}">
            </div>
            <div class="col-md-2 position-relative">
                <label for="value" class="form-label"><b>Preço</b></label>
                <input name="value" type="text" class="form-control" id="value" value="<?= $value; ?>"
                required oninvalid="this.setCustomValidity('Campo Preço requerido')" onchange="try{setCustomValidity('')}catch(e){}">
            </div>
            <div class="col-md-4 position-relative">
                <label for="type_product_id" class="form-label"><b>Tipo de Produto</b></label>
                <select class="form-select" id="type_product_id" name="type_product_id" required>
                    <option value=''> Selecione </option>
                    <?php 
                    foreach ($product_types as $product_type): 
                        extract($product_type, EXTR_PREFIX_ALL, 'tp');
                        $check = ($tp_id == $product_type_id) ? "selected=1" : "";
                    ?>
                    <option <?= $check; ?> value='<?= $tp_id; ?>'> <?= $tp_description; ?> </option>
                <?php endforeach; ?>
                </select>
            </div>
        </div>
    </div>
    <div class="text-center">
        <div class="m-3 btn-group" role="group" aria-label="Basic mixed styles example">
            <input class="btn btn-<?= $button_type; ?>" type="submit" value="<?= $button_text; ?>">
            <a class="btn btn-danger" href="/product" role="button">Cancelar</a>
        </div>
    </div>
</form>

<div class="container">
    <table class="table table-striped table-hover caption-top rounded">
        <caption class="text-center"><h3>Lista de produtos</h3></caption>
        <thead class="table-primary" style="border-radius: 5px;">
            <tr>
                <td></td>
                <td><b>Id</b></td>
                <td><b>Descrição</b></td>
                <td><b>Preço</b></td>
                <td><b>Tipo de Produto</b></td>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($products as $product): 
                extract($product);
            ?>
                <tr>
                    <td>
                        <a href='/product?id=<?= $id; ?>' class='btn btn-primary btn-sm'>
                            Alterar
                        </a>
                    </td>
                    <td><?= $id; ?></td>
                    <td><?= $description; ?></td>
                    <td><?= $value; ?></td>
                    <td><?= $type_product; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php include __DIR__ . '/../end_html.php'; ?>