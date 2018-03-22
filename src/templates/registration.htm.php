
<div class="jumbotron jumbotron-fluid text-center">
    <div class="container">
        <h1 class="display-4">Registration</h1>
        <p class="lead">Type in your credentials and let's go</p>
    </div>
</div>
<div class="row justify-content-md-center">
    <div class="col-md-6">
        <form name="registration" action="<?php echo getValue("phpmodule"); ?>"
              method="post">
            <div class="form-group">
                <label for="registration_email">Emailaddress</label>
                <input type="email" class="form-control" id="registration_email" name="registration_email"
                       aria-describedby="emailHelp" placeholder="Enter email">
            </div>
            <div class="form-group">
                <label for="registration_nickname">Nickname</label>
                <input type="text" class="form-control" id="registration_nickname" name="registration_nickname"
                       placeholder="Nickname">
                <small id="emailHelp" class="form-text text-muted">If you don't set your emailaddress will be taken for
                    the nickname
                </small>
            </div>
            <div class="form-group">
                <label for="registration_password">Password</label>
                <input type="password" class="form-control pwCheck" id="registration_password"
                       name="registration_password" placeholder="Password">
            </div>
            <div class="form-group">
                <label for="registration_repeatPassword">Repeat password</label>
                <input type="password" class="form-control pwCheck" id="registration_repeatPassword"
                       name="registration_repeatPassword" placeholder="Repeat password">
            </div>
            <button type="submit" class="btn btn-primary" id="registration_register">Register</button>
        </form>

    </div>
</div>
<div class="row justify-content-center" style="margin-top: 2em;">
    <div class="col-md-6">
        <div class="alert alert-primary" id="registration_passwordNotEqual" role="alert">
            The passwords are not equal
        </div>
        <?php
        if(strlen(getValue('message')) > 0){
            echo getValue('message');
        }
//        if (isset($_GET['status'])) {
////            echo $_GET['status'];
//            if ($_GET['status'] == 'exists') {
//                echo "<div class='alert alert-danger' role = 'alert'> The user already exists</div >";
//            } elseif ($_GET['status'] == 'created') {
//                echo "<div class='alert alert-success' role = 'alert'>The user has been registered</div >";
//            } elseif ($_GET['status'] == 'error') {
//                echo "<div class=\"alert alert-warning\" role=\"alert\">Server error occured</div>";
//            }
//        }
        ?>
    </div>
</div>
<script src="../js/registration.js"></script>
