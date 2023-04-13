<?php
require_once 'Controller.php';
require_once 'Model/ClientsModel.php';
require_once 'Core/validations.php';
require_once 'Core/date.php';
require_once './vendor/autoload.php';
require_once './Phpmailer/Exception.php';
require_once './Phpmailer/PHPMailer.php';
require_once './Phpmailer/SMTP.php';

use Dompdf\Dompdf;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


class ClientsController extends Controller
{
      private $model;
      private $catModel;

      function __construct()
      {
            $this->model = new ClientsModel();
      }

      public function login()
      {
            if (!isset($_SESSION['user'])) {
                  $this->render('login.php');
            } else {
                  header('location: ' . PATH . '/Offers');
                  die();
            }
      }

      public function authenticate()
      {
            if (isset($_POST['login'])) {
                  $client = $this->model->verifyCredentials($_POST['user-email'], $_POST['user-pass']);
                  $errors = [];
                  if (isset($client[0])) {
                        $client = $client[0];

                        if ($client['verified'] == 1) {
                              $_SESSION['user']['userType'] = $client['type_name'];
                              $_SESSION['user']['userName'] = $client['first_name'] . ' ' . $client['last_name'];
                              $_SESSION['user']['userEmail'] = $client['email'];
                              $_SESSION['user']['clientDUI'] = $client['dui'];

                              header('location: ' . PATH . '/Offers');
                              die();
                        } else {
                              array_push($errors, 'El usuario no ha sido autenticado');
                              $this->render('login.php', ['errors' => $errors]);
                        }
                  } else {
                        array_push($errors, 'Las credenciales son incorrectas');
                        $this->render('login.php', ['errors' => $errors]);
                  }
            }
      }

      public function forgotPassword()
      {
            $this->render('forgot_password.php');
      }

      public function resetPassword()
      {
            if (isset($_POST['reset-pass'])) {
                  $client = $this->model->get($_POST['user-email']);
                  $userMail = $_POST['user-email'];
                  $token = bin2hex(random_bytes(5));

                  try {
                        $mail = new PHPMailer(true);
                        $mail->IsSMTP();
                        $mail->CharSet = 'utf-8';
                        $mail->SMTPDebug = 0;
                        $mail->SMTPSecure = 'tls';
                        $mail->SMTPAuth = 'true';
                        $mail->Host = "smtp.gmail.com";
                        $mail->Port = 587;
                        $mail->Username = MAIL_CREDENTIALS['userName'];
                        $mail->Password = MAIL_CREDENTIALS['token'];
                        $mail->SetFrom('lacuponerakarle@gmail.com', 'La Cuponera');
                        $mail->AddAddress($userMail, 'Someone Else');
                        $mail->Subject = 'Cambio de contraseña';
                        $mail->AddEmbeddedImage('Views/assets/img/banner.png', 'imagen');
                        $mail->Body = '<img src="cid:imagen" height="auto" width="800px"><br><br><h3>Su contraseña temporal es: ' . $token . '</h3><br><h3>Asegurese de cambiar su contraseña</h3>';
                        $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!';
                        $mail->send();

                        $this->model->changePass($client['email'], $token);

                        $_SESSION['success_message'] = 'Su nueva contraseña ha sido enviada al correo';

                        header('location: ' . PATH . '/Clients/Login');
                        die();
                  } catch (Exception $e) {
                        var_dump($e);
                  }
            }
      }

      public function signup()
      {
            if (!isset($_SESSION['user'])) {
                  $this->render('signup.php');
            } else {
                  header('location: ' . PATH . '/Offers');
                  die();
            }
      }

