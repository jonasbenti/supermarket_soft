<?php

namespace App\SupermarketSoft\Helper;

trait RenderizadorDeHtmlTrait
{
    /**
     * Metodo que renderia as informacoes no html
     *
     * @param string $caminhoTemplate
     * @param array $dados - informacoes necessarias para rederizar a tela
     * @return string
     */
    public function renderizaHtml(string $caminhoTemplate, array $dados): string
    {
        extract($dados);
        ob_start();

        require __DIR__ . '/../../View/' . $caminhoTemplate;
        $html = ob_get_clean();

        return $html;
    }
}
