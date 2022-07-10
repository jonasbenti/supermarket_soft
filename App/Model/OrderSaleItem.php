<?php

namespace App\SupermarketSoft\Model;

use PDO;
use Exception;
use App\SupermarketSoft\Core\Transaction;

class OrderSaleItem extends ModelBase
{
    /**
     * Define a tabela que sera utilizada para executar os metodo da classe pai
     */
    public function __construct()
    {
        parent::__construct("order_sale_item");
    }

    /**
     * Busca todos os itens que pertencem ao pedido
     *
     * @param integer $order_sale_id
     * @return array
     */
    public function findByOrderSale(int $order_sale_id): array
    {
        if ($conn = Transaction::get()) {
            $result = $conn->prepare("select * from {$this->getTable()} WHERE order_sale_id = :order_sale_id");
            $result->execute([':order_sale_id' => $order_sale_id]);

            return $result->fetchAll(PDO::FETCH_ASSOC);
        } else {
            throw new Exception('Não há transação ativa!!'.__FUNCTION__);
        }
    }
}
