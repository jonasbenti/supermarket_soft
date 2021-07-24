<?php

require_once 'App/Model/Product.php';

class ProductList
{
    private $html;

    public function __construct()
    {
        $this->html = file_get_contents('View/list_product.html');
    }

    public function delete($param)
    {
        try {
            $id = (int) $param['id'];
            Product::delete($id);
        } catch(Exception $e) {
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
            $this->html = str_replace('{items}', $items, $this->html);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function show()
    {
        $this->load();
        echo $this->html;
    }
}
