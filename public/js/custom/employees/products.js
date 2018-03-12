$(document).ready(function() {
    var productId = null;

    $('.delete-product-button').click(function() {
        productId = $(this).data('id');

        openModal('delete-product-modal', 'static');
    });

    $('#delete-product-modal .yes-button').click(function() {
        closeModal('delete-product-modal');
        openModal('loading-modal', 'static');

        ajaxRequest('/products_catalogue/delete', 'POST', {
            id: productId
        }, function(response) {
            closeModal('loading-modal');
            setModalContent('status-modal', 'Delete Product', response.message);
            openModal('status-modal', 'static');

            setTimeout(function() {
                closeModal('status-modal');

                location.reload();
            }, 2000);
        });
    });

    $('#delete-product-modal .no-button').click(function() {
        productId = null;

        closeModal('delete-product-modal');
    });
});
