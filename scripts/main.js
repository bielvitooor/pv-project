document.addEventListener("DOMContentLoaded", function () {
    const incrementButtons = document.querySelectorAll(".increment");
    const decrementButtons = document.querySelectorAll(".decrement");
    const subtotalElement = document.getElementById("subtotal");
    const cpf = document.getElementById("cpf");

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
    // verifify cpf on database if exists via POST
    

});
