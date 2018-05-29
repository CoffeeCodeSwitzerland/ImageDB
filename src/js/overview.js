$(document).ready(function () {

    var isNickNameValid = true;
    var isCurrentPasswordValid = false;
    var arePasswordsValid = false;

    var currentNickname = $('#overview_nickname').val();

    $('#overview_change').prop('disabled', true);

    $('#overview_nickname').on('keyup', function () {
        var trimVal = $(this).val().trim();
        if (trimVal.length > 0 && trimVal != currentNickname) {
            isNickNameValid = true;
        } else {
            isNickNameValid = false;
        }
        checkValidity();
    });

    $('.contentCheck').on('keyup', function () {
        if ($.trim($('#overview_newPassword').val()) == $.trim($('#overview_newPasswordRepeat').val()) &&
            $.trim($('#overview_newPasswordRepeat').val()).length > 0) {
            arePasswordsValid = true;
        } else {
            arePasswordsValid = false;
        }
        checkValidity();
    });

    $('#overview_currentPassword').on('keyup', function () {

        if ($(this).val().trim().length > 0) {
            isCurrentPasswordValid = true;
        } else {
            isCurrentPasswordValid = false;
        }
        checkValidity();
    });

    function hasNickNameChanged() {
        return $('#overview_nickname').val().trim() != currentNickname;
    }

    function checkValidity() {


        var pwValid;
        var nickValid;

        // = arePasswordsValid && isCurrentPasswordValid && $('#overview_currentPassword').val().trim().length > 0;

        if (arePasswordsValid && isCurrentPasswordValid) {
            pwValid = true;
        } else if (
            $('#overview_currentPassword').val().trim().length == 0 &&
            $('#overview_newPassword').val().trim().length == 0 &&
            $('#overview_newPasswordRepeat').val().trim().length == 0) {
            pwValid = true;
        } else {
            pwValid = false;
        }

        console.log($('#overview_currentPassword').val().trim().length);
        console.log($('#overview_newPassword').val().trim().length);
        console.log($('#overview_newPasswordRepeat').val().trim().length);

        if (!hasNickNameChanged()) {
            if (isCurrentPasswordValid && arePasswordsValid) {
                nickValid = true;
            }
        }
        else if (hasNickNameChanged() && isNickNameValid) {
            nickValid = true;
        }
        else {
            nickValid = false;
        }

        // console.log("---------");
        // console.log("currentPW: " + isCurrentPasswordValid);
        // console.log("NickName: " + isNickNameValid);
        // console.log("NickNameChanged: " + hasNickNameChanged());
        // console.log("arePassword: " + arePasswordsValid);
        // console.log('nickValid: ' + nickValid);
        // console.log('pwValid:' + pwValid);
        var currentPw = $('#overview_currentPassword').val().trim().length > 0;

        if (pwValid && nickValid) {
            $('#overview_change').prop('disabled', false);
        } else {
            $('#overview_change').prop('disabled', true);
        }
    }
});