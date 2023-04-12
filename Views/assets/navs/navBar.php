<?php
function printNavBar($user_type, $user_name, $activeItem = 'products')
{
      /* MENSAJES DE ERROR O DE CONFIRMACIÓN */
      if (isset($_SESSION['success_message'])) {
?>
            <script>
                  alertify.success('<?= $_SESSION['success_message'] ?>');
            </script>
      <?php
            unset($_SESSION['success_message']);
      }
      if (isset($_SESSION['error_message'])) {
      ?>
            <script>
                  alertify.error('<?= $_SESSION['error_message'] ?>');
            </script>
      <?php
            unset($_SESSION['error_message']);
      }

      /* NAVBAR CUANDO YA SE HA INICIADO SESIÓN */
      ?>

      <header>
            <nav class="d-flex justify-content-between align-items-center p-3">
                  <div>
                        <img class="logo" src="<?= PATH ?>/Views/assets/img/logo.png" alt="La cuponera">
                  </div>
                  <ul class="nav nav-pills justify-content-end">
                        <?php
                        if ($user_type == 'cliente') {
                        ?>
                              <li class="nav-item">
                                    <a class="nav-link <?= $activeItem == 'offers' ?  'active' : '' ?>" aria-current="page" href="<?= PATH ?>/Offers">Ofertas de hoy</a>
                              </li>
                              <li class="nav-item">
                                    <?php
                                    $count = 0;
                                    if (isset($_SESSION['shoppingCart']) && count($_SESSION['shoppingCart'])) {
                                          foreach ($_SESSION['shoppingCart'] as $id => $cant) {
                                                $count += $cant;
                                          }
                                    }
                                    ?>
                                    <a class="nav-link position-relative <?= $activeItem == 'shoppingCart' ?  'active' : '' ?>" aria-current="page" href="<?= PATH ?>/ShoppingCart">Carrito <span class="position-absolute top-0 start-100 translate-middle badge text-bg-secondary rounded-pill"><?= $count ?></span></a>
                              </li>
                              <li class="nav-item">
                                    <a class="nav-link <?= $activeItem == 'coupons' ?  'active' : '' ?>" aria-current="page" href="<?= PATH ?>/Coupons">Mis cupones</a>
                              </li>
                              <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle <?= $activeItem == 'changePassword' ?  'active' : '' ?>" data-bs-toggle="dropdown" role="button" aria-expanded="false"><?= $user_name ?></a>
                                    <ul class="dropdown-menu">
                                          <li><a class="dropdown-item" href="<?= PATH ?>/Clients/logout">Cerrar sesión</a></li>
                                          <li>
                                                <hr class="dropdown-divider">
                                          </li>
                                          <li><a class="dropdown-item <?= $activeItem == 'changePass' ?  'active' : '' ?>" href="<?= PATH ?>/Clients/changePassword">Cambiar contraseña</a></li>
                                    </ul>
                              </li>
                        <?php
                        } else if ($user_type == 'admin-empresa') {
                        ?>
                        <?php
                        } else if ($user_type == 'empleado') {
                        ?>
                        <?php
                        } else if ($user_type == 'admin') {
                        ?>
                        <?php
                        }
                        ?>
                  </ul>
            </nav>
      </header>
<?php
}
?>