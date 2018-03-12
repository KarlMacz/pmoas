$(document).ready(function() {
    var contractId = null;

    $('.delete-contract-button').click(function() {
        contractId = $(this).data('id');

        openModal('delete-contract-modal', 'static');
    });

    $('#delete-contract-modal .yes-button').click(function() {
        closeModal('delete-contract-modal');
        openModal('loading-modal', 'static');

        ajaxRequest('/enterprise_contracts/delete', 'POST', {
            id: contractId
        }, function(response) {
            closeModal('loading-modal');
            setModalContent('status-modal', 'Delete Contract', response.message);
            openModal('status-modal', 'static');

            setTimeout(function() {
                closeModal('status-modal');

                location.reload();
            }, 2000);
        });
    });

    $('#delete-contract-modal .no-button').click(function() {
        contractId = null;

        closeModal('delete-contract-modal');
    });
});
