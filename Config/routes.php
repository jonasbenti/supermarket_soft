<?php

use App\SupermarketSoft\Controller\Home;
use App\SupermarketSoft\Controller\ProductSave;
use App\SupermarketSoft\Controller\OrderSaleForm;
use App\SupermarketSoft\Controller\OrderSaleList;
use App\SupermarketSoft\Controller\OrderSaleSave;
use App\SupermarketSoft\Controller\ProductFormList;
use App\SupermarketSoft\Controller\ProductTypeSave;
use App\SupermarketSoft\Controller\ProductTypeFormList;

return [
    '/' => Home::class,
    '/home' => Home::class,
    '/product-type' => ProductTypeFormList::class,
    '/product-type-save' => ProductTypeSave::class,
    '/product' => ProductFormList::class,
    '/product-save' => ProductSave::class,
    '/order-sale' => OrderSaleList::class,
    '/order-sale-create' => OrderSaleForm::class,
    '/order-sale-save' => OrderSaleSave::class
];