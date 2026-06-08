// show/hide password
$(document).on('click', '[data-toggle="password"]', function(e) {
    e.preventDefault();
    var passwordField = $(this).closest('.form-group').find('input[type="password"]');
    var passwordFieldType = passwordField.attr('type');
    var newType = (passwordFieldType === 'password') ? 'text' : 'password';
    passwordField.attr('type', newType);
    $(this).toggleClass('fa-eye fa-eye-slash');
});
