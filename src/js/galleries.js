$(document).ready(function () {

    var currentGallery = null;
    var deleteButton = $('#galleries_deleteGallery');
    var editButton = $('#galleries_editGallery');

    var gallery_preEditTitle;
    var gallery_preEditDescription;

    deleteButton.hide();
    editButton.hide();

    $('#galleries_newGalleryButton').prop('disabled', true);

    $('.galleryCreateItem').on('keypress', function (e) {
        if (e.which == 13) {
            if (evaluateCreate()) {
                galleryCreate();
            }
        }
    });

    $('#galleries_newGalleryButton').on('click', function () {
        if (evaluateCreate()) {
            galleryCreate();
        }
    });

    $('.galleryCreateItem').on('keyup', function () {
        if (evaluateCreate()) {
            $('#galleries_newGalleryButton').prop('disabled', false);
        } else {
            $('#galleries_newGalleryButton').prop('disabled', true);
        }
    });

    function evaluateCreate() {
        if ($.trim($('#galleries_newGalleryName').val()).length > 3) {
            return true;
        }
        return false;
    }

    $('.galleryItem').on('click', function () {
        deleteButton.fadeIn();
        editButton.fadeIn();
        if (currentGallery != null) {
            currentGallery.removeClass('bg-secondary text-white');
            currentGallery.addClass('bg-light');
        }
        currentGallery = $(this);
        console.log(currentGallery.attr('name'));
        currentGallery.removeClass('bg-light');
        currentGallery.addClass('bg-secondary text-white');
    });

    $('.galleryItem').on('dblclick', function () {
        window.location.href = "user.php?id=images&gid=" + currentGallery.attr('name');
    });

    $('#gallery_deleteForm_deleteButton').on('click', function () {
        $('#gallery_deleteForm_galleryId').val(currentGallery.attr('name'));
        $('#gallery_deleteForm').submit();
    });

    $('#galleries_editGallery').on('click', function () {
        if (currentGallery != null) {
            var text =$('#description_' + currentGallery.attr('name')).text();
            var currentTitle = $('#title_' + currentGallery.attr('name')).text();
            var currentDescription = text ? "No description available" : text;
            gallery_preEditDescription = currentDescription;
            gallery_preEditTitle = currentTitle;
            $('#galleries_editGalleryName').val(currentTitle);

            if (currentDescription != 'No description available') {
                $('#galleries_editGalleryDescription').val(currentDescription);
            } else {
                $('#galleries_editGalleryDescription').val("");
            }

            $('#galleries_editGalleryButton').prop('disabled', true);
        }
    });

    $('.galleryEditItem').on('keyup', function () {
        if (evaluateEdit()) {
            $('#galleries_editGalleryButton').prop('disabled', false);
        } else {
            $('#galleries_editGalleryButton').prop('disabled', true);
        }
    });

    $('.galleryEditItem').on('keypress', function (e) {
        if (e.which == 13) {
            if (evaluateEdit()) {
                galleryEdit();
            }
        }
    });

    $('#galleries_editGalleryButton').on('click', function () {
        galleryEdit();
    });

    function galleryCreate() {
        $('#gallery_createForm').submit();
    }

    function galleryEdit() {
        $('#gallery_editForm_galleryId').val(currentGallery.attr('name'));
        $('#gallery_editForm').submit();
    }

    function evaluateEdit() {
        var isEdited = false;
        if ($('#galleries_editGalleryName').val() !== gallery_preEditTitle) isEdited = true;
        console.log('f ' + isEdited);
        if($('#galleries_editGalleryDescription').val() !== gallery_preEditDescription) isEdited = true;
        console.log('s ' + isEdited);
        return isEdited;
    }
});