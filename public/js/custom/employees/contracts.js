$(document).ready(function() {
    var contractId = null;

    $('.delete-contract-button').click(function() {
        contractId = $(this).data('id');

        openModal('delete-contract-modal', 'static');
    });

    $('#delete-contract-modal .yes-button').click(function() {
        closeModal('delete-contract-modal');
        delayOpenModal('loading-modal', 'static');

        ajaxRequest('/enterprise_contracts/delete', 'POST', {
            id: contractId
        }, function(response) {
            closeModal('loading-modal');
            setModalContent('status-modal', 'Delete Contract', response.message);
            delayOpenModal('status-modal', 'static');

            delayCloseModal('status-modal');

            if(response.status === 'Success') {
                location.reload();
            }
        });
    });

    $('#delete-contract-modal .no-button').click(function() {
        contractId = null;

        closeModal('delete-contract-modal');
    });
});
