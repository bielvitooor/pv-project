document.addEventListener('DOMContentLoaded', function() {
    const cartCountSpan = document.getElementById('subtotal');
    let subtotal = 0;

    const updateSubtotal = () => {
        cartCountSpan.textContent = subtotal.toFixed(2);
    };

    document.querySelectorAll('.increment').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const quantityInput = document.getElementById(`quantity-${id}`);
            const price = parseFloat(document.getElementById(`price-${id}`).textContent.replace('R$', '').trim());
            let quantity = parseInt(quantityInput.value);
            
            quantity++;
            quantityInput.value = quantity;
            subtotal += price;
            updateSubtotal();
        });
    });

    document.querySelectorAll('.decrement').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const quantityInput = document.getElementById(`quantity-${id}`);
            const price = parseFloat(document.getElementById(`price-${id}`).textContent.replace('R$', '').trim());
            let quantity = parseInt(quantityInput.value);
            
            if (quantity > 0) {
                quantity--;
                quantityInput.value = quantity;
                subtotal -= price;
                updateSubtotal();
            }
        });
    });
});
