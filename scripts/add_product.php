<?php
session_start();

// Verificar se o usuário está logado
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: ../views/login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Receber os dados do formulário
    $name_product = $_POST['name_product'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];

    // Conectar ao banco de dados
    $mysqli = new mysqli("localhost", "root", "", "pv");

    // Verificar conexão
    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    // Inserir produto no banco de dados
    $stmt = $mysqli->prepare("INSERT INTO product (name_product, price, quantity) VALUES (?, ?, ?)");
    $stmt->bind_param("sdi", $name_product, $price, $quantity);
    
    if ($stmt->execute()) {
        echo "Produto adicionado com sucesso!";
    } else {
        echo "Erro ao adicionar produto: " . $stmt->error;
    }

    $stmt->close();
    $mysqli->close();
}
?>

<?php include('../partials/header.php'); ?>
<main>
    <h1>Produto Adicionado</h1>
    <p>O produto foi adicionado com sucesso.</p>
    <p><a href="../views/add_product.php">Adicionar outro produto</a></p>
</main>
<?php include('../partials/footer.php'); ?>
