<?php
class Database {
    private $connection;

    public function __construct() {
        $this->connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);

        if ($this->connection->connect_error) {
            error_log("Conexión fallida: " . $this->connection->connect_error);
            die("Conexión a la base de datos fallida. Por favor, inténtelo de nuevo más tarde.");
        }
    }

    public function getConnection() {
        return $this->connection;
    }
}


