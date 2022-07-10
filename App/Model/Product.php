<?php

namespace App\SupermarketSoft\Model;

use PDO;
use Exception;
use App\SupermarketSoft\Core\Transaction;

class Product extends ModelBase
{
    /**
     * Define a tabela que sera utilizada para executar os metodo da classe pai
     */
    public function __construct()
    {
        parent::__construct("product");
    }

    /**
     * Realiza a busca de 1 produto com a informacao do imposto
     *
     * @param int $id
     * @return array
     */
    public function find(int $id): array
    {
        if ($conn = Transaction::get()) {
            $result = $conn->prepare("select p.*, tp.tax_percentage as tax_percetage
            from {$this->getTable()} p 
            inner join type_product tp ON tp.id = p.type_product_id
            WHERE p.id= :id");
            $result->execute([':id' => $id]);

            return $result->fetch(PDO::FETCH_ASSOC);
        } else {
            throw new Exception('Nao ha transaçao ativa!!'.__FUNCTION__);
        }
    }

    /**
     * Realiza a busca de todos os produtos
     * Retorna descricao e imposto do tipo de produto junto
     *
     * @return array
     */
    public function all(): array
    {
        if ($conn = Transaction::get()) { 
            $result = $conn->query("select p.*, tp.tax_percentage as tax_percetage, tp.description as type_product
            from {$this->getTable()} p 
            inner join type_product tp ON tp.id = p.type_product_id
            order by id desc");

            return $result->fetchAll(PDO::FETCH_ASSOC);
        } else {
            throw new Exception('Nao ha transaçao ativa!!'.__FUNCTION__);
        }
    }
}
