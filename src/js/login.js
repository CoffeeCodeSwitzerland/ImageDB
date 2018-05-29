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

    $('#login_resetPasswordButton').on('click', function () {
        $(this).text('Send..');
        $(this).prop('disabled', true);
        $('#login_resetForm').submit();
    });

    $('#login_forgot').on('click', function () {
        console.log('hello');
        $('#login_resetMail').val('');
        $('#login_resetPasswordButton').text('Reset password');
    });
});