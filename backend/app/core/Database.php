<?php

namespace App\Core;

use Exception;
use PDO;
use PDOException;

class Database
{
    private $host;
    private $user;
    private $pass;
    private $dbname;
    private $charset;
    private $port;

    private $pdo;

  

    public function __construct()
    {
        $this->host = $_ENV['DB_HOST'];
        $this->dbname = $_ENV['DB_NAME'];
        $this->user = $_ENV['DB_USER'];
        $this->pass = $_ENV['DB_PASS'];
        $this->charset = $_ENV['DB_CHARSET'];
        $this->port = $_ENV['DB_PORT'];
    }

    public function getConnection()
    {
        if ($this->pdo === null) {
            try {
                $dsn = "mysql:host={$this->host};port={$this->port};dbname={$this->dbname};charset={$this->charset}";

                $this->pdo = new PDO($dsn, $this->user, $this->pass, [
                    PDO::ATTR_PERSISTENT => true,
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
                    PDO::ATTR_EMULATE_PREPARES => false,
                    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES {$this->charset}"
                ]);
            } catch (PDOException $e) {
                error_log("Erro de conexão: " . $e->getMessage());
                throw new Exception("Falha ao conectar ao banco de dados");
            }
        }

        return $this->pdo;
    }
}
