<div class="jumbotron jumbotron-fluid text-center">
    <div class="container">
        <h1 class="display-4">Hello <br> <?php echo getSessionNickname(); ?></h1>
        <p class="lead">this is your overview</p>
    </div>
</div>
<div class="row justify-content-center">
    <div class="col-md-5">
        <h4>Your credentials</h4>
        <form>
            <div class="form-group">
                <label for="overview_nickname">Nickname</label>
                <input type="text" class="form-control" id="overview_nickname"
                       value="<?php echo getSessionNickname(); ?>">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Password</label>
                <input type="password" class="form-control" id="exampleInputPassword1" placeholder="New password">
            </div>
            <button type="submit" class="btn btn-primary">Change</button>
        </form>
    </div>
    <div class="col-md-5">
        <h4>Your activities</h4>
        <ul class="list-group">
            <li class="list-group-item">
                <ul class="list-inline">
                    <li class="list-inline-item"><img style="background-color: grey; width: 7em;"
                                                      src="../img/library.svg"
                                                      class="img-thumbnail" alt="..."></li>
                    <li class="list-inline-item" >
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