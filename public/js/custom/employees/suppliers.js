$(document).ready(function() {
    var supplierId = null;

    $('.delete-supplier-button').click(function() {
        supplierId = $(this).data('id');

        openModal('delete-supplier-modal', 'static');
    });

    $('#delete-supplier-modal .yes-button').click(function() {
        closeModal('delete-supplier-modal');
        openModal('loading-modal', 'static');

        ajaxRequest('/suppliers/delete', 'POST', {
            id: supplierId
        }, function(response) {
            closeModal('loading-modal');
            setModalContent('status-modal', 'Delete Supplier', response.message);
            openModal('status-modal', 'static');

            setTimeout(function() {
                closeModal('status-modal');

                location.reload();
            }, 2000);
        });
    });

    $('#delete-supplier-modal .no-button').click(function() {
        supplierId = null;

        closeModal('delete-supplier-modal');
    });
});
