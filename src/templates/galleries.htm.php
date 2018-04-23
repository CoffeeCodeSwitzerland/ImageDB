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
                    <span class="glyphicon glyphicon-alert"></span>New
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
                <form method="post" action="<?php echo getValue("phpmodule") ?>">
                    <div class="form-group">
                        <label for="galleries_newGalleryName">Create briefly a new gallery for your images</label>
                        <input type="text" class="form-control" id="galleries_newGalleryName"
                                                                               name="galleries_newGalleryName" aria-describedby="emailHelp"
                                                                               placeholder="Enter name of the gallery">
                        <label for="galleries_newGalleryDescription">Add a description to the gallery (optional)</label>
                        <input type="text" class="form-control" id="galleries_newGalleryDescription"
                               name="galleries_newGalleryDescription" aria-describedby="emailHelp"
                               placeholder="Enter description of the gallery">
                    </div>
                    <button type="submit" id="galleries_newGalleryButton" class="btn btn-success">Create</button>
                </form>
            </div>
        </div>
    </div>
</div>


<?php echo getGalleriesBySessionUser() ?>

<script src="../js/galleries.js"></script>