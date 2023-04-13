<?php
require_once 'Controller.php';
require_once 'Model/OffersModel.php';
require_once 'Model/CategoriesModel.php';
require_once 'Core/validations.php';
require_once 'Core/date.php';


class OffersController extends Controller
{
      private $model;
      private $catModel;

      function __construct()
      {
            $this->model = new OffersModel();
            $this->catModel = new CategoriesModel();
      }

      public function index()
      {
            $view = [
                  'cliente' => 'clients.php',
                  'amdin-empresa' => 'companies.php',
                  'admin' => 'admin.php',
                  'default' => 'index.php'
            ];
            $categories = $this->catModel->get();

            if (isset($_SESSION['user'])) {
                  $viewbag['user_type'] = $_SESSION['user']['userType'];
                  $viewbag['user_name'] = $_SESSION['user']['userName'];
            }

            if (isset($_SESSION['user']) && $_SESSION['user']['userType'] == 'admin-empresa') {
                  $offers = $this->model->getCompanyOffers($_SESSION['companyId']);
            } else if ((isset($_SESSION['user']) && $_SESSION['user']['userType'] != 'empleado') || !isset($_SESSION['user'])) {
                  $offers = $this->model->get();

                  if (isset($_SESSION['user']) && $_SESSION['user']['userType'] == 'cliente' || !isset($_SESSION['user'])) {
                        $offers = array_filter($offers, function ($v, $k) {
                              return $v['available_qty'] > 0;
                        }, ARRAY_FILTER_USE_BOTH);

                        $offers = array_filter($offers, function ($v, $k) {
                              return $v['offer_state_description'] == 'Aprobada';
                        }, ARRAY_FILTER_USE_BOTH);

                        $offers = array_filter($offers, function ($v, $k) {
                              [$todayDay, $todayMonth, $todayYear] = explode('/', date('d/m/Y'));
                              [$day, $month, $year] = explode('-', formatDate($v['deadline_date']));
                              return !($year < $todayYear || (($year == $todayYear) && ($month < $todayMonth)) || (($year == $todayYear) && ($month == $todayMonth) && ($day < $todayDay)));
                        }, ARRAY_FILTER_USE_BOTH);

                        if (isset($_SESSION['shoppingCart'])) {
                              $viewbag['shopping_cart'] = $_SESSION['shoppingCart'];
                        }
                  }
            }

            $viewbag['offers'] = $offers;
            $viewbag['categories'] = $categories;

            if (isset($_GET['filter'])) {
                  $filters = [];
                  if ($_GET['category'] != 'all') {
                        $offers = array_filter($offers, function ($v, $k) {
                              return $v['category_name'] == $_GET['category'];
                        }, ARRAY_FILTER_USE_BOTH);
                        $filters['category'] = $_GET['category'];
                  }
                  if (!isEmpty($_GET['min-price']) && is_numeric($_GET['min-price'])) {
                        $offers = array_filter($offers, function ($v, $k) {
                              return $v['offer_price'] >= $_GET['min-price'];
                        }, ARRAY_FILTER_USE_BOTH);
                        $filters['min-price'] = $_GET['min-price'];
                  }
                  if (!isEmpty($_GET['max-price']) && is_numeric($_GET['max-price'])) {
                        $offers = array_filter($offers, function ($v, $k) {
                              return $v['offer_price'] <= $_GET['max-price'];
                        }, ARRAY_FILTER_USE_BOTH);
                        $filters['max-price'] = $_GET['max-price'];
                  }
                  $viewbag['offers'] = $offers;
                  $viewbag['filters'] = $filters;
            }

            if (isset($_SESSION['user']) && $_SESSION['user']['userType'] == 'empleado') {
                  renderError403View();
            } else {
                  array_map("formatOfferDate", $offers);

                  $this->render($view[isset($_SESSION['user']) ? $_SESSION['user']['userType'] : 'default'], $viewbag);
            }
      }

      public function details($id)
      {
            $offer = $this->model->get($id);
            $offer['end_date'] = formatDate($offer['end_date']);
            $offer['start_date'] = formatDate($offer['start_date']);
            $viewbag['offer'] = $offer;

            if (isset($_SESSION['user'])) {
                  $viewbag['user_type'] = $_SESSION['user']['userType'];
                  $viewbag['user_name'] = $_SESSION['user']['userName'];
            }

            if (isset($_SESSION['shoppingCart'])) {
                  $viewbag['shopping_cart'] = $_SESSION['shoppingCart'];
            }

            $this->render('detail.php', $viewbag);
      }
}
