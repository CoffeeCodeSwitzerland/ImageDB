$(document).ready(function () {

    var currentUser = null;

    $('.adminUsers-DeleteButton').on('click', function () {
        currentUser = $(this);
    });

    $('#adminUsers_deleteBtn').on('click', function () {
        $('#adminUsers_deleteForm_emailaddress').val(currentUser.attr('name'));
        $('#adminUsers_deleteForm').submit();
    });

    $('.adminUsers-EditButton').on('click', function () {
        currentUser = $(this);
        $('#adminUsers_nickname').val(currentUser.attr('data-nickname'));
    });

    $('#adminUsers_editBtn').on('click', function () {
        $('#adminUsers_editForm_emailaddress').val(currentUser.attr('name'));
        $('#adminUsers_editForm_nickname').val($('#adminUsers_nickname').val());
        $('#adminUsers_editForm_password').val($('#adminUsers_newPassword').val());
        $('#adminUsers_editForm_passwordConfirmation').val($('#adminUsers_newPasswordRepeat').val());
        $('#adminUsers_editForm').submit();
    });
});