<?php

require_once 'Model.php';

class ClientsModel extends Model
{
      public function get($email = '')
      {
            if ($email == '') {
                  $query = "SELECT c.dui, c.phone, c.address, c.token, c.verified, u.first_name, u.last_name, u.email, t.type_name FROM clients AS c
                  INNER JOIN users AS u ON c.user_id = u.user_id
                  INNER JOIN user_types AS t ON u.type_id = t.type_id";
                  return $this->getQuery($query);
            } else {
                  $query = "SELECT c.dui, c.phone, c.address, c.token, c.verified, u.first_name, u.last_name, u.email, t.type_name FROM clients AS c
                  INNER JOIN users AS u ON c.user_id = u.user_id
                  INNER JOIN user_types AS t ON u.type_id = t.type_id
                  WHERE u.email = :email";
                  return $this->getQuery($query, ['email' => $email])[0];
            }
      }

      public function register($client = [])
      {
            $user = [
                  'first_name' => $client['first_name'],
                  'last_name' => $client['last_name'],
                  'pass' => $client['pass'],
                  'email' => $client['email']
            ];
            $clientPayload = [
                  'dui' => $client['dui'],
                  'phone' => $client['phone'],
                  'address' => $client['address'],
                  'token' => $client['token']
            ];

            $query = "INSERT INTO users (first_name, last_name, pass, email, type_id)
            VALUES (:first_name, :last_name, SHA2(:pass,256), :email, 3)";
            $id = $this->setQuery($query, $user)[1];
            $query1 = "INSERT INTO clients (dui, phone, address, token, user_id, verified)
            VALUES (:dui, :phone, :address, :token, $id, false)";
            return $this->setQuery($query1, $clientPayload)[1];
      }

      public function verifyCredentials($user, $pass)
      {
            $query = "SELECT c.dui, c.verified, u.email, t.type_name, u.first_name, u.last_name FROM clients AS c
            INNER JOIN users AS u ON c.user_id = u.user_id
            INNER JOIN user_types AS t ON u.type_id = t.type_id
            WHERE u.email = :email AND pass = SHA2(:pass,256)";
            return $this->getQuery($query, ['email' => $user, 'pass' => $pass]);
      }

      public function setVerified($dui)
      {
            $query = "UPDATE clients SET verified = true WHERE dui=:dui";
            return $this->setQuery($query, ['dui' => $dui])[0];
      }

      public function changePass($email, $pass)
      {
            $query = "UPDATE users SET pass = SHA2(:pass,256) WHERE email=:email";
            return $this->setQuery($query, ['email' => $email, 'pass' => $pass])[0];
      }
}
