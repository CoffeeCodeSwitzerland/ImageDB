<!DOCTYPE html>
<html lang="de">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, shrink-to-fit=no, initial-scale=1">
  <link href="../js/css/bootstrap.css" rel="stylesheet" />
  <link href="../js/css/bootstrap-grid.css" rel="stylesheet" />
  <link href="../js/css/bootstrap-reboot.css" rel="stylesheet" />
    <link href="../css/own.css" rel="stylesheet" />
  <script src="../js/jquery-3.1.1.min.js"></script>
  <script src="../js/js/bootstrap.js"></script>
  <script src="../js/jscript.js"></script>
  <title>Bilder-DB</title>
  <style>
	.form-condensed .control-group {
	  margin-top: 0;
	  margin-bottom: 5px;
	}
  </style>
</head>

<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="index.php?id=login">Image DB</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <?php echo getMenu(getValue("cfg_menu_list")); ?>
        </ul>
    </div>
</nav>
<!--  <div class="container" style="margin-top:80px">-->
	<?php echo getValue("inhalt"); ?>
<!--  </div>-->
  <div class="container" style="margin-top:20px">
	<div class="row">
	  <div class="col-md-offset-3 col-md-4 text-center small text-muted">
		&copy;&nbsp;Copyright gibb
	  </div>
	</div>
  </div>
</body>
</html>
