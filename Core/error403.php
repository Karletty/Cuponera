<?php

function renderError403View()
{
      $errorView = "Views/Errors/error403.php";

      ob_start();
      require($errorView);
      $content = ob_get_contents();
      ob_end_clean();

      echo $content;
}
