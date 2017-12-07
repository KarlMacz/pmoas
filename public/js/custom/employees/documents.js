$(document).ready(function() {
    var documentId = null;

    $('.delete-document-button').click(function() {
        documentId = $(this).data('id');

        openModal('delete-document-modal', 'static');
    });

    $('#delete-document-modal .yes-button').click(function() {
        closeModal('delete-document-modal');
        delayOpenModal('loading-modal', 'static');

        ajaxRequest('enterprise_contracts/document/delete', 'POST', {
            id: documentId
        }, function(response) {
            closeModal('loading-modal');
            setModalContent('status-modal', 'Delete Document', response.message);
            delayOpenModal('status-modal', 'static');

            delayCloseModal('status-modal');

            if(response.status === 'Success') {
                location.reload();
            }
        });
    });

    $('#delete-document-modal .no-button').click(function() {
        documentId = null;

        closeModal('delete-document-modal');
    });
});
