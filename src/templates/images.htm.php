<nav class="navbar navbar-expand-lg navbar-light bg-light" style="background-color: ">
    <a class="navbar-brand" href="#">Images</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#imagesNavBar"
            aria-controls="imagesNavBar" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="imagesNavBar">
        <ul class="navbar-nav">
            <li class="nav-item active">
                <button type="button" id="images_addImage" class="btn btn-success" data-toggle="modal"
                        data-target="#images_addImageDialog">
                    <span class="glyphicon glyphicon-alert"></span>New
                </button>
                <button type="button" id="images_editImage" class="btn btn-secondary" data-toggle="modal"
                        data-target="#images_editImageDialog">
                    <span class="glyphicon glyphicon-alert"></span>Edit
                </button>
                <button type="button" id="images_deleteImage" class="btn btn-danger" data-toggle="modal"
                        data-target="#images_deleteImageDialog">
                    <span class="glyphicon glyphicon-alert"></span>Delete
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

<div class="modal fade" id="images_addImageDialog" tabindex="-1" role="dialog"
     aria-labelledby="images_addImage" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Upload a new image</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="image_addForm" method="post" action="<?php echo getValue("phpmodule") ?>" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="images_newImageName">Set the title for your image</label>
                        <input type="hidden" name="image_formAction" value="image_add">
                        <input type="text" class="form-control" id="image_newGaleryName"
                               name="images_newImageName" aria-describedby="emailHelp"
                               placeholder="Enter name the image">
                        <label for="image_newImageFile">Select the image file</label><br>
                        <label class="btn btn-primary m-1" for="image_newImageFile">
                            <input id="image_newImageFile"  name="image_newImageFile" type="file" style="display:none;">
                            File
                        </label>
                        <label  class="label" id="image_fileName">

                        </label>
                    </div>
                    <button type="submit" id="images_newImageButton" class="btn btn-success">Add</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="images_deleteImageDialog" tabindex="-1" role="dialog"
     aria-labelledby="images_deleteImageDialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Delete gallery</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                    After proceeding it's not possible to recover your data.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <form method="post" id="image_deleteForm" action="<?php echo getValue("phpmodule") ?>">
                    <input type="hidden" name="image_formAction" value="image_delete">
                    <input type="hidden" name="images_imageId" id="images_imageId">
                    <button type="button" id="images_deleteImageButton" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="images_editImageDialog" tabindex="-1" role="dialog"
     aria-labelledby="images_editImage" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit image</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="image_modifyForm" method="post" action="<?php echo getValue("phpmodule") ?>">
                    <div class="form-group">
                        <label for="image_editImageName">Image name</label>
                        <input type="text" class="form-control" id="image_editImageName"
                               name="image_editImageName" aria-describedby="emailHelp"
                               placeholder="Enter name of the gallery">
                        <input type="hidden" name="images_imageId" id="images_imageEditId">
                        <input type="hidden" name="image_formAction" value="image_edit">
                    </div>
                    <button type="button" id="images_editImageButton" class="btn btn-success">Modify</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php echo appl_getImagesByGallery() ?>

<script src="../js/images.js"></script>
