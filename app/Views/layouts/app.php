<l!<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?= esc($title) ?></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <base href="<?= base_url('public/assets') ?>/" >
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
  </head>
  <body>
  
  <!-- Navigation bar -->
  <nav class="navbar navbar-expand-sm navbar-dark bg-dark d-flex justify-content-between">
    <!-- Logo -->
    <div class="container-fluid">
      <a class="navbar-brand" href="javascript:void(0)">
        <img src="images/logo_pusat-racun.png" alt="Logo" width="300px">
      </a>
    </div>
    <!-- End logo -->  
    <!-- Nav item -->
    <div class="collapse navbar-collapse" id="mynavbar">
      <ul class="navbar-nav me-auto">
        <li class="nav-item">
          <a class="nav-link" href="javascript:void(0)">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="javascript:void(0)">About</a>
        </li>
        <!-- Check if user login -->
        <?php if(auth()->loggedIn()): ?>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle active" href="javascript:void(0)" role="button" data-bs-toggle="dropdown"><?= esc(auth()->user()->name); ?></a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#">Profile</a></li>
            <li><a class="dropdown-item" href="<?= base_url('logout'); ?>">Logout</a></li>
          </ul>
        </li>
        <?php else : ?>
        <li class="nav-item">
          <a class="nav-link" href="<?= base_url('login'); ?>">Login</a>
        </li>
        <?php endif; ?>
        <!-- End check user login part -->
      </ul>
    </div>
    <!-- End nav item -->
  </nav>
  <!-- End navigation bar -->

  <!-- Content Section -->
  <div>
    <?= $this->renderSection('content'); ?>
  </div>
  <!-- End content section -->

  </body>
</html>