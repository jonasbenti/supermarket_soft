<?php

require_once 'App/Model/Product.php';
require_once 'App/Model/TypeProduct.php';

class Productform
{
    private $html;
    private $data;

    public function __construct() 
    {
        $this->html = file_get_contents('View/form_product.html');
        $this->data = [
        'id' => '',
        'description' => '',
        'value' => '',
        'type_product_id' => '',
        'combo_type_products' => ''
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

    public function load($type_product_id = 0)
    {
        try {
        Transaction::open(DATABASE);
        $type_products = TypeProduct::all();
        Transaction::close();
        $select_type_products = "<option value='0'> Selecione um Produto </option>";
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
            $type_products = TypeProduct::all();
            Transaction::close();

            $this->data = $param;
            $select_type_products = "<option selected=1 value='0'> Selecione um Produto </option>";
            foreach ($type_products as $type_product) {
                $product_id   = $type_product['id'];
                $description = $type_product['description'];                
                $select_type_products .= "<option value='{$product_id}'> {$description} </option>";
            }
            $this->data['combo_type_products'] = $select_type_products;
            header("Location: index.php?class=ProductList");
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function show()
    {
        $this->load($this->data['type_product_id']);
        $this->html = file_get_contents('View/form_product.html');
        $this->html = str_replace('{id}', $this->data['id'], $this->html);
        $this->html = str_replace('{description}', $this->data['description'], $this->html);
        $this->html = str_replace('{value}', $this->data['value'], $this->html);
        $this->html = str_replace('{combo_type_products}', $this->data['combo_type_products'], $this->html);    
        echo $this->html;
    }    
}
