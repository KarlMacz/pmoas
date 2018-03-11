$(document).ready(function() {
    var transactionId = null;

    $('.confirm-transaction-button').click(function() {
        transactionId = $(this).data('id');

        openModal('confirm-transaction-modal', 'static');
    });

    $('#confirm-transaction-modal .yes-button').click(function() {
        closeModal('confirm-transaction-modal');
        delayOpenModal('loading-modal', 'static');

        ajaxRequest('/client_orders/confirm', 'POST', {
            id: transactionId
        }, function(response) {
            closeModal('loading-modal');
            setModalContent('status-modal', 'Confirm Transaction', response.message);
            delayOpenModal('status-modal', 'static');

            delayCloseModal('status-modal');

            if(response.status === 'Success') {
                location.reload();
            }
        });
    });

    $('#confirm-transaction-modal .no-button').click(function() {
        transactionId = null;

        closeModal('confirm-transaction-modal');
    });

    $('.mark-transaction-button').click(function() {
        transactionId = $(this).data('id');

        openModal('mark-transaction-modal', 'static');
    });

    $('.print-transaction-receipt-button').click(function() {
        setModalContent('status-modal', 'View Receipt', '<iframe src="' + $('meta[name="main-route"]').attr('content') + '/receipts/view/' + $(this).data('id') + '" frameborder="0" style="height: 400px; width: 100%;"></iframe>');
        delayOpenModal('status-modal');
    });

    $('#mark-transaction-modal .yes-button').click(function() {
        closeModal('mark-transaction-modal');
        delayOpenModal('loading-modal', 'static');

        ajaxRequest('/client_orders/mark', 'POST', {
            id: transactionId
        }, function(response) {
            closeModal('loading-modal');
            setModalContent('status-modal', 'Mark Transaction as Delivered', response.message);
            delayOpenModal('status-modal', 'static');

            delayCloseModal('status-modal');

            if(response.status === 'Success') {
                location.reload();
            }
        });
    });

    $('#mark-transaction-modal .no-button').click(function() {
        transactionId = null;

        closeModal('mark-transaction-modal');
    });

    $('.delete-transaction-button').click(function() {
        transactionId = $(this).data('id');

        openModal('delete-transaction-modal', 'static');
    });

    $('#delete-transaction-modal .yes-button').click(function() {
        closeModal('delete-transaction-modal');
        delayOpenModal('loading-modal', 'static');

        ajaxRequest('/client_orders/delete', 'POST', {
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