      private function validate($client)
      {
            $errors = [];
            $users = $this->model->get();

            if (strlen($client['first_name']) == 0) {
                  array_push($errors, 'Debe ingresar su nombre');
            }

            if (strlen($client['last_name']) == 0) {
                  array_push($errors, 'Debe ingresar su apellido');
            }

            if (strlen($client['email']) == 0) {
                  array_push($errors, 'Debe ingresar su correo');
            } else if (!isEmail($client['email'])) {
                  array_push($errors, 'El correo no es válido');
            }

            if (strlen($client['email']) == 0) {
                  array_push($errors, 'Debe ingresar su DUI');
            } elseif (!isDUI($client['dui'])) {
                  array_push($errors, 'El DUI no es válido');
            }

            foreach ($users as $user) {
                  if (strlen($user['dui']) == strlen($client['dui']) && $user['dui'] == $client['dui']) {
                        array_push($errors, 'Este DUI ya está registrado');
                  }
                  if ($user['email'] == $client['email']) {
                        array_push($errors, 'Este email ya está registrado');
                  }
            }

            if (strlen($client['pass']) == 0) {
                  array_push($errors, 'Debe ingresar la contraseña');
            } else if (strlen($client['pass_confirmation']) == 0) {
                  array_push($errors, 'Debe confirmar la contraseña');
            } else if ($client['pass'] !== $client['pass_confirmation']) {
                  array_push($errors, 'Las contraseñas no coinciden');
            }

            if (!isPhone($client['phone'])) {
                  array_push($errors, 'El teléfono no es válido');
            }

            return $errors;
      }

      public function register()
      {
            if (isset($_POST['register'])) {
                  $errors = [];
                  $client = [
                        'first_name' => $_POST['user-first-name'],
                        'last_name' => $_POST['user-last-name'],
                        'pass' => $_POST['user-pass'],
                        'pass_confirmation' => $_POST['user-pass2'],
                        'email' => $_POST['user-email'],
                        'dui' => $_POST['client-dui'],
                        'phone' => $_POST['client-phone'],
                        'address' => $_POST['client-address'],
                        'token' => bin2hex(random_bytes(5))
                  ];
                  $client['dui'] = str_replace('-', '', $client['dui']);
                  $client['phone'] = str_replace('-', '', $client['phone']);

                  $errors = $this->validate($client);

                  if (!count($errors)) {

                        try {
                              $mail = new PHPMailer(true);
                              $mail->IsSMTP();
                              $mail->CharSet = 'utf-8';
                              $mail->SMTPDebug = 0;
                              $mail->SMTPSecure = 'tls';
                              $mail->SMTPAuth = 'true';
                              $mail->Host = "smtp.gmail.com";
                              $mail->Port = 587;
                              $mail->Username = MAIL_CREDENTIALS['userName'];
                              $mail->Password = MAIL_CREDENTIALS['token'];
                              $mail->SetFrom('lacuponerakarle@gmail.com', 'La Cuponera');
                              $mail->AddAddress($client['email'], 'Someone Else');
                              $mail->Subject = 'Verificación de usuario';
                              $mail->AddEmbeddedImage('Views/assets/img/banner.png', 'imagen');
                              $mail->Body = '<img src="cid:imagen" height="auto" width="800px"><br><br><h3>Su token para autenticar su usuario es: <a href="' . VERIFY_PATH . '?user-email=' . $client['email'] . '&token=' . $client['token'] . '">' . $client['token'] . '</a>.</h3><br><h3>Haga click en el token para autenticar su usuario</h3>';
                              $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!';
                              $mail->send();

                              if ($this->model->register($client) != null) {
                                    $_SESSION['success_message'] = 'El usuario se ha registrado, verifiquelo antes de iniciar sesión';
                                    header('location: ' . PATH . '/Clients/login');
                                    die();
                              } else {
                                    $_SESSION['success_message'] = 'El usuario no se ha podido registrar';
                                    $viewbag = [
                                          'errors' => $errors,
                                          'client' => $client
                                    ];
                                    $this->render('signup.php', $viewbag);
                              }
                        } catch (Exception $e) {
                              var_dump($e);
                        }
                  } else {
                        $viewbag = [
                              'errors' => $errors,
                              'client' => $client
                        ];

                        $this->render('signup.php', $viewbag);
                  }
            }
      }

