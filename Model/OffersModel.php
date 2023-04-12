<?php

require_once 'Model.php';

class OffersModel extends Model
{
      public function get($id = '')
      {
            if ($id == '') {
                  $query = "SELECT o.offer_id, o.title, o.limit_qty, o.offer_description,
                  o.details, o.start_date, o.end_date, o.original_price, o.offer_price,
                  co.company_name, s.offer_state_description, o.justification, o.deadline_date,
                  o.available_qty, ca.category_name, co.company_id FROM offers AS o
                  INNER JOIN offer_states AS s ON o.offer_state_id = s.offer_state_id
                  INNER JOIN companies AS co ON o.company_id = co.company_id
                  INNER JOIN categories AS ca ON co.category_id = ca.category_id
                  ORDER BY o.offer_id";
                  return $this->getQuery($query);
            } else {
                  $query = "SELECT o.offer_id, o.title, o.limit_qty, o.offer_description,
                  o.details, o.start_date, o.end_date, o.original_price, o.offer_price,
                  co.company_name, s.offer_state_description, o.justification, o.deadline_date,
                  o.available_qty, ca.category_name, co.company_id FROM offers AS o
                  INNER JOIN offer_states AS s ON o.offer_state_id = s.offer_state_id
                  INNER JOIN companies AS co ON o.company_id = co.company_id
                  INNER JOIN categories AS ca ON co.category_id = ca.category_id
                  WHERE offer_id=:offer_id ORDER BY o.offer_id";
                  return $this->getQuery($query, ['offer_id' => $id])[0];
            }
      }

      public function getCompanyOffers($company_id)
      {
            $query = "SELECT o.offer_id, o.title, o.limit_qty, o.offer_description,
            o.details, o.start_date, o.end_date, o.original_price, o.offer_price,
            c.company_name, s.offer_state_description, o.justification, o.deadline_date,
            o.available_qty FROM offers AS o
            INNER JOIN offer_states AS s ON o.offer_state_id = s.offer_state_id
            INNER JOIN companies AS c ON o.company_id = c.company_id
            WHERE o.company_id = :company_id ORDER BY o.offer_id";
            return $this->getQuery($query, ['company_id' => $company_id]);
      }

      public function insert($offer = [])
      {
            $query = "INSERT INTO offers (title, limit_qty, offer_description, details, start_date, end_date, original_price, offer_price, company_id, offer_state_id, justification, deadline_date, available_qty)
            VALUES(:title, :limit_qty, :offer_description, :details, :start_date, :end_date, :original_price, :offer_price, :company_id, 1, '', :deadline_date, :available_qty)";
            return $this->setQuery($query, $offer)[0];
      }

      public function declineOffer($id, $justification)
      {
            $query = "UPDATE offers SET (justification = :justification, offer_state_id = 3) WHERE offer_id=:offer_id";
            return $this->setQuery($query, ['justification' => $justification, 'offer_id' => $id])[0];
      }

      public function acceptOffer($id, $justification)
      {
            $query = "UPDATE offers SET (justification = :justification, offer_state_id = 2) WHERE offer_id=:offer_id";
            return $this->setQuery($query, ['justification' => $justification, 'offer_id' => $id])[0];
      }

      public function dismissOffer($id, $justification)
      {
            $query = "UPDATE offers SET (justification = :justification, offer_state_id = 4) WHERE offer_id=:offer_id";
            return $this->setQuery($query, ['justification' => $justification, 'offer_id' => $id])[0];
      }

      public function  reduceOfferAvailable($id, $available_qty)
      {
            $query = "UPDATE offers SET available_qty = :available_qty WHERE offer_id=:offer_id";
            return $this->setQuery($query, ['available_qty' => $available_qty, 'offer_id' => $id]);
      }
}
