<?php

use FontLib\Table\Type\head;

require_once 'Controller.php';
require_once 'Model/OffersModel.php';
require_once 'Core/validations.php';
require_once 'Core/date.php';


class ShoppingCartController extends Controller
{
      private $model;

      function __construct()
      {
            if (isset($_SESSION['user']) && $_SESSION['user']['userType'] == 'cliente') {
                  $this->model = new OffersModel();
            } else {
                  renderError403View();
                  die();
            }
      }

      public function index()
      {
            if (isset($_SESSION['shoppingCart'])) {
                  $viewbag = [
                        'user_type' => $_SESSION['user']['userType'],
                        'user_name' => $_SESSION['user']['userName']
                  ];
                  $shoppingCart = [];

                  foreach ($_SESSION['shoppingCart'] as $offerId => $cant) {
                        $offer = $this->model->get($offerId);
                        $offer['quantity'] = $cant;
                        array_push($shoppingCart, $offer);
                  }

                  $viewbag['shopping_cart'] = $shoppingCart;

                  $this->render('index.php', $viewbag);
            } else {
                  $_SESSION['error_message'] = 'No hay productos en el carrito';

                  header('location: ' . PATH . '/Offers');
                  die();
            }
      }

      public function add($id)
      {
            if (isset($_POST['add'])) {
                  $_SESSION['shoppingCart'][$id] = $_POST['quantity'];
            }

            header('location: ' . $_SERVER["HTTP_REFERER"]);
            die();
      }

      public function remove($id)
      {
            if (isset($_SESSION['shoppingCart'][$id])) {
                  unset($_SESSION['shoppingCart'][$id]);
            }

            header('location: ' . $_SERVER["HTTP_REFERER"]);
            die();
      }

      public function validatePay()
      {
            if (isset($_POST['pay'])) {
                  $today = getdate();
                  $errors = [];
                  $creditCard = [
                        'name' => $_POST['cc-name'],
                        'cardNumber' => $_POST['cc-number'],
                        'expMonth' => $_POST['cc-exp-month'],
                        'expYear' => $_POST['cc-exp-year'],
                        'cvv' => $_POST['cc-cvv']
                  ];
                  if (isEmpty($creditCard['name'])) {
                        $errors['name'] = 'Debe ingresar un nombre';
                  }
                  if (validateCreditCard($creditCard['cardNumber']) != '') {
                        $errors['cardNumber'] = validateCreditCard($creditCard['cardNumber']);
                  }
                  if (validateCVV($creditCard['cvv']) != '') {
                        $errors['cvv'] = validateCVV($creditCard['cvv']);
                  }
                  if (validateDate('20' . $creditCard['expYear'] . '-' . $creditCard['expMonth']) != '') {
                        $errors['date'] = validateDate('20' . $creditCard['expYear'] . '-' . $creditCard['expMonth']);
                  }

                  if (!count($errors)) {
                        header('location:' . PATH . '/Coupons/createCoupons');
                  } else {
                        $shoppingCart = [];
      
                        foreach ($_SESSION['shoppingCart'] as $offerId => $cant) {
                              $offer = $this->model->get($offerId);
                              $offer['quantity'] = $cant;
                              array_push($shoppingCart, $offer);
                        }
      
                        $viewbag = [
                              'creditCard' => $creditCard,
                              'errors' => $errors,
                              'user_type' => $_SESSION['user']['userType'],
                              'user_name' => $_SESSION['user']['userName'],
                              'shopping_cart' => $shoppingCart
                        ];
                        $this->render('index.php', $viewbag);
                  }
            } else {
                  header('location: ' . $_SERVER["HTTP_REFERER"]);
            }
      }
}
