$(document).ready(function() {
    var helpId = null;

    $('.delete-help-button').click(function() {
        helpId = $(this).data('id');

        openModal('delete-help-modal', 'static');
    });

    $('#delete-help-modal .yes-button').click(function() {
        closeModal('delete-help-modal');
        openModal('loading-modal', 'static');

        ajaxRequest('/help/employees/delete', 'POST', {
            id: helpId
        }, function(response) {
            closeModal('loading-modal');
            setModalContent('status-modal', 'Delete Frequently Asked Question', response.message);
            openModal('status-modal', 'static');

            setTimeout(function() {
                closeModal('status-modal');

                location.reload();
            }, 2000);
        });
    });

    $('#delete-help-modal .no-button').click(function() {
        helpId = null;

        closeModal('delete-help-modal');
    });
});
