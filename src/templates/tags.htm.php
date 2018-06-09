<nav class="navbar navbar-expand-lg navbar-light bg-light" style="background-color: ">
    <a class="navbar-brand" href="#">Tags</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#imagesNavBar"
            aria-controls="imagesNavBar" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="imagesNavBar">
        <ul class="navbar-nav">
            <li class="nav-item active">
                <button type="button" id="tags_addTag" class="btn btn-success" data-toggle="modal"
                        data-target="#tags_addTagDialog">
                    <i class="fas fa-plus-circle"></i> Add
                </button>
                <button type="button" id="tags_editTag" class="btn btn-secondary" data-toggle="modal"
                        data-target="#tags_editTagDialog">
                    <i class="fas fa-edit"></i> Edit
                </button>
                <button type="button" id="tags_deleteTag" class="btn btn-danger" data-toggle="modal"
                        data-target="#tags_deleteTagDialog">
                    <i class="fas fa-trash-alt"></i> Delete
                </button>
            </li>
        </ul>
    </div>
</nav>

<?php
$message = getValue('message');
if (!empty($message)) {
    echo $message;
}
?>

<div class="modal fade" id="tags_addTagDialog" tabindex="-1" role="dialog"
           aria-labelledby="tags_addTag" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Add tag</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="tags_addForm" method="post" action="<?php echo getValue("phpmodule") ?>">
                    <div class="form-group">
                        <label for="tags_newTagName">Add a new tag to sort your images</label>
                        <input type="text" class="form-control galleryCreateItem" id="tags_newTagName"
                               name="tags_newTagName" aria-describedby="emailHelp"
                               placeholder="Enter name of tag">
                    </div>
                    <input type="hidden" name="tag_formAction" value="tag_add">
                    <button type="button" id="tags_addTagButton" class="btn btn-success">
                        <i class="fas fa-plus-circle"></i> Add</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="tags_editTagDialog" tabindex="-1" role="dialog"
     aria-labelledby="tags_addTag" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Edit tag</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="tag_editForm" method="post" action="<?php echo getValue("phpmodule") ?>">
                    <div class="form-group">
                        <label for="tags_editTagName">Tag name</label>
                        <input type="text" class="form-control galleryCreateItem" id="tags_editTagName"
                               name="tags_editTagName" aria-describedby="emailHelp"
                               placeholder="Enter name of tag">
                    </div>
                    <input type="hidden" name="tag_formAction" value="tag_edit">
                    <input type="hidden" name="tag_tagId" id="tag_editForm_tagId">
                    <button type="button" id="tags_editTagButton" class="btn btn-success">
                        <i class="fas fa-edit"></i> Edit</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="tags_deleteTagDialog" tabindex="-1" role="dialog"
     aria-labelledby="galleries_deleteGallery" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Delete tag</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                After proceeding it's not possible to recover your data.
               <br> (Only the tag and not the associated images will be delete)
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times"></i> Close</button>
                <form method="post" id="tags_deleteForm" action="<?php echo getValue("phpmodule") ?>">
                    <input type="hidden" name="tag_formAction" value="tag_delete">
                    <input type="hidden" name="tag_tagId" id="tag_deleteForm_tagId">
                    <button type="button" id="tag_deleteTagButton" class="btn btn-danger">
                        <i class="fas fa-trash-alt"></i> Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php echo appl_getAllTagsAsTable() ?>

<script src="../js/tags.js"></script>