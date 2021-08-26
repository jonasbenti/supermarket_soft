<?php

require_once "App/Core/Transaction.php";

class OrderSaleItem
{
    public static function find($id)
    {
        if ($conn = Transaction::get()) {            
            $result = $conn->prepare("select * from supermarket_soft.order_sale_item WHERE id= :id");
            $result->execute([':id' => $id]);
            
            return $result->fetch(PDO::FETCH_ASSOC);
        } else {
            throw new Exception('Não há transação ativa!!'.__FUNCTION__);
        }
    }

    public static function findByOrderSale($order_sale_id)
    {
        if ($conn = Transaction::get()) {            
            $result = $conn->prepare("select * from supermarket_soft.order_sale_item WHERE order_sale_id= :order_sale_id");
            $result->execute([':order_sale_id' => $order_sale_id]);
            
            return $result->fetchAll(PDO::FETCH_ASSOC);
        } else {
            throw new Exception('Não há transação ativa!!'.__FUNCTION__);
        }
    }

    public static function delete($id)
    {
        if ($conn = Transaction::get()) {
            $result = $conn->prepare("DELETE from supermarket_soft.order_sale_item WHERE id= :id");
            $result->execute([':id' => $id]);

            return $result;
        } else {
            throw new Exception('Não há transação ativa!!'.__FUNCTION__);
        }
    }

    public static function all()
    {
        if ($conn = Transaction::get()) { 
            $result = $conn->query("select * from supermarket_soft.order_sale_item ORDER BY id desc");

            return $result->fetchAll(PDO::FETCH_ASSOC);
        } else {
            throw new Exception('Não há transação ativa!!'.__FUNCTION__);
        }
    }

    public static function save($order_sale_item, $order_sale_id)
    {
        if ($conn = Transaction::get()) {
            foreach ($order_sale_item as $key => $value) {
                $order_sale_item[$key] = strip_tags(addslashes($value));
            }
            $order_sale_item['order_sale_id'] = $order_sale_id;
           
            $keys_insert = implode(", ",array_keys($order_sale_item));
            $values_insert = "'".implode("', '",array_values($order_sale_item))."'";
            $sql = "INSERT INTO supermarket_soft.order_sale_item ($keys_insert) VALUES ($values_insert)";
            $result = $conn->query($sql);            
            
            return $result;
        } else {
            throw new Exception('Não há transação ativa!!'.__FUNCTION__);            
        }
    }    
}
