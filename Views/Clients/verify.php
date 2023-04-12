<!DOCTYPE html>
<html lang="en">

<?php
include_once('Views/printHead.php');
include_once('Views/assets/navs/navBarLogin.php');

?>

<head>
      <?php printHead('Verificar usuario'); ?>
</head>


<body>
      <header>
            <nav class="d-flex justify-content-between align-items-center p-3">
                  <div>
                        <img class="logo" src="<?= PATH ?>/Views/assets/img/logo.png" alt="La cuponera">
                  </div>
            </nav>
      </header>
      <div class="form-container">
            <div class="card">
                  <form action="<?= PATH ?>/Clients/verifyToken" method="post">
                        <div class="card-body">
                              <h2>VERIFICAR USUARIO</h2>
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
                                          <input type="email" name="user-email" class="form-control" placeholder="Correo" value="<?= isset($user) ? $user['email'] : '' ?>">
                                    </div>
                                    <div class="mb-3">
                                          <input type="text" name="user-token" class="form-control" placeholder="Token de validación">
                                    </div>
                              </div>
                              <button type="submit" name="verify" class="btn">Iniciar sesión</button>
                        </div>
                  </form>
            </div>
      </div>
</body>

</html>