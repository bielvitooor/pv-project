<?php
require_once("../banco/Connection.php");
use config\banco\Connection as Banco;

try {
    // Obtém a conexão usando o método estático da classe Connection
    $conn = Banco::getConnection();

    // Verifica se a conexão foi estabelecida corretamente
    if ($conn instanceof \PDO) {
        echo "Conexão PDO estabelecida com sucesso!<br>";

        // Exemplo de execução de query
        $stmt = $conn->query("SELECT * FROM guest");
        $resultados = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        // Exibe os resultados
        foreach ($resultados as $resultado) {
            echo "ID: " . $resultado['idguest'] . ", Nome: " . $resultado['name'] . "<br>";
        }
    } else {
        echo "Erro ao estabelecer conexão PDO.";
    }
} catch (\PDOException $e) {
    die("Erro de conexão: " . $e->getMessage());
}
?>
