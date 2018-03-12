$(document).ready(function() {
    var transactionId = null;

    $('.confirm-transaction-button').click(function() {
        transactionId = $(this).data('id');

        openModal('confirm-transaction-modal', 'static');
    });

    $('#confirm-transaction-modal .yes-button').click(function() {
        closeModal('confirm-transaction-modal');
        openModal('loading-modal', 'static');

        ajaxRequest('/client_orders/confirm', 'POST', {
            id: transactionId
        }, function(response) {
            closeModal('loading-modal');
            setModalContent('status-modal', 'Confirm Transaction', response.message);
            openModal('status-modal', 'static');

            setTimeout(function() {
                closeModal('status-modal');

                location.reload();
            }, 2000);
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
        openModal('status-modal');
    });

    $('#mark-transaction-modal .yes-button').click(function() {
        closeModal('mark-transaction-modal');
        openModal('loading-modal', 'static');

        ajaxRequest('/client_orders/mark', 'POST', {
            id: transactionId
        }, function(response) {
            closeModal('loading-modal');
            setModalContent('status-modal', 'Mark Transaction as Delivered', response.message);
            openModal('status-modal', 'static');

            setTimeout(function() {
                closeModal('status-modal');

                location.reload();
            }, 2000);
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
        openModal('loading-modal', 'static');

        ajaxRequest('/client_orders/delete', 'POST', {
            id: transactionId
        }, function(response) {
            closeModal('loading-modal');
            setModalContent('status-modal', 'Delete Transaction', response.message);
            openModal('status-modal', 'static');

            setTimeout(function() {
                closeModal('status-modal');

                location.reload();
            }, 2000);
        });
    });

    $('#delete-transaction-modal .no-button').click(function() {
        transactionId = null;

        closeModal('delete-transaction-modal');
    });
});
