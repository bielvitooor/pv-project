<?php
require_once("../banco/Connection.php");
require_once("../dao/ProductDao.php");
require_once ("../dao/PaymentDao.php");
use config\banco\Connection as Connection;

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $quantities = $_POST['quantities'];

    try {
        $conn = Connection::getConnection();
        $productDao = new ProductDao($conn);
        $products = [];
        foreach ($quantities as $id => $quantity) {
            if ($quantity > 0) {
                $product = $productDao->getProductById($id);
                if ($product) {
                    $product['selected_quantity'] = $quantity;
                    $products[] = $product;
                }
            }
        }
        $paymentDao = new PaymentDao($conn);
        $payments = $paymentDao->getAllPayments();
    } catch (\PDOException $error) {
        die("Erro ao buscar produtos: " . $error->getMessage());
    }
} else {
    header("Location: ../index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmação do Pedido</title>
</head>
<body>
    <?php include('../partials/header.php'); ?>

    <main class="container mt-5">
        <?php if (!empty($products)) { ?>
            <h1 class="mb-4">Confirmação do Pedido</h1>

            <form id="confirm-form" method="POST">
                <section class="row">
                    <?php foreach ($products as $product): ?>
                        <div class="col-md-4 mb-3">
                            <div class="card p-3">
                                <h5 class="card-title"><?= $product['name_product'] ?></h5>
                                <p class="card-text">R$ <span class="price"><?= $product['price'] ?></span></p>
                                <div class="d-flex align-items-center mb-2">
                                    <button type="button" class="btn btn-secondary btn-sm mr-2 decrement" data-id="<?= $product['idproduct'] ?>">-</button>
                                    <input type="text" id="quantity-<?= $product['idproduct'] ?>" class="form-control text-center" name="quantities[<?= $product['idproduct']?>]" value="<?= $product['selected_quantity'] ?>" readonly>
                                    <button type="button" class="btn btn-secondary btn-sm ml-2 increment" data-id="<?= $product['idproduct'] ?>">+</button>
                                </div>
                                <button type="button" class="btn btn-danger btn-sm remove" data-id="<?= $product['idproduct'] ?>">Excluir</button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </section>

                <div class="total mt-4">
                    <?php
                    $total = 0.0;
                    foreach ($products as $product) {
                        $total += $product['price'] * $product['selected_quantity'];
                    }
                    ?>
                    <p>Total: R$ <strong id="subtotal"><?= number_format($total, 2) ?></strong></p>
                </div>
            </form>
            <button id="confirmar-pedido" class="btn btn-primary mt-3">Confirmar Pedido</button>

            <div class="modal fade" id="modal-confirmacao" tabindex="-1" role="dialog" aria-labelledby="modal-confirmacaoLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modal-confirmacaoLabel">Confirme seus Dados</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="review-order" action="../controllers/GuestController.php" method="POST">
                                <div class="form-group">
                                    <label for="cpf">CPF:</label>
                                    <input type="text" id="cpf" name="cpf" class="form-control" required>
                                </div>

                                <div class="form-group">
                                    <label for="name">Nome:</label>
                                    <input type="text" id="name" name="name" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label for="payment">Forma de Pagamento:</label>
                                    <select id="payment" name="payment" class="form-control">
                                        <?php foreach ($payments as $payment):?>
                                            <option value="<?=$payment['idpayment']?>"><?=$payment['tipo'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="form-group text-right">
                                    <button type="submit" class="btn btn-primary">Confirmar Pedido</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php } else { 
            header("Location: ../index.php");
        } ?>
    </main>

</body>
</html>
