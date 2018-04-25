$(document).ready(function () {

    var currentGallery = null;
    var deleteButton = $('#galleries_deleteGallery');
    var editButton = $('#galleries_editGallery');

    deleteButton.hide();
    editButton.hide();

    $('#galleries_newGalleryButton').prop('disabled', true);
    $('#galleries_newGalleryName').on('keyup', function () {
        if ($.trim($(this).val()).length > 3) {
            $('#galleries_newGalleryButton').prop('disabled', false);
        }
        else {
            $('#galleries_newGalleryButton').prop('disabled', true);
        }
    });

    $('.galleryItem').on('click', function() {
        deleteButton.show();
        editButton.show();
        if(currentGallery != null){
            currentGallery.removeClass('bg-secondary text-white');
            currentGallery.addClass('bg-light');
        }
        currentGallery = $(this);
        currentGallery.removeClass('bg-light');
        currentGallery.addClass('bg-secondary text-white');
    });
});