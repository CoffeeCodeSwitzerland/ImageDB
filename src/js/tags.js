$('#tags_editTag').hide();
$('#tags_deleteTag').hide();

var currentItem = null;
var preEditTagName = "";


$('.tagItem').on('click', function () {
    if (currentItem != null) {
        currentItem.removeClass('table-active');
    }
    currentItem = $(this);
    currentItem.addClass('table-active');
    taskbar(true);
});

$('#tags_editTag').on('click', function () {
    preEditTagName = $('#tagName_' + currentItem.attr('tagid')).text();
    $('#tags_editTagName').val(preEditTagName);
    $('#tags_editTagButton').prop('disabled', true);
});

$('#tags_editTagName').on('keyup', function () {
    if (evaluateEdit()) {
        $('#tags_editTagButton').prop('disabled', false);
    } else {
        $('#tags_editTagButton').prop('disabled', true);
    }
});

$('#tags_editTagName').on('keypress', function (e) {
    if (e.which == 13) {
        e.preventDefault();
        if (evaluateEdit()) {
            $('#tag_editForm_tagId').val(currentItem.attr('tagid'));
            $('#tag_editForm').submit();
        }
    }
});

$('#tags_editTagButton').on('click', function () {
    $('#tag_editForm_tagId').val(currentItem.attr('tagid'));
    $('#tag_editForm').submit();
});

$('#tags_addTag').on('click', function () {
    $('#tags_newTagName').val("");
    $('#tags_addTagButton').prop('disabled', true);
});

$('#tags_newTagName').on('keyup', function () {
    var value = $.trim($(this).val());
    $(this).val(value);
    if (value.length >= 3) {
        $('#tags_addTagButton').prop('disabled', false);
    } else {
        $('#tags_addTagButton').prop('disabled', true);
    }
});

$('#tags_newTagName').on('keypress', function (e) {
    if (e.which == 13) {
        e.preventDefault();
        if (evaluateCreate()) {
            $('#tags_addForm').submit();
        }
    }
});

$('#tags_addTagButton').on('click', function () {
    $('#tags_addForm').submit();
});


$('#tag_deleteTagButton').on('click', function () {
    $('#tag_deleteForm_tagId').val(currentItem.attr('tagid'));
    $('#tags_deleteForm').submit();
});

function taskbar(status) {
    if (status === true) {
        $('#tags_editTag').fadeIn();
        $('#tags_deleteTag').fadeIn();
    } else {
        $('#tags_editTag').fadeOut();
        $('#tags_deleteTag').fadeOut();
    }
}

function evaluateCreate() {
    if ($.trim($('#tags_newTagName').val()).length >= 3) {
        return true;
    } else {
        return false;
    }
}

function evaluateEdit() {
    if ($.trim($('#tags_editTagName').val()).toLowerCase() === preEditTagName.toLowerCase()) {
        return false;
    }

    if ($.trim($('#tags_editTagName').val()).toLowerCase().length < 3) {
        return false;
    }

    return true;
}