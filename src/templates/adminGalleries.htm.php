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
        foreach(db_getAllUsers() as $user){
          $userId = $user['UserId'];
          if(!empty(db_getGalleriesByUser($userId))){
            echo "
            <div class='card' style='width: 18rem; margin-bottom: 20px;'>
              <div class='card-header' style='border-left: 1px solid black;border-right: 1px solid black;border-top: 1px solid black;'>".
                $user['Emailaddress']."
              </div>
              <ul class='list-group list-group-flush'>";
              foreach(db_getGalleriesByUser($userId) as $gallery){
                echo "<li class='list-group-item' style='border-left: 1px solid black;border-right: 1px solid black;border-top: 1px solid black;'>Title: ".$gallery['Title']."</li>
                <li class='list-group-item' style='color:gray;border-left: 1px solid black;border-right: 1px solid black;'>Description: ".$gallery['Description']."</li>
                <li class='list-group-item' style='border-left: 1px solid black;border-right: 1px solid black;border-bottom: 1px solid black;'><div class='btn btn-secondary' data-toggle='modal' data-target='#adminGalleries_editGallery'
                   id='adminGalleries_editGallery' style='margin-right: 10px;'>Edit
              </div><div class='btn btn-danger' data-toggle='modal' data-target='#adminGalleries_modalDeleteGallery'
                   id='adminGalleries_modalDeleteGallery'>Delete
              </div></li>";
              }
              echo "</ul>
            </div>";
          }
        }
        ?>
        <?php
        $message = getValue('message');
        if (!empty($message)) {
            echo "<div style='margin-top: 2em;'>" . $message . "</div>";
        }
        ?>
        <div class="modal fade" id="adminUsers_modalDeleteUser" tabindex="-1" role="dialog"
             aria-labelledby="adminUsers_deleteUser" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Delete user</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete this user?<br>
                        After proceeding it's not possible to recover your data.
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <form action="<?php echo getValue("phpmodule") ?>" method="post">
                            <input type="text" value="delete" id="adminUsers_deleteContent" name="adminUsers_deleteContent"
                                   hidden>
                            <button type="submit" class="btn btn-danger" name="adminUsers_delete" id="adminUsers_delete"
                                    value="Delete user">Delete user
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="adminUsers_modalEditUser" tabindex="-1" role="dialog"
             aria-labelledby="adminUsers_editUser" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Edit user</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                      <form id="adminUsers_formEditUser">
                          <div class="form-group">
                              <label for="adminUsers_nickname">Nickname</label>
                              <input name="adminUsers_nickname" type="text" class="form-control" id="adminUsers_nickname"
                                     value="<?php echo db_getAllUsers()[0]['Nickname']; ?>">
                          </div>
                          <div class="form-group">
                              <label for="adminUsers_newPassword">New Password</label>
                              <input name="adminUsers_newPassword" type="password" class="form-control contentCheck"
                                     id="adminUsers_newPassword"
                                     placeholder="New password">
                          </div>
                          <div class="form-group">
                              <label for="adminUsers_newPasswordRepeat">Confirm new Password</label>
                              <input name="adminUsers_newPasswordRepeat" type="password" class="form-control contentCheck"
                                     id="adminUsers_newPasswordRepeat" placeholder="Repeat new password">
                          </div>
                      </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <form action="<?php echo getValue("phpmodule") ?>" method="post">
                            <input type="text" value="delete" id="adminUsers_editContent" name="adminUsers_editContent"
                                   hidden>
                            <button type="submit" class="btn btn-success" name="adminUsers_edit" id="adminUsers_edit"
                                    value="Edit user">Save changes
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<script src="../js/overview.js"></script>
