<?php

require_once 'App/Model/TypeProduct.php';

class TypeProductForm
{
    private $html;
    private $data;

    public function __construct() 
    {
    $this->html = file_get_contents('View/form_type_product.html');
    $this->data = [
    'id' => '',
    'description' => '',
    'value' => '',
    'tax_percentage' => ''
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

    public function save($param)
    {
        try {
            Transaction::open(DATABASE);
            TypeProduct::save($param);
            Transaction::close();

            $this->data = $param;
            header("Location: index.php?class=TypeProductList");
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function show()
    {
        $this->html = file_get_contents('View/form_type_product.html');
        $this->html = str_replace('{id}', $this->data['id'], $this->html);
        $this->html = str_replace('{description}', $this->data['description'], $this->html);
        $this->html = str_replace('{tax_percentage}', $this->data['tax_percentage'], $this->html);    
        echo $this->html;
    }
    
}


