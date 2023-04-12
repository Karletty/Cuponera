<!DOCTYPE html>
<html lang="en">

<?php
include_once('Views/printHead.php');
include_once('Views/assets/navs/navBarLogin.php');

?>

<head>
      <?php printHead('Olvidé mi contraseña'); ?>
</head>


<body>
      <?php printNavBarLogin('clients', 'c_login'); ?>
      <div class="form-container">
            <div class="card">
                  <form action="<?= PATH ?>/Clients/resetPassword" method="post">
                        <div class="card-body">
                              <h2>OLVIDÉ MI CONTRASEÑA</h2>
                              <?php
                              if (isset($errors)) {
                              ?>
                                    <div class="alert alert-danger w-100" role="alert">
                                          <?php
                                          foreach ($errors as $error) {
                                          ?>
                                                <p class="m-0"><?= $error ?></p>
                                          <?php
                                          }
                                          ?>
                                    </div>
                              <?php
                              }
                              ?>
                              <div class="w-100">
                                    <div class="mb-3">
                                          <input type="email" name="user-email" class="form-control" placeholder="Correo">
                                    </div>
                              </div>
                              <button name="reset-pass" type="submit" class="btn">Resetear la contraseña</button>
                        </div>
                  </form>
            </div>
      </div>
</body>

</html>