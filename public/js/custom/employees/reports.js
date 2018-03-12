$(document).ready(function() {
    $('.generate-report-button').click(function() {
        openModal('loading-modal', 'static');

        ajaxRequest('/reports/generate/' + $(this).data('type'), 'GET', {}, function(response) {
            closeModal('loading-modal');

            location.reload();
        });
    });

    $('.view-report-button').click(function() {
        setModalContent('status-modal', 'View Report', '<iframe src="' + $('meta[name="main-route"]').attr('content') + '/reports/view/' + $(this).data('type') + '/' + $(this).data('id') + '" frameborder="0" style="height: 400px; width: 100%;"></iframe>');
        openModal('status-modal');
    });
});
