<!DOCTYPE html>
<html lang="en">

<?php
include_once('Views/printHead.php');
include_once('Views/assets/navs/navBarLogin.php');

?>

<head>
      <?php printHead('Signup'); ?>
</head>


<body>
      <?php printNavBarLogin('clients', 'c_signup'); ?>
      <div class="form-container">
            <div class="card">
                  <form action="<?= PATH ?>/Clients/register" method="post">
                        <div class="card-body">
                              <h2>SIGN UP</h2>
                              <?php
                              if (isset($errors)) {
                              ?>
                                    <div class="alert alert-danger" role="alert">
                                          <ul>
                                                <?php
                                                foreach ($errors as $error) {
                                                ?>
                                                      <li><?= $error ?></li>
                                                <?php
                                                }
                                                ?>
                                          </ul>
                                    </div>
                              <?php
                              }
                              ?>
                              <div class="w-100">
                                    <div class="row">
                                          <div class="mb-3 col">
                                                <input type="text" name="user-first-name" class="form-control" placeholder="Nombres" value="<?= isset($client) ? $client['first_name'] : '' ?>">
                                          </div>
                                          <div class="mb-3 col">
                                                <input type="text" name="user-last-name" class="form-control" placeholder="Apellidos" value="<?= isset($client) ? $client['last_name'] : '' ?>">
                                          </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                          <div class="mb-3 col">
                                                <input type="text" name="client-dui" class="form-control" placeholder="DUI" value="<?= isset($client) ? $client['dui'] : '' ?>">
                                          </div>
                                          <div class="mb-3 col">
                                                <input type="text" name="client-phone" class="form-control" placeholder="Teléfono" value="<?= isset($client) ? $client['phone'] : '' ?>">
                                          </div>
                                    </div>
                                    <div class="mb-3">
                                          <input type="email" name="user-email" class="form-control" placeholder="Correo" value="<?= isset($client) ? $client['email'] : '' ?>">
                                    </div>
                                    <div class="mb-3">
                                          <textarea type="text" name="client-address" class="form-control" placeholder="Dirección"><?= isset($client) ? $client['address'] : '' ?></textarea>
                                    </div>
                                    <hr>
                                    <div class="row">
                                          <div class="mb-3 col">
                                                <input type="password" name="user-pass" class="form-control" placeholder="Contraseña" value="<?= isset($client) ? $client['pass'] : '' ?>">
                                          </div>
                                          <div class="mb-3 col">
                                                <input type="password" name="user-pass2" class="form-control" placeholder="Confirmar contraseña">
                                          </div>
                                    </div>
                              </div>
                              <button name="register" type="submit" class="btn">Registrarse</button>
                        </div>
                  </form>
            </div>
      </div>
</body>

</html>