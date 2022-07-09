<?php
include __DIR__ . '/../begin_html.php';
?>
<form method="post" action="/product-type-save">
    <input id="id" name="id" type="hidden" value="<?= $id; ?>">
    <div class="container">
        <div class="row center-block">
            <div class="col-md-4 position-relative">
                <label for="description" class="form-label"><b>Descrição</b></label>
                <input name="description" type="text" class="form-control" id="description" value="<?= $description; ?>"
                required oninvalid="this.setCustomValidity('Campo Descrição requerido')" onchange="try{setCustomValidity('')}catch(e){}">
            </div>
            <div class="col-md-4 position-relative">
                <label for="tax_percentage" class="form-label"><b>Imposto(%)</b></label>
                <input name="tax_percentage" type="text" class="form-control" id="tax_percentage" value="<?= $tax_percentage; ?>"
                required oninvalid="this.setCustomValidity('Campo Imposto(%) requerido')" onchange="try{setCustomValidity('')}catch(e){}">
            </div>
        </div>
    </div>
    <div class="text-center">
        <div class="m-3 btn-group" role="group" aria-label="Basic mixed styles example">
            <input class="btn btn-<?= $button_type; ?>" type="submit" value="<?= $button_text; ?>">
            <a class="btn btn-danger" href="/product-type" role="button">Cancelar</a>
            <!-- <a class="btn btn-primary" href="/home" role="button">Voltar ao início</a> -->
        </div>
    </div>
</form>

<div class="container">
    <table class="table table-striped table-hover caption-top rounded">
        <caption class="text-center"><h3>Lista de tipos de produto</h3></caption>
        <thead class="table-primary" style="border-radius: 5px;">
            <tr>
                <td></td>
                <td><b>Id</b></td>
                <td><b>Descrição</b></td>
                <td><b>Imposto(%)</b></td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($product_types as $productType): 
                extract($productType);
            ?>
                <tr>
                    <td>
                        <a href='/product-type?id=<?= $id; ?>' class='btn btn-primary btn-sm'>
                            Alterar
                        </a>
                    </td>
                    <td><?= $id; ?></td>
                    <td><?= $description; ?></td>
                    <td><?= $tax_percentage; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php include __DIR__ . '/../end_html.php'; ?>