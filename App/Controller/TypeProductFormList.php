<?php

require_once 'App/Model/TypeProduct.php';

class TypeProductFormList
{
    private $html;
    private $data;

    public function __construct() 
    {
        $this->html = file_get_contents('View/form_type_product_list.html');
        $this->data = [
            'id' => '',
            'description' => '',
            'value' => '',
            'tax_percentage' => '',
            'type_product_list' => ''
        ];
    }

    public function edit($param)
    {
        try {
            $id = (int) $param['id'];
            Transaction::open(DATABASE);
            $this->data = TypeProduct::find($id);
            Transaction::close();
        } catch (Exception $e) {
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

            $this->data['product_list'] = $items;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function save($param)
    {
        try {
            Transaction::open(DATABASE);
            TypeProduct::save($param);
            Transaction::close();

            $this->data = $param;
            header("Location: index.php?class=TypeProductFormList");
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function show()
    {
        $this->load();
        $this->html = file_get_contents('View/form_type_product_list.html');
        $this->html = str_replace('{id}', $this->data['id'], $this->html);
        $this->html = str_replace('{description}', $this->data['description'], $this->html);
        $this->html = str_replace('{tax_percentage}', $this->data['tax_percentage'], $this->html); 
        $this->html = str_replace('{items}', $this->data['product_list'], $this->html);

        echo $this->html;
    }
}


