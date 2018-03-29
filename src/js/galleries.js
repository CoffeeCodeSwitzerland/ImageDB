$(document).ready(function () {

    $('#galleries_newGalleryButton').prop('disabled', true);

    $('#galleries_newGalleryName').on('keyup', function () {
        if ($.trim($(this).val()).length > 3) {
            $('#galleries_newGalleryButton').prop('disabled', false);
        }
        else {
            $('#galleries_newGalleryButton').prop('disabled', true);
        }
    });
});