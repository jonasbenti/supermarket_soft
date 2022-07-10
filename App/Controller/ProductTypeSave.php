<?php

namespace App\SupermarketSoft\Controller;

use Exception;
use App\SupermarketSoft\Core\Transaction;
use App\SupermarketSoft\Helper\RenderizadorDeHtmlTrait;
use App\SupermarketSoft\Model\TypeProduct;

class ProductTypeSave
{
    use RenderizadorDeHtmlTrait;

    /**
     * Metodo reposavel por criar/editar as informacoes no BD
     *
     * @param array $data
     * @return void
     */
    public function save(array $data): void
    {
        try {
            Transaction::open();
            $typeProductModel = new TypeProduct();
            $typeProductModel->save($data);
            Transaction::close();
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    /**
     * Metodo responsavel por validar os inputs e inserir/editar os tipos de produto
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
        $data['tax_percentage'] = filter_input(
            INPUT_POST,
            'tax_percentage',
            FILTER_VALIDATE_FLOAT
        );

        $this->save($data);
        header("Location: /product-type");
    }
}
