<?php
function isEmpty($var)
{
      return empty(trim($var));
}

function isText($var)
{
      return preg_match('/^[a-zA-Z ]+$/', $var);
}

function isEmail($var)
{
      return filter_var($var, FILTER_VALIDATE_EMAIL);
}

function isDUI($var)
{
      return preg_match('/^[0-9]{8}-[0-9]{1}$/', $var) || preg_match('/^[0-9]{9}$/', $var);
}

function isPhone($var)
{
      return preg_match('/^[0-9]{4}-[0-9]{4}$/', $var) || preg_match('/^[0-9]{8}$/', $var);
}

function isIdProduct($var)
{
      return preg_match('/^PROD[0-9]{5}$/', $var);
}

function validateCreditCard($cardNumber)
{
      $cardNumber = str_replace(' ', '', $cardNumber);
      $cardNumber = str_replace('-', '', $cardNumber);

      if (strlen($cardNumber) != 16) {
            return 'La tarjeta debe tener 16 dígitos';
      }
      if (!is_numeric($cardNumber)) {
            return 'Solo puede ingresar números';
      }

      $sum = 0;
      $array = str_split($cardNumber);

      for ($i = 0; $i < 16; $i++) {
            if ($i % 2) {
                  $sum += $array[$i];
            } else {
                  $val = $array[$i] * 2;
                  $sum += $val < 9 ? $val : str_split($val)[0] + str_split($val)[1];
            }
      }

      if ($sum % 10 || $sum == 0) {
            return 'El número de tarjeta no es válido';
      }

      return '';
}

function validateCVV($cvv)
{
      if (strlen($cvv) != 3 && strlen($cvv) != 4) {
            return 'Este campo debe tener 3 o 4 dígitos';
      }
      if (preg_match_all('/[0-9]/', $cvv) != strlen($cvv)) {
            return 'Este campo solo puede tener números';
      }

      return '';
}

function validateText($text)
{
      if (!$text) {
            return 'Este campo no puede estar vacío';
      }
      if (strlen($text) < 3) {
            return 'Este campo debe tener al menos 3 dígitos';
      }
      if (preg_match_all('/[a-zA-Z]/', $text) != strlen($text)) {
            return 'Este campo solo puede contener texto';
      }

      return '';
}

function validateDate($date)
{
      if ($date) {
            $today = getdate();
            $expDate = explode('-', $date);
            $year = $expDate[0];
            $month = $expDate[1];
            if ($today['year'] > $year || ($today['mon'] >= $month && $today['year'] == $year)) {
                  return  'La fecha no es válida';
            }
      }
      return '';
}
