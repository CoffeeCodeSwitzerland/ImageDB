$(document).ready(function () {

    var image_fileSelected = false;
    var image_nameCorrect = false;
    var image_preEditName = null;
    var currentImage = null;
    var deleteButton = $('#images_deleteImage');
    var editButton = $('#images_editImage');

    deleteButton.hide();
    editButton.hide();

    $('.imageItem').on('click', function () {
        deleteButton.show();
        editButton.show();
        if (currentImage != null) {
            currentImage.removeClass('bg-secondary text-white');
            currentImage.addClass('bg-light');
        }
        currentImage = $(this);
        console.log(currentImage.attr('name'));
        currentImage.removeClass('bg-light');
        currentImage.addClass('bg-secondary text-white');
    });

    $('.imageItem').on('dblclick', function () {
        //window.location.href = "user.php?id=images&gid=" + currentImage.attr('name');
    });

    $('#images_deleteImageButton').on('click', function () {
        $('#images_imageId').val(currentImage.attr('name'));
        $('#image_deleteForm').submit();
    });

    editButton.on('click', function () {
        if (currentImage != null) {
            var currentName = $('#title_' + currentImage.attr('name')).text();
            image_preEditName = currentName;
            $('#image_editImageName').val(currentName);
            $('#images_editImageButton').prop('disabled', true);
        }
    });

    $('#image_editImageName').on('keyup', function () {
        if ($(this).val() === image_preEditName) {
            $('#images_editImageButton').prop('disabled', true);
        } else {
            $('#images_editImageButton').prop('disabled', false);
        }
    });

    $('#images_editImageButton').on('click', function () {
        editImage();
    });

    $('#image_editImageName').on('keypress', function(e) {
        if(e.which == 13){
            e.preventDefault();
            editImage();
        }
    });

    function editImage() {
        $('#images_imageEditId').val(currentImage.attr('name'))
        $('#image_modifyForm').submit();
    }

    $('#images_newImageButton').prop('disabled', true);
    $('#image_fileName').text('No file selected');

    $('#image_newImageFile').change(function () {
        if ($(this).get(0).files.length > 0) {
            image_fileSelected = true;
            $('#image_fileName').text($(this)[0].files[0].name);
        } else {
            $('#image_fileName').text('No file selected')
            image_fileSelected = false;
        }
        evaluate();
    });

    $('#image_newGaleryName').on('keyup', function () {
        if ($.trim($(this).val()).length > 3) {
            image_nameCorrect = true;
        } else {
            image_nameCorrect = false;
        }
        evaluate();
    });

    function evaluate() {
        if (image_fileSelected && image_nameCorrect) {
            $('#images_newImageButton').prop('disabled', false);
        } else {
            $('#images_newImageButton').prop('disabled', true);
        }
    }
});