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
                quantity = products[i].remaining_quantity;

                break;
            }
        }

        setModalContent('add-to-cart-modal', 'Add to Cart', '<h3 style="margin-top: 0;">' + name + '</h3><p>' + description + '</p><h4 class="text-right"><span class="pull-left">' + quantity + ' piece(s) left.</span> Php ' + price + ' / piece.</h4><form id="add-to-cart-form"><input type="hidden" name="id" value="' + $(this).data('id') + '"><div class="form-group"><label for="quantity-field">Quantity:</label><input type="number" name="quantity" id="quantity-field" class="form-control" min="1" max="' + quantity + '" placeholder="Quantity" required></div></form>');
        delayOpenModal('add-to-cart-modal', 'static');
    });

    $('#add-to-cart-modal .modal-footer > .yes-button').click(function() {
        if($('#quantity-field').val() !== '') {
            closeModal('add-to-cart-modal');
            delayOpenModal('loading-modal', 'static');

            ajaxRequest('/cart/add', 'POST', $('#add-to-cart-form').serialize(), function(response) {
                closeModal('loading-modal');
                setModalContent('status-modal', 'Add to Cart', response.message);
                delayOpenModal('status-modal', 'static');
                delayCloseModal('status-modal');
            });
        } else {
            $('#quantity-field').focus();
        }
    });

    $('#add-to-cart-modal .modal-footer > .no-button').click(function() {
        closeModal('add-to-cart-modal');
    });

    $('body').on('submit', '#add-to-cart-form', function() {
        return false;
    });
});
