<?php

require_once 'Model.php';

class CouponsModel extends Model
{
      public function get($id = '')
      {
            if ($id == '') {
                  $query = "SELECT c.coupon_id, c.client_dui, c.offer_id, s.state_name FROM coupons AS c
                  INNER JOIN coupon_states AS s ON c.coupon_state_id = s.coupon_state_id";
                  return $this->getQuery($query);
            } else {
                  $query = "SELECT c.coupon_id, c.client_dui, c.offer_id, s.state_name FROM coupons AS c
                  INNER JOIN coupon_states AS s ON c.coupon_state_id = s.coupon_state_id
                  WHERE c.coupon_id=:coupon_id";
                  return $this->getQuery($query, ['coupon_id' => $id])[0];
            }
      }

      public function getClientCoupons($dui)
      {
            $query = "SELECT c.coupon_id, o.title, s.state_name, o.deadline_date FROM coupons AS c
            INNER JOIN coupon_states AS s ON c.coupon_state_id = s.coupon_state_id
            INNER JOIN offers AS o ON o.offer_id = c.offer_id
            WHERE c.client_dui=:client_dui";
            return $this->getQuery($query, ['client_dui' => $dui]);
      }

      public function insert($coupon = [])
      {
            $query = "INSERT INTO coupons (coupon_id, client_dui, offer_id, coupon_state_id) 
            VALUES (:coupon_id, :client_dui, :offer_id, 1)";
            return $this->setQuery($query, $coupon)[0];
      }

      public function useCoupon($coupon = [])
      {
            $query = "UPDATE coupons SET coupon_state_id = :category_name WHERE coupon_id = 3";
            return $this->setQuery($query, $coupon)[0];
      }

      public function expireCoupon($coupon = [])
      {
            $query = "UPDATE coupons SET coupon_state_id = :category_name WHERE coupon_id = 2";
            return $this->setQuery($query, $coupon)[0];
      }
}
