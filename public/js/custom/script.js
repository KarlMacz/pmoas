function openModal(id, backdrop, focusInputId) {
    if(backdrop === undefined || backdrop === null) {
        backdrop = true;
    }

    $('#' + id + '.modal').modal({
        backdrop: backdrop,
        show: true
    });

    if(focusInputId === undefined || focusInputId === null) {
        $('#' + focusInputId).focus();
    }
}

function delayOpenModal(id, backdrop, focusInputId) {
    if(backdrop === undefined || backdrop === null) {
        backdrop = true;
    }

    setTimeout(function() {
        $('#' + id + '.modal').modal({
            backdrop: backdrop,
            show: true
        });

        if(focusInputId === undefined || focusInputId === null) {
            $('#' + focusInputId).focus();
        }
    }, 500);
}

function closeModal(id) {
    $('#' + id + '.modal').modal('hide');
}

function delayCloseModal(id, doSomething) {
    setTimeout(function() {
        $('#' + id + '.modal').modal('hide');

        if(doSomething !== undefined && doSomething !== null) {
            doSomething();
        }
    }, 2000);
}

function setModalContent(id, title, content) {
    $('#' + id + '.modal .modal-title').html(title);
    $('#' + id + '.modal .modal-body').html(content);
}

function ajaxRequest(url, method, data, successCallback, errorCallback) {
    if(errorCallback === undefined || errorCallback === null || typeof errorCallback !== 'function') {
        errorCallback = function(arg0, arg1, arg2) {
            var tab = window.open();

            tab.document.write(arg0.responseText);
        };
    }

    $.ajax({
        url: url,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        method: method,
        data: data,
        dataType: 'json',
        success: successCallback,
        error: errorCallback
    });
}

function loadDateTime() {
    ajaxRequest('/resources/date_time', 'GET', {}, function(response) {
        $('[data-load="date"]').text(response.date);
        $('[data-load="time"]').text(response.time);

        setTimeout(loadDateTime, 30000);
    });
}

$(document).ready(function() {
    loadDateTime();

    $('.rating').each(function(index) {
        var dataRate = $(this).data('rate');

        if(dataRate !== undefined && dataRate !== null && dataRate !== '') {
            $(this).parent().find('.star').removeClass('fa-star text-warning').addClass('fa-star-o');

            for(var i = 0; i < dataRate; i++) {
                $(this).find('.star').eq(i).removeClass('fa-star-o').addClass('fa-star text-warning');
            }
        }
    });

    $('.rating:not(.fixed-rating) > .star').mouseover(function() {
        $(this).parent().find('.star').removeClass('fa-star text-warning').addClass('fa-star-o');

        for(var i = 0; i <= $(this).index(); i++) {
            $(this).parent().find('.star').eq(i).removeClass('fa-star-o').addClass('fa-star text-warning');
        }
    });

    $('.rating:not(.fixed-rating) > .star').mouseleave(function() {
        var dataRate = $(this).parent().data('rate');

        if(dataRate !== undefined && dataRate !== null && dataRate !== '') {
            $(this).parent().find('.star').removeClass('fa-star text-warning').addClass('fa-star-o');

            for(var i = 0; i < dataRate; i++) {
                $(this).parent().find('.star').eq(i).removeClass('fa-star-o').addClass('fa-star text-warning');
            }
        } else {
            for(var i = 0; i <= $(this).index(); i++) {
                $(this).parent().find('.star').eq(i).removeClass('fa-star text-warning').addClass('fa-star-o');
            }
        }
    });

    $('.rating:not(.fixed-rating) > .star').click(function() {
        var dataFor = $(this).parent().data('for');
        var rate = $(this).index() + 1;

        $(this).parent().attr('data-rate', rate);

        if(dataFor !== undefined && dataFor !== null && dataFor !== '') {
            $('#' + dataFor).val(rate);
        }

        $(this).parent().find('.star').removeClass('fa-star text-warning').addClass('fa-star-o');

        for(var i = 0; i < rate; i++) {
            $(this).parent().find('.star').eq(i).removeClass('fa-star-o').addClass('fa-star text-warning');
        }
    });

    $('.reset-rating-button').click(function() {
        var dataRatingId = $(this).data('rating-id');

        if(dataRatingId !== undefined && dataRatingId !== null && dataRatingId !== '') {
        }
    });
});
