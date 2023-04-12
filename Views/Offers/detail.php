<!DOCTYPE html>
<html lang="en">

<?php
require_once('Views/printHead.php');
require_once('Views/assets/navs/navBarLogin.php');
require_once('Views/assets/navs/navBar.php');
?>

<head>
      <?php printHead('Detalle de oferta'); ?>
</head>


<body>
      <?php
      if (isset($user_type)) {
            printNavBar($user_type, $user_name, 'none');
      } else {
            printNavBarLogin('offers', 'none');
      } ?>
      <div class="offer-container">
            <div class="card p-4">
                  <div class="card-body">
                        <div class="container-wrap">
                              <div>
                                    <img class="img-detail" src="<?= PATH ?>/Views/assets/img/offers/<?= $offer['offer_id'] ?>.jpg" alt="Imagen de oferta">
                                    <p class="text-secondary"><strong>Disponibles: </strong><?= $offer['available_qty'] ?></p>
                              </div>
                              <div>
                                    <h2 class="card-title fs-5"><?= $offer['title'] ?></h2>
                                    <p><strong>Descripción: </strong><?= $offer['offer_description'] ?></p>
                                    <p><strong>Categoría: </strong><?= $offer['category_name'] ?></p>
                                    <p><strong>Empresa ofertante: </strong><?= $offer['company_name'] ?></p>
                                    <p><strong>Fecha límite de la oferta: </strong><?= $offer['end_date'] ?></p>
                                    <p><strong>Precio original: </strong>$<?= number_format((float) $offer['original_price'], 2, '.', '') ?></p>
                                    <p><strong>Precio de oferta: </strong>$<?= number_format((float) $offer['offer_price'], 2, '.', '')  ?></p>
                              </div>
                        </div>
                        <hr>
                        <p><strong>Detalles: </strong></p>
                        <?php echo $offer['details'] ?>

                        <?php
                        if (isset($user_type) && $user_type == 'cliente') {
                        ?>
                              <form method="post" action="<?= PATH ?>/ShoppingCart/add/<?= $offer['offer_id'] ?>" class="form-shopping d-flex flex-column align-items-center justify-content-center">
                                    <div class="d-flex align-items-center justify-content-center">
                                          <i class="bi bi-dash-circle control me-3" id="control-reduce" onclick="reduce(<?= $offer['offer_id'] ?>)"></i>
                                          <input name="quantity" type="text" value="<?= isset($shopping_cart) && isset($shopping_cart[$offer['offer_id']]) ? $shopping_cart[$offer['offer_id']] : '1' ?>" class="form-control product-cant" maxcant="<?= $offer['available_qty'] ?>">
                                          <i class="bi bi-plus-circle control ms-3" id="control-add" onclick="add(<?= $offer['offer_id'] ?>, <?= $offer['available_qty'] ?>)"></i>
                                    </div>
                                    <div class="d-flex justify-content-betwen">
                                          <button name="add" type="submit" class="btn m-3" title="Añadir al carrito"><i class="bi bi-cart-plus"></i></button>
                                          <?php
                                          if (isset($shopping_cart) && isset($shopping_cart[$offer['offer_id']])) {
                                          ?>
                                                <a href="<?= PATH ?>/ShoppingCart/remove/<?= $offer['offer_id'] ?>" class="btn m-3" title="Quitar del carrito"><i class="bi bi-cart-x"></i></a>
                                          <?php
                                          }
                                          ?>
                                    </div>
                              </form>
                        <?php
                        } ?>

                        <div class="d-flex align-items-end justify-content-end">
                              <a href="<?= PATH ?>/Offers" class="mt-2 btn">Volver al inicio</a>
                        </div>
                  </div>
            </div>
      </div>
      <script src="<?= PATH ?>/Views/assets/js/shoppingCart.js"></script>
</body>

</html>