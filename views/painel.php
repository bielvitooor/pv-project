<?php 
include ('../partials/header.php');
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

<header>
  <form action="../controllers/AdminController.php" method="POST">
    <button type="submit" name="logout">Sair</button>
  </form>
</header>

<div>Painel</div>
<div class="profile">
    <img src="profile.jpg" alt="Perfil">
</div>

<div class="container">
    <div class="main-panel">
        <div class="sidebar">
            <h3>Gerar Relatórios</h3>
            <button>Diário</button>
            <button>Semanal</button>
            <button>Mensal</button>
        </div>

        <div class="product-table">
            <h2>Abastecer Produtos</h2>
            <form action="../controllers/AdminController.php" method="POST">
                <table>
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
                            <td colspan="3">Nenhum produto cadastrado</td>

                        <tr>
                        <?php endif; ?>
                        <?php foreach ($products as $product): ?>
                            <th><?= $product['name_product'] ?></th>
                            <th>
                                <input type="number" name="products[<?= $product['idproduct'] ?>][price]" value="<?= $product['price'] ?>">
                            </th>
                            <th>
                                <input type="number" name="products[<?= $product['idproduct'] ?>][quantity]" value="<?= $product['quantity'] ?>">
                            </th>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <button type="submit" name="update">Atualizar Estoque</button>
            </form>
        </div>
    </div>
</div>
<script src="script/main.js"></script>
<?php include ('../partials/footer.php'); ?>
