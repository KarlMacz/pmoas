$(document).ready(function() {
    $('.view-report-button').click(function() {
        setModalContent('status-modal', 'View Report', '<iframe src="' + $('meta[name="main-route"]').attr('content') + '/reports/view/' + $(this).data('type') + '/' + $(this).data('id') + '" frameborder="0" style="height: 400px; width: 100%;"></iframe>');
        delayOpenModal('status-modal');
    });
});
