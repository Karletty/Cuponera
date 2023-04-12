<!DOCTYPE html>
<html lang="en">

<?php
include_once('Views/printHead.php');
include_once('Views/assets/navs/navBar.php');
?>

<head>
      <?php printHead('Carrito'); ?>
      <link rel="stylesheet" href="<?= PATH ?>/Views/assets/css/bootstrap.min.css">
</head>

<body>
      <?php printNavBar($user_type, $user_name, 'coupons'); ?>
      <main>
            <h1>Mis cupones</h1>
            <table class="table table-hover" id="table">
                  <thead>
                        <tr>
                              <th>N° de cupón</th>
                              <th>Título</th>
                              <th>Estado</th>
                              <th>Descarga</th>
                        </tr>
                  </thead>
                  <tbody>
                        <?php
                        foreach ($coupons as $coupon) {
                        ?>
                              <tr>
                                    <td><?= $coupon['coupon_id'] ?></td>
                                    <td><?= $coupon['title'] ?></td>
                                    <td><span class="badge <?= $coupon['state_name'] === "Disponible" ? 'bg-success' : ($coupon['state_name'] === "Vencido" ? 'bg-danger' : 'bg-secondary') ?>"><?= $coupon['state_name'] ?></span></td>
                                    <td><a target="_blank" href="<?= PATH ?>/pdfs/<?= $coupon['coupon_id'] ?>.pdf" download class="btn"><i class="bi bi-download"></i></a></td>
                              </tr>
                        <?php
                        }
                        ?>
                  </tbody>
            </table>
      </main>
      <script>
            $(document).ready(function() {
                  $('#table').DataTable();
            });
      </script>
</body>

</html