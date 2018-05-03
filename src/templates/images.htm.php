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
                    <i class="fas fa-plus-circle"></i> Add
                </button>
                <button type="button" id="images_editImage" class="btn btn-secondary" data-toggle="modal"
                        data-target="#images_editImageDialog">
                   <i class="fas fa-edit"></i> Edit
                </button>
                <button type="button" id="images_deleteImage" class="btn btn-danger" data-toggle="modal"
                        data-target="#images_deleteImageDialog">
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
                <form id="image_addForm" method="post" action="<?php echo getValue("phpmodule") ?>"
                      enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="images_newImageName">Set the title for your image</label>
                        <input type="hidden" name="image_formAction" value="image_add">
                        <input type="text" class="form-control" id="image_newGaleryName"
                               name="images_newImageName" aria-describedby="emailHelp"
                               placeholder="Enter name the image">
                        <label for="image_newImageFile">Select the image file</label><br>
                        <div id="image_fileInformation" class="">
                            <div class="input-group input-group-sm mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroup-sizing-sm">Name</span>
                                </div>
                                <input type="text" id="image_fileInformationName" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                            </div>
                            <div class="input-group input-group-sm mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroup-sizing-sm">Size</span>
                                </div>
                                <input type="text" id="image_fileInformationSize" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                            </div>
                        </div>
                        <label class="btn btn-primary m-1" for="image_newImageFile">
                            <input accept=".png, .jpg" id="image_newImageFile" name="image_newImageFile" type="file" style="display:none;">
                            <i class="fas fa-file-image"></i> File
                        </label>
                        <label class="label" id="image_fileName">

                        </label>
                    </div>
                    <button type="submit" id="images_newImageButton" class="btn btn-success">
                        <i class="fas fa-plus-circle"></i> Add</button>
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
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times"></i> Close</button>
                <form method="post" id="image_deleteForm" action="<?php echo getValue("phpmodule") ?>">
                    <input type="hidden" name="image_formAction" value="image_delete">
                    <input type="hidden" name="images_imageId" id="images_imageId">
                    <button type="button" id="images_deleteImageButton" class="btn btn-danger">
                        <i class="fas fa-trash-alt"></i> Delete</button>
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
                    <button type="button" id="images_editImageButton" class="btn btn-secondary">
                        <i class="fas fa-edit"></i> Edit</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="image_fileToBigModal" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">File to big</h5>
            </div>
            <div class="modal-body">
                <div class="alert alert-warning" role="alert">
                    You have a filesize limitation of 4MiB
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Ok</button>
            </div>
        </div>
    </div>
</div>

<div id="image_exntesionNotSuppported" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">File type not supported</h5>
            </div>
            <div class="modal-body">
                <div class="alert alert-warning" role="alert">
                   Only: *.jpg, *.png, *.jpeg
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Ok</button>
            </div>
        </div>
    </div>
</div>


<?php echo appl_getImagesByGallery() ?>

<script src="../js/images.js"></script>
