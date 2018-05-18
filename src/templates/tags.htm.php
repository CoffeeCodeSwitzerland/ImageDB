<nav class="navbar navbar-expand-lg navbar-light bg-light" style="background-color: ">
    <a class="navbar-brand" href="#">Tags</a>
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
                <button type="button" id="images_deleteImage" class="btn btn-danger" data-toggle="modal"
                        data-target="#images_deleteImageDialog">
                    <i class="fas fa-trash-alt"></i> Delete
                </button>
<!--                <button type="button" id="image_helpImage" class="btn btn-info" data-toggle="modal"-->
<!--                        data-target="#images_helpImageDialog">-->
<!--                    <i class="fas fa-question-circle"></i> Help-->
<!--                </button>-->
<!--                <div class="btn-group">-->
<!--                    <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown"-->
<!--                            aria-haspopup="true" aria-expanded="false">-->
<!--                        <i class="fa fa-tag"></i>-->
<!---->
<!--                        --><?php
//                        if (getValue('tagChoosen') != 'yes') {
//                            echo "No tag selected";
//                        }else{
//                            echo "Selcted";
//                        }
//                        ?>
<!---->
<!--                    </button>-->
<!--                    <div class="dropdown-menu dropdown-menu-right">-->
<!--                        <form id="image_tagSort" method="post" action="--><?php //echo getValue("phpmodule") ?><!--">-->
<!--                            --><?php //echo appl_getAllTagsAsButton(); ?>
<!--                            <input type="hidden" id="image_sortTag" name="image_sortTag">-->
<!--                            <input type="hidden" name="image_formAction" value="image_sort">-->
<!--                        </form>-->
<!--                    </div>-->
<!--                </div>-->
                <?php
                if (getValue('tagChoosen') == 'yes') {
                    echo "<button type='button' id='image_removeTag' class='btn btn-danger' data-toggle='modal' data-target='#images_helpImageDialog'>
                            <i class='fa fa-times'></i> Remove selection
                          </button>";
                    }
                ?>
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
     aria-labelledby="images_addImage" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Create a new tag</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="tags_">

                </form>
            </div>
        </div>
    </div>
