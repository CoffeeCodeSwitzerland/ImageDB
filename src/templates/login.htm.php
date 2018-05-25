<div class="jumbotron vertical-center" style="height: 100%">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card">
                    <div class="card-body">
                        <div class="row justify-content-center">
                            <div class="card text-white" style="border:none">
                                <img class="card-img" src="../img/locked.svg" alt="Card image">
                                <div class="card-img-overlay">

                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center" style="margin-top: 1em">
                            <form name="login" action="<?php echo getValue("phpmodule"); ?>" method="post">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><i
                                                    class="fas fa-user"></i></span>
                                    </div>
                                    <input type="email" name="login_emailaddress" id="login_emailaddress"
                                           class="form-control contentCheck" placeholder="Username" aria-label="Email"
                                           aria-describedby="basic-addon1"
                                           value="<?php echo getValue('login_emailaddress'); ?>">
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon2"><i
                                                    class="fas fa-key"></i></span>
                                    </div>
                                    <input type="password" id="login_password" name="login_password"
                                           class="form-control contentCheck" placeholder="Password"
                                           aria-label="Password" aria-describedby="basic-addon2">
                                </div>

                                <button type="submit" id="login_login" class="btn btn-primary">
                                    <i class="fas fa-sign-in-alt"></i> Login
                                </button>
                                <button type="button" id="login_forgot" data-target="#resetPwDialog" data-toggle="modal"
                                        class="btn btn-secondary">
                                    <i class="fas fa-question"></i> Forgot password
                                </button>
                            </form>
                        </div>
                        <div class="row justify-content-center" style="margin-top: 1em;">
                            <?php
                            if (strlen(getValue('message')) > 0) {
                                echo getValue('message');
                            }
                            ?>
                            <div class="alert alert-primary" id="login_fieldsEmpty" role="alert">
                                Fields are empty
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="resetPwDialog" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <form method="post" action="<?php echo getValue("phpmodule"); ?>" id="login_resetForm">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Do you forgot the password?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Don't worry just type in your email and we will send you quickly a new one</p>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">@</span>
                        </div>
                        <input type="text" class="form-control" name="resetEmail" id="login_resetMail" placeholder="Username" aria-label="Username"
                               aria-describedby="basic-addon1">
                        <input type="hidden" name="resetPassword" value="set">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" id="login_resetPasswordButton" class="btn btn-primary">Reset password</button>
                </div>
            </div>
        </div>
    </form>
</div>
<script src="../js/login.js"></script>