<?php

require_once 'App/Model/Product.php';
require_once 'App/Model/TypeProduct.php';

class ProductFormList
{
    private $html;
    private $data;

    public function __construct() 
    {
        $this->html = file_get_contents('View/form_product_list.html');

        $this->data = [
            'id' => '',
            'description' => '',
            'value' => '',
            'type_product_id' => '',
            'combo_type_products' => '',
            'product_list' => ''
        ];
    }

    public function edit($param)
    {
        try {
            $id = (int) $param['id'];
            Transaction::open(DATABASE);
            $this->data = Product::find($id);
            Transaction::close();
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

            $items = '';

            foreach ($products as $product) {
                $item = file_get_contents('View/item_product.html');
                $item = str_replace('{id}', $product['id'], $item);
                $item = str_replace('{description}', $product['description'], $item);
                $item = str_replace('{value}', $product['value'], $item);
                $item = str_replace('{type_product_id}', $product['type_product'], $item);
                $items .= $item;
            }

            $this->data['product_list'] = $items;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function loadTypeProduct($type_product_id = 0)
    {
        try {
            Transaction::open(DATABASE);
            $type_products = TypeProduct::all();
            Transaction::close();
            $select_type_products = "<option value=''> Selecione um Produto </option>";

            foreach ($type_products as $type_product) {
                $id = $type_product['id'];
                $description = $type_product['description'];  
                $check = $id == $type_product_id ? "selected=1" : "";
                $select_type_products .= "<option $check value='{$id}'> {$description} </option>";
            }

            $this->data['combo_type_products'] = $select_type_products;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function save($param)
    {
        try {
            Transaction::open(DATABASE);
            Product::save($param);
            Transaction::close();

            header("Location: index.php?class=ProductFormList");
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function show()
    {
        $this->loadTypeProduct($this->data['type_product_id']);
        $this->load();

        $this->html = file_get_contents('View/form_product_list.html');
        $this->html = str_replace('{id}', $this->data['id'], $this->html);
        $this->html = str_replace('{description}', $this->data['description'], $this->html);
        $this->html = str_replace('{value}', $this->data['value'], $this->html);
        $this->html = str_replace('{combo_type_products}', $this->data['combo_type_products'], $this->html);
        $this->html = str_replace('{items}', $this->data['product_list'], $this->html);

        echo $this->html;
    }
}
