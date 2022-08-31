<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="description" content="Tienda Virtual Grupo ALV S.A.S">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="author" content="Victor Arango">
  <meta name="theme-color" content="#16178A">
  <link rel="shortcut icon" href="<?= media();?>/images/favicon.ico" <title><?= $data['page_tag']?></title>
  <!-- Main CSS-->
  <link rel="stylesheet" type="text/css" href="<?= media() ?>/css/main.css">
  <link rel="stylesheet" type="text/css" href="<?= media() ?>/css/bootstrap-select.min.css"> 

  <link rel="stylesheet" type="text/css" href="<?= media() ?>/css/style.css">
</head>

<body class="app sidebar-mini">
  <!-- loading-->
  <div id="divLoading">
          <div>
            <img src="<?= media(); ?>/images/loading.svg" alt="Loading">
          </div>
        </div>

  <header class="app-header">
    <a class="app-header__logo" href="<?= base_url();?>/dashboard">GRUPO ALV</a>
    <!-- Sidebar toggle button--><a class="app-sidebar__toggle" href="#" data-toggle="sidebar" aria-label="Hide Sidebar"></a>
    <!-- Navbar Right Menu-->
    <ul class="app-nav">
      <!-- User Menu-->
      <li class="dropdown"><a class="app-nav__item" href="#" data-toggle="dropdown" aria-label="Open Profile Menu"><i class="fa fa-user fa-lg"></i></a>
        <ul class="dropdown-menu settings-menu dropdown-menu-right">
          <li><a class="dropdown-item" href="<?= base_url();?>/opciones"><i class="fa fa-cog fa-lg"></i> Opciones</a></li>
          <li><a class="dropdown-item" href="<?= base_url();?>/usuarios/perfil"><i class="fa fa-user fa-lg"></i> Perfil</a></li>
          <li><a class="dropdown-item" href="<?= base_url();?>/logout"><i class="fa fa-sign-out fa-lg"></i> Cerrar sesion</a></li>
        </ul>
      </li>
    </ul>
  </header>
  <?php require_once("nav_admin.php"); ?>
