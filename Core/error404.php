<?php

function renderError404View()
{
      $errorView = "Views/Errors/error404.php";

      ob_start();
      require($errorView);
      $content = ob_get_contents();
      ob_end_clean();

      echo $content;
}
