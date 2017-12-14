$(document).ready(function() {
    var transactionId = null;

    $('.confirm-transaction-button').click(function() {
        $('#confirm-transaction-modal input[name"id"]').val($(this).data('id'));

        openModal('confirm-transaction-modal', 'static');
    });

    $('#confirm-transaction-modal .close-button').click(function() {
        $('#confirm-transaction-modal input[name"id"]').val('');

        closeModal('confirm-transaction-modal');
    });

    $('.delete-transaction-button').click(function() {
        transactionId = $(this).data('id');

        openModal('delete-transaction-modal', 'static');
    });

    $('#delete-transaction-modal .yes-button').click(function() {
        closeModal('delete-transaction-modal');
        delayOpenModal('loading-modal', 'static');

        ajaxRequest('client_orders/delete', 'POST', {
            id: transactionId
        }, function(response) {
            closeModal('loading-modal');
            setModalContent('status-modal', 'Delete Transaction', response.message);
            delayOpenModal('status-modal', 'static');

            delayCloseModal('status-modal');

            if(response.status === 'Success') {
                location.reload();
            }
        });
    });

    $('#delete-transaction-modal .no-button').click(function() {
        transactionId = null;

        closeModal('delete-transaction-modal');
    });
});
