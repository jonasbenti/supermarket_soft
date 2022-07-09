<?php

namespace App\SupermarketSoft\Model;

class OrderSale extends ModelBase
{
    /**
     * Define a tabela que sera utilizada para executar os metodo da classe pai
     */
    public function __construct()
    {
        parent::__construct("order_sale");
    }
}
