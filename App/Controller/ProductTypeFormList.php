<?php

namespace App\SupermarketSoft\Controller;

use Exception;
use App\SupermarketSoft\Core\Transaction;
use App\SupermarketSoft\Helper\RenderizadorDeHtmlTrait;
use App\SupermarketSoft\Model\TypeProduct;

class ProductTypeFormList
{
    use RenderizadorDeHtmlTrait;

    /**
     * Atributo responsavel por popular os tipos de produto
     *
     * @var array
     */
    private array $dataProductType = [];

    /**
     * Atributo que instancia a classe do tipo de produto
     *
     * @var TypeProduct|null
     */
    private ?TypeProduct $typeProductModel = null;

    /**
     * Popula os atributos da classe
     */
    public function __construct() 
    {
        $this->dataProductType = [
            'id' => '',
            'description' => '',
            'tax_percentage' => ''
        ];

        $this->typeProductModel = new TypeProduct();
    }

    /**
     * Busca as informacoes dos registros a serem editados
     *
     * @param integer $id
     * @return array dados de um tipo de produto
     */
    public function find(int $id): array
    {
        try {
            Transaction::open();
            $dataProductType = $this->typeProductModel->find($id);
            Transaction::close();

            return $dataProductType;
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    /**
     * Carrega a lista com todos os tipos de produto
     *
     * @return array
     */
    public function list(): array
    {
        try {
            Transaction::open();
            $list = $this->typeProductModel->all();
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
        $productTypesList = $this->list();

        $id = filter_input(
            INPUT_GET,
            'id',
            FILTER_VALIDATE_INT
        );

        $title = 'Inserir tipo de produto';
        $buttonText = 'Inserir';
        $buttonType = 'success';

        if ($id) {
            $this->dataProductType = $this->find($id);
            $title = "Editar tipo de produto ID: $id";
            $buttonText = "Editar ID: $id";
            $buttonType = "primary";
        }

        echo $this->renderizaHtml(
            'product_type/form_list_product_type.php',
            [
                'title' => $title,
                'button_text' => $buttonText,
                'button_type' => $buttonType,
                'id' => $this->dataProductType['id'],
                'description' => $this->dataProductType['description'],
                'tax_percentage' => $this->dataProductType['tax_percentage'],
                'product_types' => $productTypesList,
            ]
        );
    }
}
