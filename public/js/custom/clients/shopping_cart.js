$(document).ready(function() {
    $('.remove-from-cart-button').click(function() {
        openModal('loading-modal', 'static');

        ajaxRequest('/cart/remove', 'POST', {
            id: $(this).data('id')
        }, function(response) {
            closeModal('loading-modal');
            setModalContent('status-modal', 'Shopping Cart', response.message);
            openModal('status-modal');
            closeModal('status-modal');

            if(response.status === 'Success') {
                location.reload();
            }
        });

        return false;
    });
});
