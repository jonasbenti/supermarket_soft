<?php

require_once 'App/Model/TypeProduct.php';

class TypeProductList
{
    private $html;

    public function __construct()
    {
        $this->html = file_get_contents('View/list_type_product.html');
    }

    public function delete($param)
    {
        try {
            $id = (int) $param['id'];
            TypeProduct::delete($id);
        } catch(Exception $e) {
            echo $e->getMessage();
        }
    }

    public function load()
    {
        try {
            Transaction::open(DATABASE);
            $TypeProducts = TypeProduct::all();
            Transaction::close();

            $items = '';
            foreach ($TypeProducts as $TypeProduct) {     
                $item = file_get_contents('View/item_type_product.html');
                $item = str_replace('{id}', $TypeProduct['id'], $item);
                $item = str_replace('{description}', $TypeProduct['description'], $item);
                $item = str_replace('{tax_percentage}', $TypeProduct['tax_percentage'], $item); 
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
