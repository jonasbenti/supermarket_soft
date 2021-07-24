<?php

require_once "App/Core/Transaction.php";

class OrderSale
{
    public static function find($id)
    {
        if ($conn = Transaction::get()) {            
            $result = $conn->prepare("select * from supermarket_soft.order_sale WHERE id= :id");
            $result->execute([':id' => $id]);
            
            return $result->fetch(PDO::FETCH_ASSOC);
        } else {
            throw new Exception('Não há transação ativa!!'.__FUNCTION__);
        }
    }

    public static function delete($id)
    {
        if ($conn = Transaction::get()) {
            $result = $conn->prepare("DELETE from supermarket_soft.order_sale WHERE id= :id");
            $result->execute([':id' => $id]);

            return $result;
        } else {
            throw new Exception('Não há transação ativa!!'.__FUNCTION__);
        }
    }

    public static function all()
    {
        if ($conn = Transaction::get()) { 
            $result = $conn->query("select * from supermarket_soft.order_sale ORDER BY id desc");

            return $result->fetchAll(PDO::FETCH_ASSOC);
        } else {
            throw new Exception('Não há transação ativa!!'.__FUNCTION__);
        }
    }

    public static function save($order_sale)
    {
        if ($conn = Transaction::get()) {
            foreach ($order_sale as $key => $value) {
                $order_sale[$key] = strip_tags(addslashes($value));
            }
            $id = isset($order_sale['id']) ? $order_sale['id'] : 0;
            unset($order_sale['id']);
           
            if (empty($id)) {
                $keys_insert = implode(", ",array_keys($order_sale));
                $values_insert = "'".implode("', '",array_values($order_sale))."'";
                $sql = "INSERT INTO supermarket_soft.order_sale ($keys_insert) VALUES ($values_insert)";
            } else {
                $set = [];
                foreach ($order_sale as $column => $value) {
                    $set[] = "$column = '$value'";
                }
                $set_update = implode(", ", $set);
                $sql = "UPDATE supermarket_soft.order_sale SET $set_update, updated_at = now() WHERE id = '$id'";
            }            
            $result = $conn->query($sql);
            
            if ($result) {
                $result = $conn->lastInsertId();
            }
            return $result;
        } else {
            throw new Exception('Não há transação ativa!!'.__FUNCTION__);            
        }
    }    
}
