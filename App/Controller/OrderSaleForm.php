<?php

namespace App\SupermarketSoft\Controller;

use Exception;
use App\SupermarketSoft\Model\OrderSale;
use App\SupermarketSoft\Core\Transaction;
use App\SupermarketSoft\Model\OrderSaleItem;
use App\SupermarketSoft\Helper\RenderizadorDeHtmlTrait;

class OrderSaleForm
{
    use RenderizadorDeHtmlTrait;

    /**
     * Atributo responsavel por popular o pedido
     *
     * @var array
     */
    private array $dataOrder = [];

    /**
     * Atributo que instancia a classe do pedido
     *
     * @var OrderSale|null
     */
    private ?OrderSale $orderModel = null;

    public function __construct() 
    {
        $this->dataOrder = [
            'id' => '',
            'order_date' => date('d/m/Y'),
            'order_total' => '0',
            'order_total_tax' => '0',
            'combo_products' => '',
            'order_items' => []
        ];

        $this->orderModel = new OrderSale();
    }

    /**
     * Busca os dados do pedido e os itens que pertencem ao pedido
     *
     * @param integer $id - id do pedido
     * @return array
     */
    public function find(int $id): array
    {
        try {
            Transaction::open();
            $data = $this->orderModel->find($id);
            $orderItems = new OrderSaleItem();
            $data['order_items'] = $orderItems->findByOrderSale($id);
            Transaction::close();

            return $data;
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
        $id = filter_input(
            INPUT_GET,
            'id',
            FILTER_VALIDATE_INT
        );

        $title = 'Inserir pedido';
        $title2 = 'Inserir produto(Item)';
        $buttonText = 'Inserir';
        $buttonType = 'success';
        $productList = [];

        if ($id) {
            $this->dataOrder = $this->find($id);
            $title = "Editar pedido ID: $id";
            $buttonText = "Editar ID: $id";
            $buttonType = "primary";
        } else {
            $product = new ProductFormList();
            $productList = $product->list();
        }

        echo $this->renderizaHtml(
            'order_sale/form_order_sale.php',
            [
                'title' => $title,
                'title2' => $title2,
                'button_text' => $buttonText,
                'button_type' => $buttonType,
                'id' => $this->dataOrder['id'],
                'order_date' => $this->dataOrder['order_date'],
                'order_total' => $this->dataOrder['order_total'],
                'order_total_tax' => $this->dataOrder['order_total_tax'],
                'order_items' => json_encode($this->dataOrder['order_items']),
                'products' => $productList
            ]
        );
    }
}
