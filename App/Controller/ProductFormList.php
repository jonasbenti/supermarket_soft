<?php

namespace App\SupermarketSoft\Controller;

use Exception;
use App\SupermarketSoft\Model\Product;
use App\SupermarketSoft\Core\Transaction;
use App\SupermarketSoft\Helper\RenderizadorDeHtmlTrait;

class ProductFormList
{
    use RenderizadorDeHtmlTrait;

    /**
     * Atributo responsavel por popular os tipos de produto
     *
     * @var array
     */
    private array $dataProduct = [];
    /**
     * Atributo que instancia a classe de produto
     *
     * @var Product|null
     */
    private ?Product $ProductModel = null;

    public function __construct() 
    {
        $this->dataProduct = [
            'id' => '',
            'description' => '',
            'value' => '',
            'type_product_id' => ''
        ];

        $this->productModel = new Product();
    }

    /**
     * Busca as informacoes do registro pelo id
     *
     * @param integer $id
     * @return array
     */
    public function find(int $id): array
    {
        try {
            Transaction::open();
            $data = $this->productModel->find($id);
            Transaction::close();

            return $data;
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    /**
     * Lista com todos os produtos
     *
     * @return array
     */
    public function list(): array
    {
        try {
            Transaction::open();
            $list = $this->productModel->all();
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
        $typeProduct = new ProductTypeFormList();
        $typeProductList = $typeProduct->list();

        $productList = $this->list();

        $id = filter_input(
            INPUT_GET,
            'id',
            FILTER_VALIDATE_INT
        );

        $title = 'Inserir produto';
        $buttonText = 'Inserir';
        $buttonType = 'success';

        if ($id) {
            $this->dataProduct = $this->find($id);
            $title = "Editar produto ID: $id";
            $buttonText = "Editar ID: $id";
            $buttonType = "primary";
        }

        echo $this->renderizaHtml(
            'product/form_list_product.php',
            [
                'title' => $title,
                'button_text' => $buttonText,
                'button_type' => $buttonType,
                'id' => $this->dataProduct['id'],
                'description' => $this->dataProduct['description'],
                'value' => $this->dataProduct['value'],
                'product_type_id' => $this->dataProduct['type_product_id'],
                'products' => $productList,
                'product_types' => $typeProductList,
            ]
        );
    }
}
