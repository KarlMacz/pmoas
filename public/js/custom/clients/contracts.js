$(document).ready(function() {
    $('.view-contract-button').click(function() {
        setModalContent('status-modal', 'View Contract', '<iframe src="' + $('meta[name="main-route"]').attr('content') + '/contracts/view/' + $(this).data('id') + '" frameborder="0" style="height: 400px; width: 100%;"></iframe>');
        openModal('status-modal');
    });
});
