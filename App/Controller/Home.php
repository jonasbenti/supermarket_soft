<?php

namespace App\SupermarketSoft\Controller;

use App\SupermarketSoft\Helper\RenderizadorDeHtmlTrait;

class Home
{
    use RenderizadorDeHtmlTrait;

    public function processReq(): void
    {
        echo $this->renderizaHtml(
            'home.php',
            [
                'title' => 'Menu',
                'button_type' => 'info'
            ]
        );
    }
}
