<?php
include __DIR__ . '/../begin_html.php';
?>
<form method="post" action="/order-sale-save">
    <input id="order_id" name="order_id" type="hidden" value="<?= $id; ?>">
    <input id="order_items" name="order_items" type="hidden" value="">
    <div class="container">
        <div class="row center-block">
            <div class="col-md-2 position-relative">
                <label for="order_date" class="form-label"><b>Data</b></label>
                <input name="order_date" type="text" class="form-control" id="order_date" value="<?= $order_date; ?>">
            </div>
            <div class="col-md-2 position-relative">
                <label for="order_total" class="form-label"><b>Valor Total</b></label>
                <input name="order_total" type="text" class="form-control"
                    readonly="1" id="order_total" value="<?= $order_total; ?>"
                >
            </div>
            <div class="col-md-2 position-relative mb-2">
                <label for="order_total_tax" class="form-label"><b>VT. imposto</b></label>
                <input name="order_total_tax" type="text" class="form-control"
                    readonly="1" id="order_total_tax" value="<?= $order_total_tax; ?>"
                >
            </div>
            <div class="col-auto mt-4 mb-2">
                <input class="btn btn-success"
                    id="btn_submit"
                    type="submit"
                    title="Clique aqui para finalizar seu pedido, após isso não poderá ser alterado"
                    onclick="return endOrderSale()"
                    value="Finalizar Pedido"
                >
            </div>
            <div class="col-auto mt-4 mb-2">
                <a class="btn btn-danger"
                    id="btn_clear_order"
                    type="button"
                    title="Clique aqui para limpar todos os itens do pedido"
                    onclick="return clearOrderSaleTotalsItems()"
                    role="button"
                >
                    Limpar itens
                </a>
            </div>

            <div id="div_include_item" class="row">
                <div id="div_card_item" class="card bg-<?= $button_type; ?> text-white mb-2" style="border-radius:15px;">
                    <div class="card-body">
                        <h5 id="text_include_item" class="card-title text-center"><?= $title2; ?></h5>
                    </div>
                </div>
                <input id="item_number" name="item_number" type="hidden" value="">
                <div class="col-md-3 position-relative">
                    <label for="product_item" class="form-label"><b>Produto</b></label>
                    <select class="form-select" id="product_item" name="product_item" onchange="findProduct()">
                        <option value=''> Selecione </option>
                        <?php
                        foreach ($products as $product): 
                            extract($product, EXTR_PREFIX_ALL, 'prod');
                            $check =  "";
                        ?>
                        <option <?= $check; ?>
                            value='<?= $prod_id; ?>' 
                            data-price='<?= $prod_value; ?>'
                            data-tax_percentage='<?= $prod_tax_percetage; ?>'
                        >
                            <?= $prod_description; ?> 
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-1 position-relative">
                    <label for="quantity_item" class="form-label"><b>Qtd</b></label>
                    <input name="quantity_item" type="number" class="form-control" id="quantity_item" value="1"
                     onclick="updateTotalItem()" onkeyup="updateTotalItem()" min="1"
                    required oninvalid="this.setCustomValidity('Campo Qtd requerido')" onchange="try{setCustomValidity('')}catch(e){}">
                </div>
                <div class="col-md-2 position-relative">
                    <label for="price_item" class="form-label"><b>Preço</b></label>
                    <input name="price_item" type="number" class="form-control" id="price_item" value="0" readonly="1">
                </div>
                <div class="col-md-2 position-relative">
                    <label for="total_item" class="form-label"><b>Total</b></label>
                    <input name="total_item" type="number" class="form-control" id="total_item" value="0" readonly="1">
                </div>
                <div class="col-md-2 position-relative">
                    <label for="total_tax_item" class="form-label"><b>Total Imp</b></label>
                    <input name="total_tax_item" type="number" class="form-control" id="total_tax_item" value="0" readonly="1">
                </div>
            </div>
        </div>
        <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
            <div id="liveToast" class="toast hide" role="alert" aria-live="assertive" aria-atomic="true">
              <div class="toast-header text-white bg-primary border-0">
                <strong class="me-auto text-white bg-primary border-0">SupermarketSoft 2.0</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
              </div>
              <div class="toast-body">
                <p id="toast_res">Produto Adicionado ao pedido.</p>
              </div>
            </div>
        </div>
        <div class="text-center">
            <div class="m-3 btn-group" role="group" aria-label="Basic mixed styles example">
                <a class="btn btn-success" id="btn_add" onclick="addItem()" role="button">Add Item</a>
                <a class="btn btn-danger" id="btn_clear_item" href="/order-sale-create" role="button" type="button" >Limpar Item</a>
            </div>
        </div>
    </div>
</form>

