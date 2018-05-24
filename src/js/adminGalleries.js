$(document).ready(function () {

    var currentGallery = null;

    $('.adminGalleries-DeleteButton').on('click', function () {
        currentGallery = $(this);
    });

    $('#adminGalleries_deleteBtn').on('click', function () {
        $('#adminGalleries_deleteForm_galleryId').val(currentGallery.attr('name'));
        $('#adminGalleries_deleteForm').submit();
    });

    $('.adminGalleries-EditButton').on('click', function () {
        currentGallery = $(this);
        $('#adminGalleries_galleryName').val(currentGallery.attr('data-galleryName'));
        $('#adminGalleries_galleryDescription').val(currentGallery.attr('data-galleryDescription'));
    });

    $('#adminGalleries_edit').on('click', function () {
        $('#adminGalleries_editForm_galleryId').val(currentGallery.attr('name'));
        $('#adminGalleries_editForm_galleryName').val($('#adminGalleries_galleryName').val());
        $('#adminGalleries_editForm_galleryDescription').val($('#adminGalleries_galleryDescription').val());
        $('#adminGalleries_editForm').submit();
    });
});