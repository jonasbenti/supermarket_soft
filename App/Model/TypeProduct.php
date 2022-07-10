<?php

namespace App\SupermarketSoft\Model;

class TypeProduct extends ModelBase
{
    /**
     * Define a tabela que sera utilizada para executar os metodo da classe pai
     */
    public function __construct()
    {
        parent::__construct("type_product");
    }
}