<?php
include_once './Core/error404.php';
include_once './Core/error403.php';

abstract class Controller
{

      public function render($view, $viewbag = array())
      {
            $file = "Views/" . static::class . "/$view";
            $file = str_replace("Controller", "", $file);
            if (is_file($file)) {
                  extract($viewbag);
                  ob_start(); //Abriendo el buffer
                  require($file);
                  $content = ob_get_contents();
                  ob_end_clean(); //Limpiando y cerrando el buffer
                  echo $content;
            } else {
                  renderError404View();
            }
      }
}
