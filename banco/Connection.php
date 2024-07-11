<?php
namespace config\banco;

class Connection {
    private static $servername = "localhost";
    private static $username = "root";
    private static $password = "";
    private static $dbname = "pv";
    private static $conn = null;

    // Método para obter a conexão com o banco de dados usando PDO
    public static function getConnection() {
        if (self::$conn === null) {
            try {
                self::$conn = new \PDO("mysql:host=" . self::$servername . ";dbname=" . self::$dbname, self::$username, self::$password);
                // Configuração para lançar exceções em caso de erros de SQL
                self::$conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            } catch (\PDOException $e) {
                die("Conexão falhou: " . $e->getMessage());
            }
        }
        return self::$conn;
    }

    // Método para fechar a conexão com o banco de dados
    public static function closeConnection() {
        self::$conn = null;
    }
}
?>
