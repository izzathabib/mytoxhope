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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
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

        .card-icon {
          display: flex;
            justify-content: center;
            align-items: center;
            width: 60px;
            height: 60px;
            margin: 0 auto 15px;
            border-radius: 50%;
            background-color: #f8f9fa;
        }

        .card-icon img {
          width: 30px;
          height: 30px;
        }

        .card-text {
          margin-bottom: 1.5rem;
        }

        .form-group {
          margin-bottom: 1.5rem;
        }

        .navbar-brand img {
            max-height: 60px;
        }

        .nav-link i {
            margin-right: 8px;
        }
    </style>
  </head>
  <body>
  
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <!-- Logo -->
      <a class="navbar-brand" href="<?= base_url(); ?>">
        <img src="images/logo_pusat-racun.png" alt="Logo 1" width="150">
        <img src="images/mytoxhope-white.png" alt="Logo 2" width="100">
      </a>
      <!-- Navbar toggler for mobile view -->
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <!-- Nav items -->
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link" href="<?= base_url(); ?>"><i class="fa-solid fa-house"></i> Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?= base_url('about'); ?>"><i class="fa-solid fa-circle-exclamation"></i> About MyToxData</a>
          </li>
          <!-- Check if user login -->
          <?php if (auth()->loggedIn()): ?>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle active" href="#" role="button"
                data-bs-toggle="dropdown"><i class="fa-solid fa-user"></i> <?= esc(auth()->user()->name); ?></a>
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
      <!-- End nav items -->
    </div>
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