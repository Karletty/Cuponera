<?php
function printNavBarLogin($controller, $activeItem = 'signup')
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

      /* NAVBAR CUANDO NO SE HA INICIADO SESIÓN */
      ?>
      <header>
            <nav class="d-flex justify-content-between align-items-center p-3">
                  <div>
                        <img class="logo" src="<?= PATH ?>/Views/assets/img/logo.png" alt="La cuponera">
                  </div>
                  <ul class="nav nav-pills justify-content-end">
                        <li class="nav-item">
                              <a class="nav-link <?= $activeItem == 'offers' ?  'active' : '' ?>" aria-current="page" href="<?= PATH ?>/Offers">Ofertas de hoy</a>
                        </li>
                        <li class="nav-item dropdown">
                              <a class="nav-link dropdown-toggle <?= $controller == 'clients' ?  'active' : '' ?>" data-bs-toggle="dropdown" role="button" aria-expanded="false">Soy un cliente</a>
                              <ul class="dropdown-menu">
                                    <li><a class="dropdown-item <?= $activeItem == 'c_login' ?  'active' : '' ?>" href="<?= PATH ?>/Clients/login">Login</a></li>
                                    <li>
                                          <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item <?= $activeItem == 'c_signup' ?  'active' : '' ?>" href="<?= PATH ?>/Clients/signup">SignUp</a></li>
                              </ul>
                        </li>
                        <li class="nav-item dropdown">
                              <a class="nav-link dropdown-toggle <?= $controller == 'employees' ?  'active' : '' ?>" data-bs-toggle="dropdown" role="button" aria-expanded="false">Soy un empleado</a>
                              <ul class="dropdown-menu">
                                    <li><a class="dropdown-item <?= $activeItem == 'e_login' ?  'active' : '' ?>" href="<?= PATH ?>/Employees/login">Login</a></li>
                                    <li>
                                          <hr class="dropdown-divider">
                                    </li>
                              </ul>
                        </li>
                  </ul>
            </nav>
      </header>
<?php
}
?>