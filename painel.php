<?php include ('partials/header.php'); ?>
<header>
  
  <a href="#" style="color: white;">Sair</a>

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
            <table>
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Preço (R$)</th>
                        <th>Quantidade</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Ovo Branco</td>
                        <td><input type="text"></td>
                        <td><input type="text"></td>
                    </tr>
                    <tr>
                        <td>Ovo Vermelho</td>
                        <td><input type="text"></td>
                        <td><input type="text"></td>
                    </tr>
                    <tr>
                        <td>Sobrecoxa</td>
                        <td><input type="text"></td>
                        <td><input type="text"></td>
                    </tr>
                    <tr>
                        <td>Leite</td>
                        <td><input type="text"></td>
                        <td><input type="text"></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

    <?php include ('partials/footer.php'); ?>