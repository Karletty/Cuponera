<!DOCTYPE html>
<html lang="en">

<?php
include_once('Views/printHead.php');
include_once('Views/assets/navs/navBar.php');

?>

<head>
      <?php printHead('Cambio de contraseña'); ?>
</head>


<body>
      <?php printNavBar($user_type, $user_name, 'changePass'); ?>
      <div class="form-container">
            <div class="card">
                  <form action="<?= PATH ?>/Clients/changePassword" method="post">
                        <div class="card-body">
                              <h2>CAMBIO DE CONTRASEÑA</h2>
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
                                          <input type="password" name="pass" class="form-control" placeholder="Contraseña" value="<?= isset($pass) ? $pass : '' ?>">
                                    </div>
                                    <div class="mb-3">
                                          <input type="password" name="pass-repeat" class="form-control" placeholder="Repetir contraseña">
                                    </div>
                              </div>
                              <button name="change-pass" type="submit" class="btn">Cambiar contraseña</button>
                        </div>
                  </form>
            </div>
      </div>
</body>

</html>