<l!<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?= esc($title) ?></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <base href="<?= base_url('public/assets') ?>/" >
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .card-container {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
        }

        .card {
            margin: 10px;
            width: 22%;
            min-width: 200px;
        }

        .fa-home {
            margin-right: 8px;
        }
    </style>
  </head>
  <body>
  
  <nav class="navbar navbar-expand-sm navbar-dark bg-dark">
      <!-- Logo -->
      <div class="container-fluid d-flex align-items-center">
        <div class="d-flex align-items-center">
          <a class="navbar-brand" href="https://prn.usm.my/">
            <img src="images/logo_pusat-racun.png" alt="Logo 1" width="300px">
          </a>
          <a class="navbar-brand ms-0" href="<?= base_url(); ?>">
            <img src="images/mytoxhope-white.png" alt="Logo 2" width="100px">
          </a>
        </div>
      </div>
      <!-- End logo -->
      <!-- Nav item -->
      <div class="collapse navbar-collapse" id="mynavbar">
        <ul class="navbar-nav me-auto">
          <li class="nav-item">
            <a class="nav-link" href="<?= base_url(); ?>">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="javascript:void(0)">About</a>
          </li>
          <!-- Check if user login -->
          <?php if (auth()->loggedIn()): ?>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle active" href="#" role="button"
                data-bs-toggle="dropdown"><?= esc(auth()->user()->name); ?></a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#">Profile</a></li>
                <li><a class="dropdown-item" href="<?= base_url('logout'); ?>">Logout</a></li>
              </ul>
            </li>
          <?php else: ?>
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
  <div class="container-fluid">
    <?= $this->renderSection('content'); ?>
  </div>
  <!-- End content section -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
  <script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Bootstrap components that need JS interaction
    var dropdownToggleList = [].slice.call(document.querySelectorAll('.dropdown-toggle'));
    var dropdownList = dropdownToggleList.map(function (dropdownToggle) {
      return new bootstrap.Dropdown(dropdownToggle);
    });
});
</script>

  </body>
</html>