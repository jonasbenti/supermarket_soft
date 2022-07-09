<?php

namespace App\SupermarketSoft\Controller;

use Exception;
use App\SupermarketSoft\Core\Transaction;
use App\SupermarketSoft\Helper\RenderizadorDeHtmlTrait;
use App\SupermarketSoft\Model\Product;

class ProductSave
{
    use RenderizadorDeHtmlTrait;

    /**
     * Metodo responsavel por salvar o produto no banco de dados
     *
     * @param array $data
     * @return void
     */
    public function save(array $data): void
    {
        try {
            Transaction::open();
            $typeProductModel = new Product();
            $typeProductModel->save($data);
            Transaction::close();
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    /**
     * Metodo responsavel por validar os inputs, inserir/editar o produto
     *
     * @return void
     */
    public function processReq(): void
    {
        $data['description'] = filter_input(
            INPUT_POST,
            'description',
            FILTER_SANITIZE_FULL_SPECIAL_CHARS
        );

        $data['id'] = filter_input(
            INPUT_POST,
            'id',
            FILTER_VALIDATE_INT
        );

        $data['value'] = filter_input(
            INPUT_POST,
            'value',
            FILTER_VALIDATE_FLOAT
        );

        $data['type_product_id'] = filter_input(
            INPUT_POST,
            'type_product_id',
            FILTER_VALIDATE_FLOAT
        );

        $this->save($data);
        header("Location: /product");
    }
}


