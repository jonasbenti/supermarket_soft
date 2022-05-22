<?php

require_once "App/Core/Transaction.php";

class TypeProduct
{
    public static function find($id)
    {
        if ($conn = Transaction::get()) {
            $result = $conn->prepare("select * from supermarket_soft.type_product WHERE id= :id");
            $result->execute([':id' => $id]);
            
            return $result->fetch(PDO::FETCH_ASSOC);
        } else {
            throw new Exception('Não há transação ativa!!'.__FUNCTION__);
        }
    }

    public static function delete($id)
    {
        if ($conn = Transaction::get()) {
            $result = $conn->prepare("DELETE from supermarket_soft.type_product WHERE id= :id");
            $result->execute([':id' => $id]);

            return $result;
        } else {
            throw new Exception('Não há transação ativa!!'.__FUNCTION__);
        }
    }

    public static function all()
    {
        if ($conn = Transaction::get()) { 
            $result = $conn->query("select * from supermarket_soft.type_product ORDER BY id desc");

            return $result->fetchAll(PDO::FETCH_ASSOC);
        } else {
            throw new Exception('Não há transação ativa!!'.__FUNCTION__);
        }
    }

    public static function save($type_product)
    {
        if ($conn = Transaction::get()) {
            foreach ($type_product as $key => $value) {
                $type_product[$key] = strip_tags(addslashes($value));
            }

            $id = isset($type_product['id']) ? $type_product['id'] : 0;
            unset($type_product['id']);
            unset($type_product['class']);
            unset($type_product['method']);

            if (empty($id)) {
                $keys_insert = implode(", ",array_keys($type_product));
                $values_insert = "'".implode("', '",array_values($type_product))."'";
                $sql = "INSERT INTO supermarket_soft.type_product ($keys_insert) VALUES ($values_insert)";
            } else {
                $set = [];

                foreach ($type_product as $column => $value) {
                    $set[] = "$column = '$value'";
                }

                $set_update = implode(", ", $set);
                $sql = "UPDATE supermarket_soft.type_product SET $set_update, updated_at = now() WHERE id = '$id'";
            }

            $result = $conn->query($sql);

            return $result;
        } else {
            throw new Exception('Não há transação ativa!!'.__FUNCTION__);
        }
    }
}