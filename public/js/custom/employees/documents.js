$(document).ready(function() {
    var documentId = null;

    $('.delete-document-button').click(function() {
        documentId = $(this).data('id');

        openModal('delete-document-modal', 'static');
    });

    $('#delete-document-modal .yes-button').click(function() {
        closeModal('delete-document-modal');
        openModal('loading-modal', 'static');

        ajaxRequest('/enterprise_contracts/document/delete', 'POST', {
            id: documentId
        }, function(response) {
            closeModal('loading-modal');
            setModalContent('status-modal', 'Delete Document', response.message);
            openModal('status-modal', 'static');

            setTimeout(function() {
                closeModal('status-modal');

                location.reload();
            }, 2000);
        });
    });

    $('#delete-document-modal .no-button').click(function() {
        documentId = null;

        closeModal('delete-document-modal');
    });
});
