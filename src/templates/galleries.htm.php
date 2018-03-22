<nav class="navbar navbar-expand-lg navbar-light bg-light" style="background-color: ">
    <a class="navbar-brand" href="#">Galleries</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#galleryNavBar"
            aria-controls="galleryNavBar" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="galleryNavBar">
        <ul class="navbar-nav">
            <li class="nav-item active">
                <button type="button" class="btn btn-success">
                    <span class="glyphicon glyphicon-alert"></span>New
                </button>
            </li>
        </ul>
    </div>
</nav>

<?php echo getGalleriesBySessionUser() ?>