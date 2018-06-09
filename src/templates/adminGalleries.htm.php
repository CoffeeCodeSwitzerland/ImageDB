<div class="jumbotron jumbotron-fluid text-center">
    <div class="container">
        <h1 class="display-4">Gallery administrator <br> <?php echo getSessionNickname(); ?></h1>
        <p class="lead">edit and delete galleries here</p>
    </div>
</div>
<div class="row justify-content-center">
    <div class="col-md-5">
        <h4>Galleries</h4>
        <?php
            $message = getValue('message');
            if (!empty($message)) {
                echo $message;
            }
            showGalleriesForAdmin();
        ?>
        <div class="modal fade" id="adminGalleries_modalDeleteGallery" tabindex="-1" role="dialog"
             aria-labelledby="adminGalleries_deleteGallery" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Delete gallery</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete this gallery?<br>
                        After proceeding it's not possible to recover your data.
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <form method="post" id="adminGalleries_deleteForm" action="<?php echo getValue("phpmodule") ?>">
                            <input type="text" value="delete" id="adminUsers_deleteContent" name="adminUsers_deleteContent"
                                   hidden>
                            <input type="hidden" name="adminGalleries_formAction" value="adminGalleries_delete">
                            <input type="hidden" name="adminGalleries_deleteForm_galleryId" id="adminGalleries_deleteForm_galleryId">
                            <button type="submit" class="btn btn-danger" name="adminGalleries_deleteBtn" id="adminGalleries_deleteBtn"
                                    value="Delete gallery">Delete gallery
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <div class="modal fade" id="adminGalleries_modalEditGallery" tabindex="-1" role="dialog"
             aria-labelledby="aadminGalleries_editGallery" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Edit gallery</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                      <form id="adminGalleries_editForm">
                          <div class="form-group">
                              <label for="adminGalleries_galleryName">Name</label>
                              <input name="adminGalleries_galleryName" type="text" class="form-control" id="adminGalleries_galleryName">
                          </div>
                          <div class="form-group">
                              <label for="adminGalleries_galleryDescription">Description</label>
                              <input name="adminGalleries_galleryDescription" type="text" class="form-control" id="adminGalleries_galleryDescription">
                          </div>
                      </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <form action="<?php echo getValue("phpmodule") ?>" method="post">
                            <input type="text" value="delete" id="adminGalleries_editContent" name="adminGalleries_editContent"
                                   hidden>
                            <input type="hidden" name="adminGalleries_formAction" value="adminGalleries_edit">
                            <input type="hidden" name="adminGalleries_editForm_galleryId" id="adminGalleries_editForm_galleryId">
                            <input type="hidden" name="adminGalleries_editForm_galleryName" id="adminGalleries_editForm_galleryName">
                            <input type="hidden" name="adminGalleries_editForm_galleryDescription" id="adminGalleries_editForm_galleryDescription">
                            <button type="submit" class="btn btn-success" name="adminGalleries_edit" id="adminGalleries_edit"
                                    value="Edit gallery">Save changes
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<script src="../js/adminGalleries.js"></script>
