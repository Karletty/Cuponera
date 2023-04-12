<?php

use FontLib\Table\Type\head;

require_once 'Controller.php';
require_once 'Model/CouponsModel.php';
require_once 'Model/OffersModel.php';
require_once 'Core/validations.php';
require_once 'Core/date.php';
require_once 'Core/convertImage.php';
require_once 'vendor/autoload.php';
require_once 'Phpmailer/Exception.php';
require_once 'Phpmailer/PHPMailer.php';
require_once 'Phpmailer/SMTP.php';
require_once 'phpqrcode/qrlib.php';

use Dompdf\Dompdf;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


class CouponsController extends Controller
{
      private $model;
      private $offersModel;

      function __construct()
      {
            if (isset($_SESSION['user'])) {
                  $this->model = new CouponsModel();
                  $this->offersModel = new OffersModel();
            } else {
                  renderError403View();
                  die();
            }
      }

      public function index()
      {
            if ($_SESSION['user']['userType'] == 'cliente') {
                  $coupons = $this->model->getClientCoupons($_SESSION['user']['clientDUI']);
                  [$todayDay, $todayMonth, $todayYear] = explode('/', date('d/m/Y'));
                  for ($i = 0; $i < count($coupons); $i++) {
                        $coupon = $coupons[$i];
                        $coupon['deadline_date'] = formatDate($coupon['deadline_date']);
                        [$day, $month, $year] = explode('-', $coupon['deadline_date']);
                        if ($coupon['state_name'] != "Canjeado") {
                              if ($year < $todayYear || (($year == $todayYear) && ($month < $todayMonth)) || (($year == $todayYear) && ($month == $todayMonth) && ($day < $todayDay))) {
                                    $coupon['state_name'] = "Vencido";
                              } else {
                                    $coupon['state_name'] = "Disponible";
                              }
                        }
                        $coupons[$i] = $coupon;
                  }
                  $viewbag = [
                        'user_type' => $_SESSION['user']['userType'],
                        'user_name' => $_SESSION['user']['userName'],
                        'coupons' => $coupons
                  ];
                  $this->render('clients.php', $viewbag);
            }
      }

      public function createCoupons()
      {
            if (isset($_SESSION['user']) && $_SESSION['user']['userType'] == 'cliente') {
                  $shoppingCart = [];
                  foreach ($_SESSION['shoppingCart'] as $offerId => $cant) {
                        $offer = $this->offersModel->get($offerId);
                        $offer['quantity'] = $cant;
                        array_push($shoppingCart, $offer);
                  }

                  foreach ($shoppingCart as $offer) {
                        for ($i = 0; $i < $offer['quantity']; $i++) {
                              $coupon = [
                                    'coupon_id' => $offer['company_id'] . '-' . substr(str_repeat(0, 7) . rand(0, 9999999), -7),
                                    'client_dui' => $_SESSION['user']['clientDUI'],
                                    'offer_id' => $offer['offer_id']
                              ];
                              $clientName = $_SESSION['user']['userName'];

                              $this->model->insert($coupon);
                              $dompdf = new Dompdf();
                              ob_start();
                              require 'Views/assets/mail/couponTemplate.php';
                              $html = ob_get_clean();
                              $dompdf->loadHtml($html);
                              $basePath = "./pdfs/";
                              $fileName =  $coupon['coupon_id'] . '.pdf';
                              $filePath = $basePath . $fileName;

                              $dompdf->render();
                              $outPut = $dompdf->output();

                              file_put_contents($filePath, $outPut);
                              unset($_SESSION['shoppingCart']);
                              $_SESSION['success_message'] = "El pago se ha realizado con éxito";
                              header('location: ' . PATH);
                        }
                        $this->offersModel->reduceOfferAvailable($offer['offer_id'], $offer['available_qty'] - $offer['quantity']);
                  }
            }
      }
}
