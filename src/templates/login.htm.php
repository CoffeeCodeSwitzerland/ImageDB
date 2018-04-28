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
                                        <span class="input-group-text" id="basic-addon1"><i class="fas fa-user"></i></span>
                                    </div>
                                    <input type="email" name="login_emailaddress" id="login_emailaddress" class="form-control contentCheck" placeholder="Username" aria-label="Email" aria-describedby="basic-addon1">
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon2"><i class="fas fa-key"></i></span>
                                    </div>
                                    <input type="password" id="login_password" name="login_password" class="form-control contentCheck" placeholder="Password" aria-label="Password" aria-describedby="basic-addon2">
                                </div>

                                <button type="submit" id="login_login" class="btn btn-primary">
                                    <i class="fas fa-sign-in-alt"></i> Login</button>
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
<script src="../js/login.js"></script>