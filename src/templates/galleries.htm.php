<nav class="navbar navbar-expand-lg navbar-light bg-light" style="background-color: ">
    <a class="navbar-brand" href="#">Galleries</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#galleryNavBar"
            aria-controls="galleryNavBar" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="galleryNavBar">
        <ul class="navbar-nav">
            <li class="nav-item active">
                <button type="button" id="galleries_createGallery" class="btn btn-success" data-toggle="modal"
                        data-target="#gallery_createGallerydialog">
                    <i class="fas fa-asterisk"></i> New
                </button>
                <button type="button" id="galleries_editGallery" class="btn btn-secondary" data-toggle="modal"
                        data-target="#gallery_editGallerydialog">
                    <i class="fas fa-edit"></i> Edit
                </button>
                <button type="button" id="galleries_deleteGallery" class="btn btn-danger" data-toggle="modal"
                        data-target="#gallery_deleteGallerydialog">
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

<div class="modal fade" id="gallery_createGallerydialog" tabindex="-1" role="dialog"
     aria-labelledby="galleries_createGallery" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Create gallery</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="gallery_createForm" method="post" action="<?php echo getValue("phpmodule") ?>">
                    <div class="form-group">
                        <label for="galleries_newGalleryName">Create briefly a new gallery for your images</label>
                        <input type="text" class="form-control galleryCreateItem" id="galleries_newGalleryName"
                               name="galleries_newGalleryName" aria-describedby="emailHelp"
                               placeholder="Enter name of the gallery">
                        <label for="galleries_newGalleryDescription">Add a description to the gallery (optional)</label>
                        <input type="text" class="form-control galleryCreateItem" id="galleries_newGalleryDescription"
                               name="galleries_newGalleryDescription" aria-describedby="emailHelp"
                               placeholder="Enter description of the gallery">
                        <input type="hidden" name="gallery_formAction" value="gallery_create">
                    </div>
                    <button type="button" id="galleries_newGalleryButton" class="btn btn-success">
                        <i class="fas fa-asterisk"></i> Create</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="gallery_deleteGallerydialog" tabindex="-1" role="dialog"
     aria-labelledby="galleries_deleteGallery" aria-hidden="true">
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
                <form method="post" id="gallery_deleteForm" action="<?php echo getValue("phpmodule") ?>">
                    <input type="hidden" name="gallery_formAction" value="gallery_delete">
                    <input type="hidden" name="gallery_galleryId" id="gallery_deleteForm_galleryId">
                    <button type="button" id="gallery_deleteForm_deleteButton" class="btn btn-danger">
                        <i class="fas fa-trash-alt"></i> Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="gallery_editGallerydialog" tabindex="-1" role="dialog"
     aria-labelledby="galleries_editGallery" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit gallery</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="gallery_editForm" method="post" action="<?php echo getValue("phpmodule") ?>">
                    <div class="form-group">
                        <label for="galleries_editGalleryName">Gallery name</label>
                        <input type="text" class="form-control galleryEditItem" id="galleries_editGalleryName"
                               name="galleries_editGalleryName" aria-describedby="emailHelp"
                               placeholder="Enter name of the gallery">
                        <label for="galleries_editGalleryDescription">Description</label>
                        <input type="text" class="form-control galleryEditItem" id="galleries_editGalleryDescription"
                               name="galleries_editGalleryDescription" aria-describedby="emailHelp"
                               placeholder="Enter description of the gallery">
                        <input type="hidden" name="gallery_galleryId" id="gallery_editForm_galleryId"/>
                        <input type="hidden" name="gallery_formAction" value="gallery_edit">
                    </div>
                    <button type="button" id="galleries_editGalleryButton" class="btn btn-secondary">
                        <i class="fas fa-edit"></i> Edit</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php echo appl_getGalleriesBySessionUser() ?>

<script src="../js/galleries.js"></script>
