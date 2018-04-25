<div class="jumbotron jumbotron-fluid text-center">
    <div class="container">
        <h1 class="display-4">User administrator <br> <?php echo getSessionNickname(); ?></h1>
        <p class="lead">edit and delete users here</p>
    </div>
</div>
<div class="row justify-content-center">
    <div class="col-md-5">
        <h4>Users</h4>
        <?php
        foreach(getAllUsers() as $user){
          echo "
          <div class='card' style='width: 18rem; margin-bottom: 20px;'>
            <div class='card-header'>".
              $user['Emailaddress']."
            </div>
            <ul class='list-group list-group-flush'>
              <li class='list-group-item'>Nickname: ".
                $user['Nickname']."</li>
              <li class='list-group-item'><div class='btn btn-secondary' data-toggle='modal' data-target='#adminUsers_modalEditUser'
                   id='adminUsers_editUser' style='margin-right: 10px;'>Edit user
              </div><div class='btn btn-danger' data-toggle='modal' data-target='#adminUsers_modalDeleteUser'
                   id='adminUsers_deleteUser'>Delete user
              </div></li>
            </ul>
          </div>";
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
                                     value="<?php echo getAllUsers()[0]['Nickname']; ?>">
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
