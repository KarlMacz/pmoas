$(document).ready(function() {
    var productId = null;

    $('.delete-product-button').click(function() {
        productId = $(this).data('id');

        openModal('delete-product-modal', 'static');
    });

    $('#delete-product-modal .yes-button').click(function() {
        closeModal('delete-product-modal');
        delayOpenModal('loading-modal', 'static');

        ajaxRequest('/products_catalogue/delete', 'POST', {
            id: productId
        }, function(response) {
            closeModal('loading-modal');
            setModalContent('status-modal', 'Delete Product', response.message);
            delayOpenModal('status-modal', 'static');

            delayCloseModal('status-modal');

            if(response.status === 'Success') {
                location.reload();
            }
        });
    });

    $('#delete-product-modal .no-button').click(function() {
        productId = null;

        closeModal('delete-product-modal');
    });
});
