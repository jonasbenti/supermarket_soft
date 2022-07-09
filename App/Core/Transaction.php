<?php

namespace App\SupermarketSoft\Core;

use App\SupermarketSoft\Core\Connection;
use PDO;

class Transaction
{
    /**
     * Atributo que recebe as infomacoes de conexao
     *
     * @var \PDO|null
     */
    private static ?\PDO $conn = null;

    /**
     * Abre a conexao com o banco e inicia a transacao
     *
     * @return void
     */
    public static function open(): void
    {
        self::$conn = Connection::open();
        self::$conn->beginTransaction();
    }

    /**
     * Comita as informacoes e fecha a conexao com o banco
     *
     * @return void
     */
    public static function close(): void
    {
        if (self::$conn) {
            self::$conn->commit();
            self::$conn = null;
        }
    }

    /**
     * Pega as informacoes da transacao ativa
     *
     * @return \PDO|null
     */
    public static function get(): ?\PDO
    {
        return self::$conn;
    }

    /**
     * Desfaz todas as alteracoes realizadas na transacao ativa
     *
     * @return void
     */
    public static function rollback(): void
    {
        if (self::$conn) {
            self::$conn->rollback();
            self::$conn = null;
        }
    }
}
