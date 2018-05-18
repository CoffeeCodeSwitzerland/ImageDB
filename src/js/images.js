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
        deleteButton.fadeIn();
        editButton.fadeIn();
        if (currentImage != null) {
            currentImage.removeClass('bg-secondary text-white');
            currentImage.addClass('bg-light');
        }
        currentImage = $(this);
        currentImage.removeClass('bg-light');
        currentImage.addClass('bg-secondary text-white');
    });

    $('.imageItem').on('dblclick', function () {
        $('#lightbox_' + $(this).attr('name')).click();
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

    $('#image_editImageName').on('keypress', function (e) {
        if (e.which == 13) {
            e.preventDefault();
            editImage();
        }
    });

    function editImage() {
        $('#images_imageEditId').val(currentImage.attr('name'))
        $('#image_modifyForm').submit();
    }

    $('#image_newImageFile').change(function () {
        if ($(this).get(0).files.length > 0) {
            if ($(this)[0].files[0].size >= 4194304) {
                image_fileSelected = false;
                $(this).val('');
                $('#images_addImageDialog').modal('hide');
                $('#image_fileToBigModal').modal();
            } else {
                console.log($(this)[0].files[0].name);
                if (checkImageExtension($(this)[0].files[0].name)) {
                    image_fileSelected = true;
                    $('#image_fileInformationSize').val($(this)[0].files[0].size / 1024 / 1024);
                    $('#image_fileInformationName').val($(this)[0].files[0].name);
                    $('#image_fileName').text('File selected');
                    $('#image_fileInformation').slideDown();
                    if ($('#image_newImageName').val().length <= 0) {
                        var arr = $(this)[0].files[0].name.split('.');
                        $('#image_newImageName').val(arr[0]);
                        checkImageName()
                        evaluate();
                    }
                } else {
                    $('#images_addImageDialog').modal('hide');
                    $('#image_exntesionNotSuppported').modal();
                }
            }
        } else {
            $('#image_fileInformation').hide();
            $('#image_fileName').text('No file selected')
            image_fileSelected = false;
        }
        evaluate();
    });

    function checkImageExtension(fileName) {
        console.log(fileName)
        var name = fileName.split('.');
        var extension = name[1];
        extension = extension.toLowerCase();
        console.log('extension ' + extension);
        if (extension == 'jpeg' ||
            extension == 'png' ||
            extension == 'jpg') {
            return true;
        }
        return false;
    }

    $('#images_addImage').on('click', function () {
        $('#image_fileName').text('No file selected');
        $('#images_newImageButton').prop('disabled', true);
        $('#image_newImageFile').val('');
        $('#image_fileInformation').hide();
        $('#image_newImageName').val('');
        image_nameCorrect = false;
        image_fileSelected = false;
    });

    $('#image_newImageName').on('keyup', function () {
        checkImageName();
        evaluate();
    });

    $('#image_newImageName').on('keypress', function (e) {
        if (e.which == 13) {
            e.preventDefault();
            if (evaluate()) {
                imageSubmit();
            }
        }
    });

    $('.imageTag').on('click', function (e) {
        if ($(this).hasClass('badge-primary')) {
            $(this).addClass('badge-secondary');
            $(this).removeClass('badge-primary');
        } else {
            $(this).removeClass('badge-secondary');
            $(this).addClass('badge-primary');
        }
    });

    $('#images_newImageButton').on('click', function () {
        imageSubmit();
    });

    $('.tagSortItem').on('click', function () {
        $('#image_sortTag').val($(this).attr('name'));
        $('#image_tagSort').submit();
    });

    function imageSubmit() {
        $('#image_tags').val(getTags());
        $('#image_addForm').submit();
    }

    function getTags() {
        var tags = "";
        var size = $('.imageTag.badge-secondary').length;
        var counter = 0;
        $('.imageTag.badge-secondary').each(function () {
            if ($(this).hasClass('badge-secondary')) {
                if (counter < size - 1) {
                    tags += $(this).attr('name') + ",";
                } else {
                    tags += $(this).attr('name');
                }
            }
            counter++;
        });
        return tags;
    }

    function checkImageName() {
        if ($.trim($('#image_newImageName').val()).length > 3) {
            image_nameCorrect = true;
        } else {
            image_nameCorrect = false;
        }
    }

    function evaluate() {
        if (image_fileSelected && image_nameCorrect) {
            $('#images_newImageButton').prop('disabled', false);
            return true;
        } else {
            $('#images_newImageButton').prop('disabled', true);
        }
        return false;
    }
});