</div>
<!---->
<!--<div class="modal fade" id="images_deleteImageDialog" tabindex="-1" role="dialog"-->
<!--     aria-labelledby="images_deleteImageDialog" aria-hidden="true">-->
<!--    <div class="modal-dialog modal-dialog-centered" role="document">-->
<!--        <div class="modal-content">-->
<!--            <div class="modal-header">-->
<!--                <h5 class="modal-title" id="exampleModalLongTitle">Delete gallery</h5>-->
<!--                <button type="button" class="close" data-dismiss="modal" aria-label="Close">-->
<!--                    <span aria-hidden="true">&times;</span>-->
<!--                </button>-->
<!--            </div>-->
<!--            <div class="modal-body">-->
<!--                After proceeding it's not possible to recover your data.-->
<!--            </div>-->
<!--            <div class="modal-footer">-->
<!--                <button type="button" class="btn btn-secondary" data-dismiss="modal">-->
<!--                    <i class="fas fa-times"></i> Close-->
<!--                </button>-->
<!--                <form method="post" id="image_deleteForm" action="--><?php //echo getValue("phpmodule") ?><!--">-->
<!--                    <input type="hidden" name="image_formAction" value="image_delete">-->
<!--                    <input type="hidden" name="images_imageId" id="images_imageId">-->
<!--                    <button type="button" id="images_deleteImageButton" class="btn btn-danger">-->
<!--                        <i class="fas fa-trash-alt"></i> Delete-->
<!--                    </button>-->
<!--                </form>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->
<!---->
<!--<div class="modal fade" id="images_editImageDialog" tabindex="-1" role="dialog"-->
<!--     aria-labelledby="images_editImage" aria-hidden="true">-->
<!--    <div class="modal-dialog modal-dialog-centered" role="document">-->
<!--        <div class="modal-content">-->
<!--            <div class="modal-header">-->
<!--                <h5 class="modal-title">Edit image</h5>-->
<!--                <button type="button" class="close" data-dismiss="modal" aria-label="Close">-->
<!--                    <span aria-hidden="true">&times;</span>-->
<!--                </button>-->
<!--            </div>-->
<!--            <div class="modal-body">-->
<!--                <form id="image_modifyForm" method="post" action="--><?php //echo getValue("phpmodule") ?><!--">-->
<!--                    <div class="form-group">-->
<!--                        <label for="image_editImageName">Image name</label>-->
<!--                        <input type="text" class="form-control" id="image_editImageName"-->
<!--                               name="image_editImageName" aria-describedby="emailHelp"-->
<!--                               placeholder="Enter name of the image">-->
<!--                        <input type="hidden" name="images_imageId" id="images_imageEditId">-->
<!--                        <input type="hidden" name="image_formAction" value="image_edit">-->
<!--                    </div>-->
<!--                    <button type="button" id="images_editImageButton" class="btn btn-secondary">-->
<!--                        <i class="fas fa-edit"></i> Edit-->
<!--                    </button>-->
<!--                </form>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->
<!---->
<!--<div id="image_fileToBigModal" class="modal" tabindex="-1" role="dialog">-->
<!--    <div class="modal-dialog" role="document">-->
<!--        <div class="modal-content">-->
<!--            <div class="modal-header">-->
<!--                <h5 class="modal-title">File to big</h5>-->
<!--            </div>-->
<!--            <div class="modal-body">-->
<!--                <div class="alert alert-warning" role="alert">-->
<!--                    You have a filesize limitation of 4MiB-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="modal-footer">-->
<!--                <button type="button" class="btn btn-secondary" data-dismiss="modal">Ok</button>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->
<!---->
<!--<div id="image_exntesionNotSuppported" class="modal" tabindex="-1" role="dialog">-->
<!--    <div class="modal-dialog" role="document">-->
<!--        <div class="modal-content">-->
<!--            <div class="modal-header">-->
<!--                <h5 class="modal-title">File type not supported</h5>-->
<!--            </div>-->
<!--            <div class="modal-body">-->
<!--                <div class="alert alert-warning" role="alert">-->
<!--                    Only: *.jpg, *.png, *.jpeg-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="modal-footer">-->
<!--                <button type="button" class="btn btn-secondary" data-dismiss="modal">Ok</button>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->
<!---->
<!--<div id="images_helpImageDialog" class="modal" tabindex="-1" role="dialog">-->
<!--    <div class="modal-dialog" role="document">-->
<!--        <div class="modal-content">-->
<!--            <div class="modal-header">-->
<!--                <h5 class="modal-title">Help</h5>-->
<!--            </div>-->
<!--            <div class="modal-body">-->
<!---->
<!---->
<!--                <p class="h2">Actions</p>-->
<!--                <p>-->
<!--                    <button type="button" class="btn btn-success">-->
<!--                        <i class="fas fa-plus-circle"></i> Add-->
<!--                    </button>-->
<!--                    <br>Upload a new .jpeg, .jpg or.png file with a maximum file size if 4 bib-->
<!---->
<!--                </p>-->
<!--                <p>-->
<!--                    <button type="button" class="btn btn-secondary">-->
<!--                        <i class="fas fa-edit"></i> Edit-->
<!--                    </button>-->
<!--                    <br>-->
<!--                    Change the name of image-->
<!---->
<!--                </p>-->
<!--                <p>-->
<!--                    <button type="button" class="btn btn-danger">-->
<!--                        <i class="fas fa-trash-alt"></i> Delete-->
<!--                    </button>-->
<!--                    <br>-->
<!--                    Remove an image from the gallery-->
<!--                </p>-->
<!--            </div>-->
<!--            <div class="modal-footer">-->
<!--                <button type="button" class="btn btn-secondary" data-dismiss="modal">Ok</button>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->
<!---->
<!---->
<?php //echo appl_getImagesByGallery() ?>
<!---->
<!--<script src="../js/images.js"></script>-->