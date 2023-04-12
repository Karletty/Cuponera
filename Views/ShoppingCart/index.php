<!DOCTYPE html>
<html lang="en">

<?php
include_once('Views/printHead.php');
include_once('Views/assets/navs/navBar.php');
?>

<head>
      <?php printHead('Carrito'); ?>
</head>

<body>
      <?php printNavBar($user_type, $user_name, 'shoppingCart'); ?>
      <main>
            <div class="container-wrap">
                  <div>
                        <table class="table table-hover">
                              <thead>
                                    <tr>
                                          <th colspan="3">Producto</th>
                                          <th>Precio</th>
                                          <th>Cantidad</th>
                                          <th>Subtotal</th>
                                    </tr>
                              </thead>
                              <tbody>

                                    <?php
                                    $count = 1;
                                    $total = 0;
                                    foreach ($shopping_cart as $offer) {
                                    ?>
                                          <tr>
                                                <td>
                                                      <a href="<?= PATH ?>/ShoppingCart/remove/<?= $offer['offer_id'] ?>" class="btn mt-3" title="Quitar del carrito"><i class="bi bi-cart-x"></i></a>
                                                </td>
                                                <td><img src="<?=PATH?>/Views/assets/img/offers/<?= $offer['offer_id'] ?>.jpg" class="table-img" alt="..."></td>
                                                <td><?= $offer['title'] ?></td>
                                                <td>$<?= number_format((float) $offer['offer_price'], 2, '.', '') ?></td>
                                                <td class="min-100px">
                                                      <form method="post" action="<?= PATH ?>/ShoppingCart/add/<?= $offer['offer_id'] ?>" class="form-shopping d-flex flex-column align-items-center justify-content-center">
                                                            <div class="d-flex align-items-center justify-content-center">
                                                                  <i class="bi bi-dash-circle control me-3" id="control-reduce" onclick="reduce(<?= $count ?>)"></i>
                                                                  <input name="quantity" type="text" value="<?= $offer['quantity'] ?>" class="form-control product-cant" maxcant="<?= $offer['available_qty'] ?>">
                                                                  <i class="bi bi-plus-circle control ms-3" id="control-add" onclick="add(<?= $count ?>, <?= $offer['available_qty'] ?>)"></i>
                                                            </div>
                                                            <div class="d-flex justify-content-betwen">
                                                                  <button name="add" type="submit" class="btn m-3" title="Añadir al carrito"><i class="bi bi-cart-plus"></i></button>
                                                            </div>
                                                      </form>
                                                </td>
                                                <td>$<?= number_format((float) $offer['offer_price'] * $offer['quantity'], 2, '.', '') ?></td>
                                          </tr>
                                    <?php
                                          $count++;
                                          $total += $offer['offer_price'] * $offer['quantity'];
                                    }
                                    ?>
                              </tbody>
                              <tfoot>
                                    <tr>
                                          <th colspan="5" class="table-total">Total</th>
                                          <th>$<?= number_format((float) $total, 2, '.', '') ?></th>
                                    </tr>
                              </tfoot>
                        </table>
                  </div>
                  <div>
                        <form action="<?= PATH ?>/ShoppingCart/validatePay" method="post" class="d-flex flex-column h-100" id="pay-form">
                              <h3>Datos del pago</h3>
                              <hr>
                              <div class="mb-3">
                                    <label class="label-form" for="cc-name">Nombre</label>
                                    <input type="text" name="cc-name" class="form-control" value="<?= isset($creditCard['name']) ? $creditCard['name'] : '' ?>">
                                    <span class="text-danger"><?= isset($errors['name']) ? $errors['name'] : '' ?></span>
                              </div>
                              <div class="mb-3">
                                    <label class="label-form" for="cc-number">No. Tarjeta</label>
                                    <input type="text" name="cc-number" class="form-control" placeholder="0000 0000 0000 0000" value="<?= isset($creditCard['cardNumber']) ? $creditCard['cardNumber'] : '' ?>">
                                    <span class="text-danger"><?= isset($errors['cardNumber']) ? $errors['cardNumber'] : '' ?></span>
                              </div>
                              <div class="mb-3 d-flex">
                                    <div class="w-50 me-3">
                                          <label class="label-form" for="cc-exp-date">Vencimiento</label>
                                          <div class="d-flex w-100">
                                                <input type="text" name="cc-exp-month" class="w-50 me-3 form-control" placeholder="MM" value="<?= isset($creditCard['expMonth']) ? $creditCard['expMonth'] : '' ?>">

                                                <input type="text" name="cc-exp-year" class="w-50 form-control" placeholder="YY" value="<?= isset($creditCard['expYear']) ? $creditCard['expYear'] : '' ?>">
                                          </div>
                                          <span class="text-danger"><?= isset($errors['date']) ? $errors['date'] : '' ?></span>
                                    </div>
                                    <div class="w-50">
                                          <label class="label-form" for="cc-cvv">CVV</label>
                                          <input type="text" name="cc-cvv" class="form-control" value="<?= isset($creditCard['cvv']) ? $creditCard['cvv'] : '' ?>">
                                          <span class="text-danger"><?= isset($errors['cvv']) ? $errors['cvv'] : '' ?></span>
                                    </div>
                              </div>
                              <button type="submit" name="pay" class="btn">Finalizar compra</button>
                              <span class="text-secondary">Al realizar el pago los cupones se añadirán a la sección de "Mis cupones" para que puedas descargarlos</span>
                        </form>
                  </div>
            </div>
      </main>
      <script src="<?= PATH ?>/Views/assets/js/shoppingCart.js"></script>
</body>

</html