$(document).ready(function() {
    $('.generate-report-button').click(function() {
        delayOpenModal('loading-modal', 'static');

        ajaxRequest('/reports/generate/' + $(this).data('type'), 'GET', {}, function(response) {
            closeModal('loading-modal');

            setTimeout(function() {
                location.reload();
            }, 1000);
        });
    });

    $('.view-report-button').click(function() {
        setModalContent('status-modal', 'View Report', '<iframe src="' + $('meta[name="main-route"]').attr('content') + '/reports/view/' + $(this).data('type') + '/' + $(this).data('id') + '" frameborder="0" style="height: 400px; width: 100%;"></iframe>');
        delayOpenModal('status-modal');
    });
});
