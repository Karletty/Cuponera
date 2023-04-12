<?php

require_once 'Model.php';

class CategoriesModel extends Model
{
      public function get($id = '')
      {
            if ($id == '') {
                  $query = "SELECT * FROM categories";
                  return $this->getQuery($query);
            } else {
                  $query = "SELECT * FROM categories WHERE category_id = :id";
                  return $this->getQuery($query, ['id' => $id])[0];
            }
      }
}
