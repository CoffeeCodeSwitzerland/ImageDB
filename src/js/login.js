$(document).ready(function() {
    $('#login_login').prop('disabled', true);
    $('#login_fieldsEmpty').hide();

    $('.contentCheck').on('keyup', function() {
        $('#login_invalidCredentials').hide();
        // $('#login_emailaddress').val() + ' ' + $('#login_password').val());
        console.log($('#login_emailaddress').val().length);
        if($('#login_emailaddress').val().length > 0 && $('#login_password').val().length > 0) {
            $('#login_fieldsEmpty').hide();
            $('#login_login').prop('disabled', false);
        } else {
            $('#login_fieldsEmpty').show();
            $('#login_login').prop('disabled', true);
        }

    });
});