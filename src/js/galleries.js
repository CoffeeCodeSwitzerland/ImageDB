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
        console.log(currentGallery.attr('name'));
        currentGallery.removeClass('bg-light');
        currentGallery.addClass('bg-secondary text-white');
    });

    $('.galleryItem').on('dblclick', function() {
        window.location.href = "user.php?id=images&gid=" + currentGallery.attr('name');
    });

    $('#gallery_deleteForm_deleteButton').on('click', function () {
       $('#gallery_deleteForm_galleryId').val(currentGallery.attr('name'));
       $('#gallery_deleteForm').submit();
    });

    $('#galleries_editGallery').on('click', function() {
        if(currentGallery != null){
            $('#galleries_editGalleryName').val($('#title_' + currentGallery.attr('name')).text());
            $('#galleries_editGalleryDescription').val($('#description_' + currentGallery.attr('name')).text())
        }
    });
});