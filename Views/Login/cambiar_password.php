<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Victor Arango" > 
    <meta name="theme-color" content="#0c39a1">
    <link rel="shortcut icon" href="<?= media();?>/images/favicon.ico" >
    <!--ESTILOS CSS PARA LOGIN -->
    <link rel="stylesheet" type="text/css" href="<?= media() ?>/css/main.css">
    <link rel="stylesheet" type="text/css" href="<?= media() ?>/css/style.css">
    
    <title><?= $data['page_tag']; ?></title>
</head>
<body>
<section class="material-half-bg">
      <div class="cover"></div>
    </section>
    <section class="login-content">
      <div class="logo">
      <h1 class="titulo"></h1>
      <img src="<?= media(); ?>/images/logo_admin.png" alt="">
      </div>
      <div class="login-box flipped">
      <div id="divLoading">
          <div>
            <img src="<?= media(); ?>/images/loading.svg" alt="Loading">
          </div>
        </div>
        <form id="formCambiarPass"  name="formCambiarPass" class="forget-form" action="">
            <input type="hidden" id="idUsuario" name="idUsuario" value="<?= $data['idpersona']; ?>">
            <input type="hidden" id="txtEmail" name="txtEmail" value="<?= $data['email']; ?>">
            <input type="hidden" id="txtToken" name="txtToken" value="<?= $data['token']; ?>">

        <h3 class="login-head"><i class="fas fa-key"> Cambiar contraseña</i></h3>
          <div class="form-group">
            <input id="txtPassword" name="txtPassword" class="form-control" type="password" placeholder="Nueva contraseña" required>
          </div>
          <div class="form-group">
            <input id="txtPasswordConfirm" name="txtPasswordConfirm" class="form-control" type="password" placeholder="Confirmar contraseña" required>
          </div>
          <div class="form-group btn-container">
            <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-unlock fa-lg fa-fw"></i>REINICIAR</button>
          </div>
         
        </form>
      </div>
    </section>
    

<script>
  const base_url ="<?= base_url(); ?>";
</script>


<!-- ARCHIVOS JAVASCRIPT ESENCIALES PARA EL FUNCIONAMIENTO DEL SITIO-->
<script src="<?= media() ?>/js/jquery-3.3.1.min.js"></script>
<script src="<?= media() ?>/js/popper.min.js"></script>
<script src="<?= media() ?>/js/bootstrap.min.js"></script>
<script src="<?= media() ?>/js/fontawesome.js"></script>
<script src="<?= media() ?>/js/main.js"></script>


<script src="<?=media() ?>/js/plugins/pace.min.js"></script>
<script type="text/javascript" src="<?= media() ?>/js/plugins/sweetalert.min.js"></script>
<script src="<?=media() ?>/js/<?=$data['page_functions_js']; ?>"></script>


</body>
</html>

