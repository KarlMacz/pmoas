$(document).ready(function() {
    $('body').on('click', '.remove-rule-button', function() {
        $(this).parent().parent().parent().remove();
    });

    $('.add-rule-button').click(function() {
        $('#rules-fieldset').append('<div class="form-group"><div class="input-group"><label class="input-group-addon">Rule / Prohibition:</label><input type="text" name="rules[]" class="form-control" placeholder="Rule / Prohibition" required><span class="input-group-btn"><button class="remove-rule-button btn btn-danger"><span class="fa fa-trash fa-fw"></span> Remove</button></span></div></div>');
    });
});
