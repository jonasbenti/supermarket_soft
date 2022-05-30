<?php

require_once "App/Core/Transaction.php";

class Product
{
    public static function find($id)
    {
        if ($conn = Transaction::get()) {
            $result = $conn->prepare("select p.*, tp.tax_percentage as tax_percetage from product p 
            inner join type_product tp ON tp.id = p.type_product_id
            WHERE p.id= :id");
            $result->execute([':id' => $id]);

            return $result->fetch(PDO::FETCH_ASSOC);
        } else {
            throw new Exception('Não há transação ativa!!'.__FUNCTION__);
        }
    }

    public static function delete($id)
    {
        if ($conn = Transaction::get()) {
            $result = $conn->prepare("DELETE from product WHERE id= :id");
            $result->execute([':id' => $id]);

            return $result;
        } else {
            throw new Exception('Não há transação ativa!!'.__FUNCTION__);
        }
    }

    public static function all()
    {
        if ($conn = Transaction::get()) { 
            $result = $conn->query("select p.*, tp.tax_percentage as tax_percetage, tp.description as type_product from product p 
            inner join type_product tp ON tp.id = p.type_product_id
            order by id desc");

            return $result->fetchAll(PDO::FETCH_ASSOC);
        } else {
            throw new Exception('Não há transação ativa!!'.__FUNCTION__);
        }
    }

    public static function save($product)
    {
        if ($conn = Transaction::get()) {
            foreach ($product as $key => $value) {
                $product[$key] = strip_tags(addslashes($value));
            }

            $id = isset($product['id']) ? $product['id'] : 0;
            unset($product['id']);
            unset($product['class']);
            unset($product['method']);

            if (empty($id)) {
                $keys_insert = implode(", ",array_keys($product));
                $values_insert = "'".implode("', '",array_values($product))."'";
                $sql = "INSERT INTO product ($keys_insert) VALUES ($values_insert)";
            } else {
                $set = [];

                foreach ($product as $column => $value) {
                    $set[] = "$column = '$value'";
                }

                $set_update = implode(", ", $set);
                $sql = "UPDATE product SET $set_update, updated_at = now() WHERE id = '$id'";
            }
            $result = $conn->query($sql);

            return $result;
        } else {
            throw new Exception('Não há transação ativa!!'.__FUNCTION__);
        }
    }
}