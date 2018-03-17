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
                        <div class="row justify-content-center">
                            <form name="login" action="<?php echo getValue("phpmodule"); ?>" method="post">
                                <div class="form-group">
                                    <label for="login_emailaddress">Email address</label>
                                    <input type="email" class="form-control" name="login_emailaddress" id="login_emailaddress"
                                           aria-describedby="emailHelp"
                                           placeholder="Enter email">
                                </div>
                                <div class="form-group">
                                    <label for="login_password">Password</label>
                                    <input type="password" class="form-control" name="login_password" id="login_password"
                                           placeholder="Password">
                                </div>

                                <button type="submit" id="login_login" class="btn btn-primary">Login</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>