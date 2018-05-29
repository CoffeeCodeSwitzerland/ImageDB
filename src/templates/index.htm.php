<!DOCTYPE html>
<html lang="de">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, shrink-to-fit=no, initial-scale=1">
  <link href="../js/css/bootstrap.css" rel="stylesheet" />
  <link href="../js/css/bootstrap-grid.css" rel="stylesheet" />
  <link href="../js/css/bootstrap-reboot.css" rel="stylesheet" />
    <link href="../css/own.css" rel="stylesheet" />
    <link href="../fontawesome/css/fontawesome-all.css" rel="stylesheet"/>
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
<nav class="navbar navbar-expand-lg navbar-light" style="background-color: #c0c0c0;">
    <a class="navbar-brand" href="index.php?id=login">Image DB</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <?php

            foreach (glob("classes/*.php") as $filename)
            {
                include $filename;
            }

            echo getMenu(getValue("cfg_menu_list"));

            ?>
        </ul>
    </div>
</nav>
	<?php echo getValue("inhalt"); ?>
</body>
</html>
