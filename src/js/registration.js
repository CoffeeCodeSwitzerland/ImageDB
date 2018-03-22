$(document).ready(function () {
    var registration_password = document.getElementById('registration_password');
    var registration_repeatPassword = document.getElementById('registration_repeatPassword');
    var isPasswordTestVisible = false;
    var registration_passwordNotEqual = document.getElementById('registration_passwordNotEqual');

    $('#registration_passwordNotEqual').hide();
    $('#registration_register').prop('disabled', true);

    /**
     * Checks if password are equal and shows message if not
     */
    $('.pwCheck').on('keyup', function () {
        console.log($('#registration_password').val() + ' ' + $('#registration_repeatPassword').val());
        if ($.trim($('#registration_password').val()) == $.trim($('#registration_repeatPassword').val()) && $.trim($('#registration_repeatPassword').val()).length > 0) {
            $('#registration_passwordNotEqual').hide();
            $('#registration_register').prop('disabled', false);
        } else {
            $('#registration_passwordNotEqual').show();
            $('#registration_register').prop('disabled', true);
        }

    });
});