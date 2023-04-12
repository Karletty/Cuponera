<?php
function dateSort($saleA, $saleB)
{
      $dateA = explode('/', $saleA['sale_date']);
      $dateB = explode('/', $saleB['sale_date']);
      if ($dateA[2] < $dateB[2]) {
            return -1;
      }
      if ($dateA[2] > $dateB[2]) {
            return 1;
      }
      if ($dateA[1] < $dateB[1]) {
            return -1;
      }
      if ($dateA[1] > $dateB[1]) {
            return 1;
      }
      if ($dateA[0] < $dateB[0]) {
            return -1;
      }
      if ($dateA[0] > $dateB[0]) {
            return 1;
      }
      return -1;
}

function formatDate ($dateString) {
      [$year, $month, $day] = explode('-', $dateString);
      return ($day . '-' . $month . '-' . $year);
}

function formatOfferDate($offer)
{
      $offer['end_date'] = formatDate($offer['end_date']);
      $offer['start_date'] = formatDate($offer['start_date']);
}
