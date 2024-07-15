<?php include('partials/header.php'); ?>
    <main>

        <h1>Bem-vindo ao Posto de Vendas do Campus Ceres</h1>

        <section class="produtos">
            <div class="produto">
                <img src="/pv-project/images/ovo_branco.jpg" alt="Ovo Branco">
                <h2>Ovo Branco</h2>
                <p>R$ 0.60 un</p>
                <p>60 restantes</p>
                <div class="quantidade">
                    <button>-</button>
                    <input type="text" value="0">
                    <button>+</button>
                </div>
            </div>

            <div class="produto">
                <img src="/pv-project/images/ovo_vermelho.jpg" alt="Ovo Vermelho">
                <h2>Ovo Vermelho</h2>
                <p>R$ 0.80 un</p>
                <p>60 restantes</p>
                <div class="quantidade">
                    <button>-</button>
                    <input type="text" value="0">
                    <button>+</button>
                </div>
            </div>

            <div class="produto">
                <img src="/pv-project/images/sobrecoxa.jpg" alt="Sobrecoxa">
                <h2>Sobrecoxa</h2>
                <p>R$ 5.50 Kg</p>
                <p>60 restantes</p>
                <div class="quantidade">
                    <button>-</button>
                    <input type="text" value="0">
                    <button>+</button>
                </div>
            </div>

            <div class="produto indisponivel">
                <img src="/pv-project/images/leite.jpg" alt="Leite">
                <h2>Leite</h2>
                <p>R$ 0.80 L</p>
                <p>Indisponível</p>
                <div class="quantidade">
                    <button disabled>-</button>
                    <input type="text" value="0" disabled>
                    <button disabled>+</button>
                </div>
            </div>
            
        </section>

        <div class="total">
            <p>Total: R$ 0.0</p>
        </div>

        <button class="comprar">Comprar</button>
        
    </main>
<?php include('partials/footer.php'); ?>
