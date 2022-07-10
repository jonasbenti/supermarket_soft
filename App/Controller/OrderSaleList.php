<?php

namespace App\SupermarketSoft\Controller;

use Exception;
use App\SupermarketSoft\Core\Transaction;
use App\SupermarketSoft\Model\OrderSale;
use App\SupermarketSoft\Helper\RenderizadorDeHtmlTrait;

class OrderSaleList
{
    use RenderizadorDeHtmlTrait;

    /**
     * Carrega a lista com todos os pedidos
     *
     * @return array
     */
    public function list(): array
    {
        try {
            Transaction::open();
            $ordersSalesModel = new OrderSale();
            $list = $ordersSalesModel->all();
            Transaction::close();

            return $list;
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

     /**
     * Metodo responsavel por validar os inputs e exibir
     * o formulario e a lista de tipos de produto
     *
     * @return void
     */
    public function processReq(): void
    {
        $ordersSalesList = $this->list();

        $title = 'Lista de pedidos';
        $buttonText = 'Novo Pedido';
        $buttonType = 'success';

        echo $this->renderizaHtml(
            'order_sale/list_order_sale.php',
            [
                'title' => $title,
                'button_text' => $buttonText,
                'button_type' => $buttonType,
                'sales_orders' => $ordersSalesList,
            ]
        );
    }
}
