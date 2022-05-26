<?php

require_once 'App/Model/OrderSale.php';

class OrderSaleList
{
    private $html;

    public function __construct()
    {
        $this->html = file_get_contents('View/list_order_sale.html');
    }

    public function load()
    {
        try {
            Transaction::open(DATABASE);
            $order_sales = OrderSale::all();
            Transaction::close();
            $items = '';

            foreach ($order_sales as $order_sale) {
                $order_date = date_create($order_sale['order_date']); 
                $item = file_get_contents('View/item_order_sale.html');
                $item = str_replace('{order_id}', $order_sale['id'], $item);
                $item = str_replace('{order_date}', date_format($order_date,"d/m/Y"), $item);
                $item = str_replace('{order_total}', $order_sale['order_total'], $item);
                $item = str_replace('{order_total_tax}', $order_sale['order_total_tax'], $item);
                $items .= $item;
            }

            $this->html = str_replace('{items}', $items, $this->html);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function show()
    {
        $this->load();
        echo $this->html;
    }
}
