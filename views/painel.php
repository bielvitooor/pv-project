<?php 
include('../partials/header.php');
require_once("../banco/Connection.php");
use config\banco\Connection as Connection;
require_once("../dao/AdminDAO.php");
require_once("../dao/ProductDao.php");
session_start();
?>
<?php
// Verificar se está logado
if (!isset($_SESSION['admin'])) {
    header("Location: ./login.php");
    exit();
}

$productDao = new ProductDao(Connection::getConnection());
$products = $productDao->showAllProducts();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel de Administração</title>
</head>
<body>
    <header class="bg-dark text-white p-3">
        <div class="container d-flex justify-content-between align-items-center">
            <h1 class="h4">Painel de Administração</h1>
            <form action="../controllers/AdminController.php" method="POST">
                <button type="submit" name="logout" class="btn btn-danger">Sair</button>
            </form>
        </div>
    </header>

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-3">
                <div class="sidebar bg-light p-3 rounded shadow-sm">
                    <h3>Gerar Relatórios</h3>
                    <button class="btn btn-primary btn-block mb-2">Diário</button>
                    <button class="btn btn-primary btn-block mb-2">Semanal</button>
                    <button class="btn btn-primary btn-block">Mensal</button>
                </div>
            </div>

            <div class="col-md-9">
                <div class="product-table bg-light p-3 rounded shadow-sm">
                    <h2>Abastecer Produtos</h2>
                    <form action="../controllers/AdminController.php" method="POST">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Preço (R$)</th>
                                    <th>Quantidade</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($products)): ?>
                                <tr>
                                    <td colspan="3" class="text-center">Nenhum produto cadastrado</td>
                                </tr>
                                <?php endif; ?>
                                <?php foreach ($products as $product): ?>
                                <tr>
                                    <td><?= htmlspecialchars($product['name_product'], ENT_QUOTES, 'UTF-8') ?></td>
                                    <td>
                                        <input type="number" name="products[<?= $product['idproduct'] ?>][price]" class="form-control" value="<?= htmlspecialchars($product['price'], ENT_QUOTES, 'UTF-8') ?>">
                                    </td>
                                    <td>
                                        <input type="number" name="products[<?= $product['idproduct'] ?>][quantity]" class="form-control" value="<?= htmlspecialchars($product['quantity'], ENT_QUOTES, 'UTF-8') ?>">
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <button type="submit" name="update" class="btn btn-success">Atualizar Estoque</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php include('../partials/footer.php'); ?>

</body>
</html>
