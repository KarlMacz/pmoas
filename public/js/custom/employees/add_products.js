$(document).ready(function() {
    $('body').on('click', '.remove-stock-button', function() {
        $(this).parent().parent().remove();
    });

    $('.add-stock-button').click(function() {
        $('#stocks-fieldset').append('<div class="row"><div class="col-sm-4"><div class="form-group"><div class="input-group"><label for="quantity-field" class="input-group-addon">Quantity:</label><input type="number" name="quantity[]" id="quantity-field" class="form-control" min="1" placeholder="Quantity" required></div></div></div><div class="col-sm-5"><div class="form-group"><div class="input-group"><label for="expiration-date-field" class="input-group-addon">Expiration Date:</label><input type="date" name="expiration_date[]" id="expiration-date-field" class="form-control" placeholder="Expiration Date" required></div></div></div><div class="col-sm-3 text-center"><button class="remove-stock-button btn btn-danger btn-sm"><span class="fa fa-trash fa-fw"></span> Remove</button></div></div>');
    });
});
