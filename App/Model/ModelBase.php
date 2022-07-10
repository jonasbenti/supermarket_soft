<?php

namespace App\SupermarketSoft\Model;

use PDO;
use Exception;
use App\SupermarketSoft\Core\Transaction;

class ModelBase
{
    /**
     * atributo que define o nome da tabela
     *
     * @var string|null
     */
    private ?string $table = null;

    /**
     * Define qual tabela sera utilizada para executar os metodos da classe
     *
     * @param string $table
     */
    public function __construct(string $table)
    {
        $this->setTable($table);
    }

    /**
     * Define a variavel 
     *
     * @param string $table
     * @return void
     */
    public function setTable(string $table): void
    {
        $this->table = $table;
    }

    /**
     * Retorna a varivel
     *
     * @return string
     */
    public function getTable(): string
    {
        return $this->table;
    }

    /**
     * Realiza a busca de 1 registro
     *
     * @param int $id
     * @return array
     */
    public function find(int $id): array
    {
        if ($conn = Transaction::get()) {
            $result = $conn->prepare("select * from {$this->getTable()} WHERE id= :id");
            $result->execute([':id' => $id]);

            return $result->fetch(PDO::FETCH_ASSOC);
        } else {
            throw new Exception('Não há transação ativa!!'.__FUNCTION__);
        }
    }

    /**
     * Realiza a busca de todos os registros da tabela
     *
     * @return array
     */
    public function all(): array
    {
        if ($conn = Transaction::get()) {
            $result = $conn->query("select * from {$this->getTable()} ORDER BY id desc");

            return $result->fetchAll(PDO::FETCH_ASSOC);
        } else {
            throw new Exception('Não há transação ativa!!'.__FUNCTION__);
        }
    }

    /**
     * Salva os registros no BD seja insert ou update e retorna o id
     *
     * @param array $data
     * @return int $id - retorna o id do registro
     */
    public function save(array $data): ?int
    {
        if ($conn = Transaction::get()) {
            foreach ($data as $key => $value) {
                $data[$key] = strip_tags(addslashes($value));
            }

            $id = isset($data['id']) ? $data['id'] : 0;
            unset($data['id']);

            if (empty($id)) {
                $keys_insert = implode(", ",array_keys($data));
                $values_insert = "'".implode("', '",array_values($data))."'";
                $sql = "INSERT INTO {$this->getTable()} ($keys_insert) VALUES ($values_insert)";
            } else {
                $set = [];

                foreach ($data as $column => $value) {
                    $set[] = "$column = '$value'";
                }

                $set_update = implode(", ", $set);
                $sql = "UPDATE {$this->getTable()} SET $set_update, updated_at = now() WHERE id = '$id'";
            }

            $result = $conn->query($sql);

            if ($result) {
                $id = $id ?: $conn->lastInsertId();
            } else {
                throw new Exception('Erro ao inserir/atualizar registro na tabela: ' . $this->getTable());
            }

            return $id;
        } else {
            throw new Exception('Não há transação ativa!!'.__FUNCTION__);
        }
    }
}