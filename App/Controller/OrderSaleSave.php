<?php

namespace App\SupermarketSoft\Controller;

use Exception;
use App\SupermarketSoft\Core\Transaction;
use App\SupermarketSoft\Helper\RenderizadorDeHtmlTrait;
use App\SupermarketSoft\Model\OrderSale;
use App\SupermarketSoft\Model\OrderSaleItem;

class OrderSaleSave
{
    use RenderizadorDeHtmlTrait;

    /**
     * Salvar pedido e os items do pedido
     *
     * @param array $orderItems
     * @param array $order
     * @return void
     */
    public function save(array $orderItems, array $orderSale): void
    {
        try {
            Transaction::open();
            $order = new OrderSale();
            $orderId = $order->save($orderSale);
            $orderItem = new OrderSaleItem();

            foreach ($orderItems as $item) {
                $item['order_sale_id'] = $orderId;
                $orderItem->save($item);
            }

            Transaction::close();
            header("Location: /order-sale");
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    /**
     * Metodo responsavel por validar os inputs, inserir/editar  produto
     *
     * @return void
     */
    public function processReq(): void
    {
        $order['order_date'] = filter_input(
            INPUT_POST,
            'order_date',
            FILTER_SANITIZE_FULL_SPECIAL_CHARS
        );

        $order['order_total'] = filter_input(
            INPUT_POST,
            'order_total',
            FILTER_SANITIZE_FULL_SPECIAL_CHARS
        );

        $order['order_total_tax'] = filter_input(
            INPUT_POST,
            'order_total_tax',
            FILTER_SANITIZE_FULL_SPECIAL_CHARS
        );

        $orderItems = json_decode($_POST['order_items'], true);
        $this->save($orderItems, $order);
    }
}
