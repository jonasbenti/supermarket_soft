<?php

require_once 'App/Model/OrderSale.php';
require_once 'App/Model/OrderSaleItem.php';
require_once 'App/Model/Product.php';

class OrderSaleForm
{
    private $html;
    private $data;

    public function __construct() 
    {
        $this->html = file_get_contents('View/form_order_sale.html');
        $this->data = [
            'id' => '',
            'order_date' => date('d/m/Y'),
            'order_total' => '0',
            'order_total_tax' => '0',
            'combo_products' => '',
            'order_items' => []
        ];
    }

    public function edit($param)
    {
        try {
            $order_id = (int) $param['id'];
            Transaction::open(DATABASE);
            $products = Product::all();
            $this->data = OrderSale::find($order_id); 
            $this->data['order_items'] = OrderSaleItem::findByOrderSale($order_id);
            Transaction::close();

            $select_products = "<option selected=1 value='0'> Selecione um Produto </option>";
            foreach ($products as $product) {
                $values_product = $product['id']."_|_".$product['description']."_|_".$product['value']."_|_".$product['tax_percetage'];
                $description = $product['description'];
                $select_products .= "<option value='{$values_product}'> {$description} </option>";
            }

            $this->data['combo_products'] = $select_products;
            $order_date = date_create($this->data['order_date']);
            $this->data['order_date'] = date_format($order_date,'d/m/Y');

        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function load()
    {
        try {
            Transaction::open(DATABASE);
            $products = Product::all();
            Transaction::close();

            $select_products = "<option selected=1 value=''> Selecione um Produto </option>";

            foreach ($products as $product) {
                $values_product = $product['id'];
                $description = $product['description']." - imp: (".(str_replace(".",",",$product['tax_percetage'])."%)");
                $select_products .= "<option value='{$values_product}' data-price='{$product['value']}' data-tax_percentage='{$product['tax_percetage']}'> {$description} </option>";
            }

            $this->data['combo_products'] = $select_products;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function save($param)
    {
        try {
            $order_sale_items = json_decode($param['order_items'], true);
            $order_sale = [
                'order_date' => $param['order_date'], 
                'order_total' => $param['order_total'], 
                'order_total_tax' => $param['order_total_tax']
            ];

            Transaction::open(DATABASE);
            $order_sale_id = OrderSale::save($order_sale);

            foreach ($order_sale_items as $order_sale_item) {
                OrderSaleItem::save($order_sale_item, $order_sale_id);
            }

            Transaction::close();
            $this->data = $param;
            header("Location: index.php?class=OrderSaleList");
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function show()
    {
        $this->load();
        $this->html = file_get_contents('View/form_order_sale.html');
        $this->html = str_replace('{order_id}', isset($this->data['id']) ? $this->data['id'] : '', $this->html);
        $this->html = str_replace('{order_date}', $this->data['order_date'], $this->html);
        $this->html = str_replace('{order_total}', $this->data['order_total'], $this->html);
        $this->html = str_replace('{order_total_tax}', $this->data['order_total_tax'], $this->html);
        $this->html = str_replace('{combo_products}', $this->data['combo_products'], $this->html);
        $this->html = str_replace('{array_order_items}', json_encode($this->data['order_items']), $this->html);
        echo $this->html;
    }
}
