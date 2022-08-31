<?php 
headerTienda($data);
 ?>
<br><br><br>
<div class="jumbotron text-center">
  <h1 class="display-4">!Gracias por tu compra¡</h1>
  <p class="lead">Tu pedido ha sido procesado exitosamente</p>
  <p>No. orden: <strong><?= $data['orden']; ?></strong> </p>

  <?php 
    if(!empty($data['transaccion'])){
    ?>
     <p>transacción: <strong><?= $data['transaccion']; ?></strong> </p>
    <?php 
    }
    ?>

  <hr class="my-4">
  <p>Muy pronto estaremos en contacto para coordinar la entrega.</p>
    <p>Puedes ver o validar el estado de tu pedido en el perfil de tu usuario.</p>
    <br>
  <a class="btn btn-primary btn-lg" href="<?= base_url();?>" role="button"> Continuar</a>
</div>

<?php 
    footerTienda($data);
 ?>
    