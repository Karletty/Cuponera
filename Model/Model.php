<?php
abstract class Model
{
      private $hostname = "localhost";
      private $user = "root";
      private $pass = "123456";
      private $db = "coupon_binder";
      protected $conn;

      protected function openConnection()
      {
            try {
                  $this->conn = new PDO("mysql:host=$this->hostname;dbname=$this->db;charset=utf8", $this->user, $this->pass);
            } catch (PDOException $e) {
                  echo $e->getMessage();
            }
      }

      protected function closeConnection()
      {
            $this->conn = null;
      }
      //Metodo para ejecutar consultas de seleccion
      protected function getQuery($query, $params = array())
      {
            try {
                  $this->openConnection();
                  $st = $this->conn->prepare($query);
                  $st->execute($params);
                  $rows = $st->fetchAll();
                  $this->closeConnection();
                  return $rows;
            } catch (Exception $e) {
                  $this->closeConnection();
                  return null;
            }
      }

      protected function setQuery($query, $params = array())
      {
            try {
                  $this->openConnection();
                  $st = $this->conn->prepare($query);
                  $st->execute($params);
                  $affectedRows = $st->rowCount();
                  return [$affectedRows, $this->conn->lastInsertId()];
                  $this->closeConnection();
            } catch (Exception $e) {
                  echo $e->getMessage();
                  $this->closeConnection();
                  return [-1, null];
            }
      }
}
