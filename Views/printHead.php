<?php
function printHead($pageName = 'Document', $bootstrap = true)
{
?>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

      <title><?= $pageName ?></title>
      <link rel="icon" type="image/png" href="<?= PATH ?>/Views/assets/img/favicon.png" />

      <!-- LINKS DE ALERTIFY -->
      <link href="<?= PATH ?>/Views/assets/css/alertify.core.css" rel="stylesheet" type="text/css" />
      <link href="<?= PATH ?>/Views/assets/css/alertify.default.css" rel="stylesheet" type="text/css" />
      <script src="<?= PATH ?>/Views/assets/js/alertify.js" type="text/javascript"></script>
      <!-- LINKS DE JQUERY -->
      <script src="<?= PATH ?>/Views/assets/js/jquery-1.12.0.min.js" type="text/javascript"></script>
      <script src="<?= PATH ?>/Views/assets/js/jquery.dataTables.min.js" type="text/javascript"></script>

      <!-- LINKS DE BOOTSTRAP -->
      <?php
      if ($bootstrap) {
      ?>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>

      <?php
      }
      ?>

      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css">
      <link rel="stylesheet" href="Views/assets/css/dataTables.bootstrap.min.css">
      <script src="<?= PATH ?>/Views/assets/js/dataTables.bootstrap.min.js" type="text/javascript"></script>

      <!-- LINK DE ESTILOS DE LA PÁGINA -->
      <link href="<?= PATH ?>/Views/assets/css/styles.css" rel="stylesheet">


<?php
}
?>