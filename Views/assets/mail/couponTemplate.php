<!DOCTYPE html>
<html lang="en">

<head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

      <title>Cupon <?= $coupon['coupon_id'] ?></title>
      <style>
            body {
                  padding: 50px 100px;
                  font-family: sans-serif;
                  text-align: justify;
            }

            table {
                  border-collapse: collapse;
            }

            table * {
                  border: 1px solid #000000;
            }

            table tr th {
                  text-align: justify;
                  background-color: #00000010;
                  padding: 10px;
            }

            table tr td {
                  padding: 10px;
            }

            .img-qr {
                  margin: 10px;
                  width: 150px;
                  height: auto;
            }
      </style>

</head>


<body>
      <header>
            <?php $imgLogo = convertImage("Views/assets/img/logo.png") ?>
            <img class="logo" src="<?= $imgLogo ?>" width="64">
      </header>
      <main>
            <h1>Cupón para: <?= $offer['title'] ?></h1>
            <p>A continuación encontrarás los datos de tu cupón para poder canjearlo en <?= $offer['company_name'] ?></p>
            <table>
                  <tr>
                        <th>Nombre</th>
                        <td><?= $clientName ?></td>
                  </tr>
                  <tr>
                        <th>Documento único de indentidad</th>
                        <td><?= $coupon['client_dui'] ?></td>
                  </tr>
                  <tr>
                        <th>Código del cupón</th>
                        <td><?= $coupon['coupon_id'] ?></td>
                  </tr>
            </table>
            <?php
            QRcode::png('Cupón: ' . $coupon['coupon_id'] . ' Cliente: ' . $coupon['client_dui'], 'Views/assets/img/qrs/' . $coupon['coupon_id'] . '.png');
            $imgQR = convertImage('Views/assets/img/qrs/' . $coupon['coupon_id'] . '.png');
            ?>
            <img class="img-qr" src="<?= $imgQR ?>">
            <p><strong>Este cupón es válido para: </strong><?= $offer['title'] ?></p>
            <p><strong>Incluye: </strong><?= $offer['offer_description'] ?></p>
            <p>Puedes canjear este cupón hasta <?= formatDate($offer['deadline_date']) ?> en cualquiera de las sucursales de <?= $offer['company_name'] ?>. Se recomienda verificar el horario de atención de la empresa.</p>
            <p><strong>Importante: </strong>una vez pasada la fecha (<?= formatDate($offer['deadline_date']) ?>) este cupón será inválido y ya no podrá usarse</p>
      </main>
</body>

</html>