<div class="container">
    <table id="tbl_order" class="table table-bordered table-striped table-hover caption-top">
        <caption class="text-center">
            <h3>Itens do pedido</h3>
        </caption>
        <thead class="table-primary" style="border-radius: 5px;">
            <tr>
                <th style="text-align:center" id="thead_delete">Excluir</th>
                <th style="text-align:center" id="thead_edit">Editar</th>
                <th style="text-align:right">Nº</th>
                <th>Produto</th>
                <th style="text-align:right">Qtd</th>
                <th style="text-align:right">Preço</th>
                <th style="text-align:right">Total</th>
                <th style="text-align:right">Total Imp.</th>
            </tr>
        </thead>
    </table>
</div>
<script type="text/javascript">
    //elements
    let elAppTable = document.getElementById("tbl_order");
    var tblOrderBody = document.createElement("tbody");
    var text_include_item = document.getElementById("text_include_item");
    
    //localstorage
    var items_order = JSON.parse(localStorage.getItem("items")) || [];
    var next_number = 0;

    //inputs
    var order_id = document.getElementById("order_id");
    var order_items = document.getElementById("order_items");
    var order_date = document.getElementById("order_date");
    var order_total = document.getElementById("order_total");
    var order_total_tax = document.getElementById("order_total_tax");
    var product_item = document.getElementById("product_item");
    var quantity_item = document.getElementById("quantity_item");
    var price_item = document.getElementById("price_item");
    var total_item = document.getElementById("total_item");
    var total_tax_item = document.getElementById("total_tax_item");
    var item_number = document.getElementById("item_number");

    //buttons
    var btn_add = document.getElementById("btn_add");
    var btn_submit = document.getElementById("btn_submit");
    var btn_clear_order = document.getElementById("btn_clear_order");
    var btn_clear_item = document.getElementById("btn_clear_item");

    //thead
    var thead_delete = document.getElementById("thead_delete");
    var thead_edit = document.getElementById("thead_edit");

    //divs
    var div_panel_include_item = document.getElementById("div_panel_include_item");
    var div_include_item = document.getElementById("div_include_item");
    var div_card_item = document.getElementById("div_card_item");


    //label
    var label_alert = document.getElementById("label_alert");

    //variables
    var product_selected;
    var product_id ;
    var product_desc;
    var product_perc_tax;
    var msg_toast;

    if (order_id.value != "") {
        order_date.readOnly = true;
        thead_delete.style.display = 'none';
        thead_edit.style.display = 'none';
        btn_add.style.display = 'none';
        btn_submit.style.display = 'none';
        btn_clear_order.style.display = 'none';
        btn_clear_item.style.display = 'none';
        div_include_item.style.display = 'none';
        items_order = JSON.parse('<?= $order_items; ?>') || [];
    }

    //initial values
    updateTotalOrder(0, 0);
    createTable(items_order);

    function removeRow(rowId, id) {
        rowId.remove();
        items_order = items_order.filter(item => item.item_number !== id);

        localStorage.setItem('items', JSON.stringify(items_order));
    }

    function editRow(rowId, id) {
        item_order = items_order.find(item => item.item_number === id);

        btn_add.classList.remove('btn-success');
        btn_add.classList.add('btn-primary');
        div_card_item.classList.remove('bg-success');
        div_card_item.classList.add('bg-primary');
        text_include_item.innerHTML = "Editar Item Nº: "+id;

        product_item.value = item_order.product_id;
        product_selected = product_item.options[product_item.selectedIndex];
        price_item.value = item_order.price;
        quantity_item.value = item_order.quantity;
        item_number.value = item_order.item_number;
        product_perc_tax = product_selected.dataset.tax_percentage;
        total_item.value = parseFloat((quantity_item.value * price_item.value)).toFixed(2);
        total_tax_item.value = parseFloat((total_item.value * (product_perc_tax/100))).toFixed(2);
    }

    function findProduct() {
        product_selected = product_item.options[product_item.selectedIndex];
        product_id = product_selected.value;
        product_desc = product_selected.text;
        product_perc_tax = product_selected.dataset.tax_percentage;
        price_item.value = product_selected.dataset.price;
        updateTotalItem();
    }

    function createTable(items) {
        items.sort((a, b) => b.item_number - a.item_number);

        tblOrderBody.remove();
        tblOrderBody = document.createElement("tbody");
        total_order = 0;
        total_order_tax = 0;

        for (item of items) {
            let row = document.createElement('tr');
            let btnActions = order_id.value != "" ? "" :
            `<td style="text-align:center">
                <a href='#div_include_item'
                    onClick='removeRow(trb${item.item_number}, ${item.item_number})'
                    class='btn btn-danger btn-sm'
                >
                    Excluir
                </a>
            </td>
            <td style="text-align:center">
                <a href='#div_include_item'
                    onClick='editRow(trb${item.item_number}, ${item.item_number})'
                    class='btn btn-primary btn-sm'
                >
                    Editar
                </a>
            </td>`;
            row.setAttribute("id", "trb" + item.item_number);
            row.innerHTML = `
                ${btnActions}
                <td style="text-align:right">${item.item_number}</td>
                <td>${item.product_desc}</td>
                <td style="text-align:right">${item.quantity}</td>
                <td style="text-align:right">${item.price}</td>
                <td style="text-align:right">${item.value_total}</td>
                <td style="text-align:right">${item.value_total_tax}</td>
            `;

            total_order += parseFloat(item.value_total);
            total_order_tax += parseFloat(item.value_total_tax);

            updateTotalOrder(total_order, total_order_tax);

            tblOrderBody.appendChild(row);
            elAppTable.appendChild(tblOrderBody);
        }
    }

    function updateTotalItem() {
        total_item.value = parseFloat((quantity_item.value * price_item.value)).toFixed(2);
        total_tax_item.value = parseFloat((total_item.value * (product_perc_tax/100))).toFixed(2);
    }

    function updateTotalOrder(value_total_order = 0, value_total_order_tax = 0) {
        order_total.value = value_total_order.toFixed(2);
        order_total_tax.value = value_total_order_tax.toFixed(2);
    }

    function addItem() {
        if (product_item.selectedIndex == "0" || quantity_item.value < 1) {
            alert("É necessario selecionar o produto, e a quantidade precisa ser maior que zero!");
            return false;
        }

        if (item_number.value != "") {
            next_number = item_number.value;
            msg_toast = `Item numero <b>${next_number}</b> Alterado!`;
            items_order = items_order.map(item => {
                if (item.item_number == next_number) {
                    product_selected = product_item.options[product_item.selectedIndex];
                    item.product_desc = product_selected.text;
                    item.product_id = product_selected.value;
                    item.quantity = quantity_item.value;
                    item.price = price_item.value;
                    item.value_total = total_item.value;
                    item.value_total_tax = total_tax_item.value;
                }

                return item;
            });
        } else {
            next_number = JSON.parse(localStorage.getItem("next_number")) || 1;
            items_order.push({
                item_number: next_number,
                product_desc: product_desc,
                product_id: product_id,
                quantity: quantity_item.value,
                price: price_item.value,
                value_total: total_item.value,
                value_total_tax: total_tax_item.value
            });

            next_number++;
            localStorage.setItem('next_number', JSON.stringify(next_number));
            msg_toast = `Produto <b>${product_desc}</b> adicionado ao pedido!`;
        }

        localStorage.setItem('items', JSON.stringify(items_order));

        if (btn_add.classList[1] == 'btn-primary') {
            btn_add.classList.remove('btn-primary');
            btn_add.classList.add('btn-success');
            div_card_item.classList.remove('bg-primary');
            div_card_item.classList.add('bg-success');
            text_include_item.innerHTML = "<?= $title2; ?>";
        }

        clearIncludeproduct();
        createTable(items_order);
        callToast(msg_toast);
    }

    function callToast(msg_toast) {
        var toastElList = [].slice.call(document.querySelectorAll('.toast'));
        toast_res.innerHTML = msg_toast;
        var toastList = toastElList.map(function(toastEl) {
            return new bootstrap.Toast(toastEl);
        });
        toastList.forEach(toast => toast.show());
    }

    function endOrderSale() {
        order_items.value = (localStorage.getItem("items"));

        if (order_items.value.length == 0) {
            alert("Erro ao finalizar pedido. É necessario inserir 1 produto no minimo.");
            return false;
        }

        if (confirm('Tem certeza que deseja finalizar o pedido?')) {
            let date = new Date(order_date.value);
            let arrDate = order_date.value.split('/');
            let date2 = [arrDate[2], arrDate[1], arrDate[0]];

            order_date.value = date2.join('-');
            clearOrderSaleItems();
        } else {
            return false;
        }
    }

    function clearOrderSaleItems() {
        tblOrderBody.remove();
        localStorage.removeItem('items');
        localStorage.removeItem('next_number');
        items_order = [];
    }

    function clearOrderSaleTotalsItems() {
        if (!confirm('Tem certeza que deseja excluir todos os produtos do Pedido?')) {
            return false;
        }

        updateTotalOrder();
        clearOrderSaleItems();

        return true;
    }

    function clearIncludeproduct() {
        product_desc = "";
        product_id = 0;
        product_item.selectedIndex = "0";
        quantity_item.value = 1;
        price_item.value = 0;
        total_item.value = 0;
        total_tax_item.value = 0;
    }
</script>
</div>
<?php include __DIR__ . '/../end_html.php'; ?>