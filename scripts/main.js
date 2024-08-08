document.addEventListener("DOMContentLoaded", function () {
    // Seleciona os elementos que são exclusivos de cada página
    const incrementButtons = document.querySelectorAll(".increment");
    const decrementButtons = document.querySelectorAll(".decrement");
    const subtotalElement = document.getElementById("subtotal");
    const cpfInput = document.getElementById("cpf");
    const confirmOrderButton = document.getElementById("confirmar-pedido");
    const modal = document.getElementById("modal-confirmacao");
    const nameSection = document.getElementById("name-section");
    const closeButton = document.getElementById("fechar-modal");

    // Função para verificar CPF e mostrar/esconder o campo de nome
    function setupCpfVerification() {
        if (cpfInput) {
            cpfInput.addEventListener("blur", function () {
                const cpfValue = cpfInput.value;

                fetch("../controllers/GuestController.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({ cpf: cpfValue })
                })
                .then(response => response.json())
                .then(data => {
                    console.log("Response data:", data);
                    if (data.exists) {
                        nameSection.style.display = "none"; // Esconder campo de nome
                        document.getElementById("name").value = data.name; // Preencher campo de nome
                    } else {
                        nameSection.style.display = "block"; // Mostrar campo de nome
                    }
                })
                .catch(error => console.error("Erro:", error));
            });
        }
    }

    // Função para configurar o modal de confirmação
    function setupModal() {
        if (confirmOrderButton) {
            confirmOrderButton.addEventListener("click", function () {
                modal.showModal();
            });
        }

        if (closeButton) {
            closeButton.addEventListener("click", function () {
                modal.close();
            });
        }
    }

    // Função para atualizar o subtotal
    
    function updateSubtotal() {
        let subtotalValue = 0.00;
        document.querySelectorAll(".produto").forEach(function (product) {
            const id = product.querySelector(".increment").getAttribute('data-id');
            const priceElement = document.getElementById("price-" + id);
            const quantityElement = document.getElementById("quantity-" + id);
            const price = parseFloat(priceElement.innerText.replace("R$", "").trim().replace(",", "."));
            const quantity = parseInt(quantityElement.value) || 0;
            subtotalValue += price * quantity;
        });
        subtotalElement.innerText = subtotalValue.toFixed(2).replace(".", ","); // Formatação com vírgula
    }

    // Função para configurar os botões de incremento e decremento
    function setupQuantityButtons() {
        incrementButtons.forEach(function (button) {
            button.addEventListener("click", function () {
                const id = this.getAttribute('data-id');
                const counter = document.getElementById("quantity-" + id);
                const available = parseInt(document.getElementById("avaliable-" + id).innerText.split(" ")[0]) || 0; // Ajuste aqui
                if (parseInt(counter.value) < available) {
                    counter.value = parseInt(counter.value) + 1;
                    updateSubtotal();
                }
            });
        });

        decrementButtons.forEach(function (button) {
            button.addEventListener("click", function () {
                const id = this.getAttribute('data-id');
                const counter = document.getElementById("quantity-" + id);
                if (parseInt(counter.value) > 0) {
                    counter.value = parseInt(counter.value) - 1;
                    updateSubtotal();
                }
            });
        });
    }

    // Esconder o campo de nome inicialmente
    if (nameSection) {
        nameSection.style.display = "none";
    }

    // Executa as funções apenas se os elementos específicos existirem
    if (document.getElementById("confirmar-pedido")) {
        setupModal();
        setupCpfVerification();
    }

    if (document.querySelectorAll(".increment").length > 0) {
        setupQuantityButtons();
        updateSubtotal();
    }
});
