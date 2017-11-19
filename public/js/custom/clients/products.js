$(document).ready(function() {
    var products = null;

    $(function() {
        openModal('loading-modal', 'static');

        ajaxRequest('/resources/products', 'POST', {}, function(response) {
            closeModal('loading-modal');

            if(response.status === 'Success') {
                products = response.data;
            }
        });
    });

    $('.add-to-cart-button').click(function() {
        var name = null;
        var description = null;
        var price = null;
        var quantity = 0;

        for(var i = 0; i < products.length; i++) {
            if(products[i].id === $(this).data('id')) {
                name = products[i].name;
                description = products[i].description;
                price = products[i].price_per_piece;

                for(var j = 0; j < products[j].stocks.length; j++) {
                    quantity += products[i].stocks[j].quantity;
                    console.log(products[i].stocks[j].quantity);
                }

                break;
            }
        }

        setModalContent('add-to-cart-modal', 'Add to Cart', '<h3 style="margin-top: 0;">' + name + '</h3><p>' + description + '</p><h4 class="text-right">Php ' + price + ' / piece</h4><div class="form-group"><label for="quantity-field">Quantity:</label><input type="number" name="quantity" id="quantity-field" class="form-control" min="1" max="' + quantity + '" placeholder="Quantity" required></div>');

        delayOpenModal('add-to-cart-modal', 'static');
    });

    $('#add-to-cart-modal .modal-footer > .yes-button').click(function() {
        if($('#quantity-field').val() !== '') {
            closeModal('add-to-cart-modal');
        } else {
            $('#quantity-field').focus();
        }
    });

    $('#add-to-cart-modal .modal-footer > .no-button').click(function() {
        closeModal('add-to-cart-modal');
    });
});
