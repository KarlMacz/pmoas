$(document).ready(function() {
    var employeeId = null;

    $('.delete-employee-button').click(function() {
        employeeId = $(this).data('id');

        openModal('delete-employee-modal', 'static');
    });

    $('#delete-employee-modal .yes-button').click(function() {
        closeModal('delete-employee-modal');
        openModal('loading-modal', 'static');

        ajaxRequest('/employees/delete', 'POST', {
            id: employeeId
        }, function(response) {
            closeModal('loading-modal');
            setModalContent('status-modal', 'Delete Employee', response.message);
            openModal('status-modal', 'static');

            setTimeout(function() {
                closeModal('status-modal');

                location.reload();
            }, 2000);
        });
    });

    $('#delete-employee-modal .no-button').click(function() {
        employeeId = null;

        closeModal('delete-employee-modal');
    });
});
