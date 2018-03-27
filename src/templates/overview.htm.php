<div class="jumbotron jumbotron-fluid text-center">
    <div class="container">
        <h1 class="display-4">Hello <br> <?php echo getSessionNickname(); ?></h1>
        <p class="lead">this is your overview</p>
    </div>
</div>
<div class="row justify-content-center">
    <div class="col-md-5">
        <h4>Your credentials</h4>
        <form id="overview_changeForm" action="<?php echo getValue("phpmodule") ?>" method="post">
            <div class="form-group">
                <label for="overview_nickname">Nickname</label>
                <input name="overview_nickname" type="text" class="form-control" id="overview_nickname"
                       value="<?php echo getSessionNickname(); ?>">
            </div>
            <div class="form-group">
                <label for="overview_currentPassword">Current password</label>
                <input name="overview_currentPassword" type="password" class="form-control"
                       id="overview_currentPassword" placeholder="Current">
            </div>
            <div class="form-group">
                <label for="overview_newPassword">Password</label>
                <input name="overview_newPassword" type="password" class="form-control contentCheck" id="overview_newPassword"
                       placeholder="New">
            </div>
            <div class="form-group">
                <label for="overview_newPasswordRepeat">Password</label>
                <input name="overview_newPasswordRepeat" type="password" class="form-control contentCheck"
                       id="overview_newPasswordRepeat" placeholder="New repeat">
            </div>
            <button type="submit" class="btn btn-primary" id="overview_change">Change</button>
            <div class="btn btn-danger" data-toggle="modal" data-target="#overview_modelDeleteAccount"
                 id="overview_deleteAccount">Delete account
            </div>
        </form>
        <div class="modal fade" id="overview_modelDeleteAccount" tabindex="-1" role="dialog"
             aria-labelledby="overview_deleteAccount" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Delete account</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        After proceeding it's not possible to recover your data.
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <form action="<?php echo getValue("phpmodule") ?>" method="post">
                            <input type="text" value="delete" id="overview_deleteContent" name="overview_deleteContent" hidden>
                            <button type="submit" class="btn btn-danger" name="overview_delete" id="overview_delete" value="Delete account">Delete account</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-5">
        <h4>Your activities</h4>
        <ul class="list-group">
            <li class="list-group-item">
                <ul class="list-inline">
                    <li class="list-inline-item"><img style="background-color: grey; width: 7em;"
                                                      src="../img/library.svg"
                                                      class="img-thumbnail" alt="..."></li>
                    <li class="list-inline-item">
                        <?php echo getImageCountByEmailaddress(getSessionEmailaddress()) ?>
                    </li>
                </ul>
            </li>
            <li class="list-group-item">
                <ul class="list-inline">
                    <li class="list-inline-item"><img style="background-color: grey; width: 7em;"
                                                      src="../img/library.svg"
                                                      class="img-thumbnail" alt="..."></li>
                    <li class="list-inline-item">
                        <?php echo getGalleryCountByEmailaddress(getSessionEmailaddress()) ?>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</div>
<script src="../js/overview.js"></script>