$(document).ready(function() {
    $('.view-contract-button').click(function() {
        openModal('loading-modal');

        ajaxRequest('/contracts/view', 'POST', {
            id: $(this).data('id')
        }, function(response) {
            closeModal('loading-modal');
            setModalContent('status-modal', 'View Contract', response.message);
        });
    });
});