      public function verify()
      {
            if (isset($_GET['user-email']) && isset($_GET['token'])) {
                  $user = $this->model->get($_GET['user-email']);

                  if (isset($user) && $user['token'] == $_GET['token']) {

                        try {
                              $mail = new PHPMailer(true);
                              $mail->IsSMTP();
                              $mail->CharSet = 'utf-8';
                              $mail->SMTPDebug = 0;
                              $mail->SMTPSecure = 'tls';
                              $mail->SMTPAuth = 'true';
                              $mail->Host = "smtp.gmail.com";
                              $mail->Port = 587;
                              $mail->Username = MAIL_CREDENTIALS['userName'];
                              $mail->Password = MAIL_CREDENTIALS['token'];
                              $mail->SetFrom('lacuponerakarle@gmail.com', 'La Cuponera');
                              $mail->AddAddress($user['email'], 'Someone Else');
                              $mail->Subject = 'Verificación de usuario';
                              $mail->AddEmbeddedImage('Views/assets/img/banner.png', 'imagen');
                              $mail->Body = '<img src="cid:imagen" height="auto" width="800px"><br><br><h3>Su usuario ha sido verificado</h3>';
                              $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!';
                              $mail->send();
                        } catch (Exception $e) {
                              var_dump($e);
                        }

                        $this->model->setVerified($user['dui']);

                        $_SESSION['success_message'] = 'El usuario ha sido verificado';
                        $_SESSION['user']['userType'] = $user['type_name'];
                        $_SESSION['user']['userEmail'] = $user['email'];
                        $_SESSION['user']['clientDUI'] = $user['dui'];
                        $_SESSION['user']['userName'] = $user['first_name'] . ' ' . $user['last_name'];

                        header('location: ' . PATH . '/Offers');
                        die();
                  } else {
                        $_SESSION['error_message'] = 'Hubo un error, el token no es válido';

                        header('location: ' . PATH . '/Offers');
                  }
            }
      }

      function logout()
      {
            session_unset();

            header('location: ' . PATH . '/Offers');
            die();
      }

      function changePassword()
      {
            if (isset($_SESSION['user'])) {
                  $clientEmail = $_SESSION['user']['userEmail'];
                  $viewbag['user_type'] = $_SESSION['user']['userType'];
                  $viewbag['user_name'] = $_SESSION['user']['userName'];
                  if (isset($_POST['change-pass'])) {
                        if ($_POST['pass'] == $_POST['pass-repeat']) {

                              try {
                                    $mail = new PHPMailer(true);
                                    $mail->IsSMTP();
                                    $mail->CharSet = 'utf-8';
                                    $mail->SMTPDebug = 0;
                                    $mail->SMTPSecure = 'tls';
                                    $mail->SMTPAuth = 'true';
                                    $mail->Host = "smtp.gmail.com";
                                    $mail->Port = 587;
                                    $mail->Username = MAIL_CREDENTIALS['userName'];
                                    $mail->Password = MAIL_CREDENTIALS['token'];
                                    $mail->SetFrom('lacuponerakarle@gmail.com', 'La Cuponera');
                                    $mail->AddAddress($clientEmail, 'Someone Else');
                                    $mail->Subject = 'Cambio de contraseña';
                                    $mail->AddEmbeddedImage('Views/assets/img/banner.png', 'imagen');
                                    $mail->Body = '<img src="cid:imagen" height="auto" width="800px"><br><br><h3>Su contraseña ha cambiado</h3>';
                                    $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!';
                                    $mail->send();

                                    $this->model->changePass($_SESSION['user']['userEmail'], $_POST['pass']);

                                    $_SESSION['success_message'] = 'Su contraseña se ha cambiado';

                                    header('location: ' . PATH . '/Offers');
                                    die();
                              } catch (Exception $e) {
                                    var_dump($e);
                              }
                        } else {
                              if (strlen($_POST['pass']) > 0) {
                                    $viewbag['errors'] = ['Las contraseñas no coinciden'];
                              } else {
                                    $viewbag['errors'] = ['Debe ingresar una contraseña'];
                              }

                              $viewbag['pass'] = $_POST['pass'];
                        }
                  }

                  $this->render('change_password.php', $viewbag);
            } else {
                  renderError403View();
            }
      }
}
