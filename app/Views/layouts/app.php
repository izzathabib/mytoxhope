<l!<!DOCTYPE html>
  <html>

  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?= esc($title) ?></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <base href="<?= base_url('public/assets') ?>/">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.bootstrap5.min.css">
    <link rel="stylesheet"
      href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <style>
      /* home page css */
      .card-container {
        display: flex;
        justify-content: space-around;
        flex-wrap: wrap;
      }

      .card {
        margin: 10px 0;
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

      html,
      body {
        height: 100%;
        margin: 0;
        padding: 0;
      }

      body {
        display: flex;
        flex-direction: column;
      }

      /* navbar css */
      .navbar-nav .nav-link {
        padding: 0.5rem 1rem;
        font-size: 0.9rem;
      }

      .navbar-nav .nav-item {
        margin-right: 0.5rem;
      }

      .navbar {
        background-color: #2c3034;
        position: fixed;
        top: 0;
        right: 0;
        left: 250px;
        z-index: 1030;
        transition: left 0.3s ease-in-out;
      }

      .navbar.expanded {
        width: 100%;
        margin-left: 0;
      }

      .nav-link i {
        font-size: 0.8rem;
      }

      .navbar-brand {
        margin-left: 4rem;
      }

      .navbar-brand img {
        max-height: 65px;
      }

      .navbar .container-fluid {
        justify-content: flex-start;
      }

      .nav-link i {
        margin-right: 8px;
      }

      .nav-item .nav-link {
        position: relative;
        overflow: hidden;
        border-radius: 4px;
      }

      .nav-item .nav-link::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(to bottom, rgba(255, 255, 255, 0.3), transparent);
        opacity: 0;
        transition: opacity 0.3s ease;
      }

      .nav-item .nav-link:hover::before,
      .nav-item .nav-link.active::before {
        opacity: 1;
      }

      .nav-item .nav-link:hover,
      .nav-item .nav-link.active {
        background-color: rgba(255, 255, 255, 0.1);
      }

      /* footer css */
      .footer {
        flex-shrink: 0;
        width: 100%;
        height: 60px;
        line-height: 60px;
        background-color: #f5f5f5;
      }

      .site-footer {
        background: white;
        position: fixed;
        bottom: 0;
        left: 0;
        width: 100%;
        transition: margin-left 0.3s;
      }

      .site-footer.expanded {
        margin-left: 0;
      }

      .wrapper {
        flex: 1 0 auto;
        display: flex;
        overflow: hidden;
      }

      .content {
        flex: 1;
        overflow-y: auto;
        padding-bottom: 60px;
      }

      .custom-link {
        text-decoration: none !important;
        color: #009AFF !important;
      }

      .custom-link:hover {
        color: #007bff !important;
      }

      /* add product css */
      .tag-input {
        border: 1px solid #ced4da;
        border-radius: 0.25rem;
        padding: 0.375rem 0.75rem;
      }

      .tag-input input {
        border: none;
        outline: none;
        width: 100%;
      }

      .tags-container {
        display: flex;
        flex-wrap: wrap;
        margin-top: 0.5rem;
      }

      .tag {
        background-color: #e9ecef;
        border-radius: 0.25rem;
        padding: 0.25rem 0.5rem;
        margin-right: 0.5rem;
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
      }

      .tag-close {
        margin-left: 0.5rem;
        cursor: pointer;
      }

      /* user list css */
      .dataTables_length select {
        padding-right: 30px !important;
      }

      .dataTables_wrapper .dataTables_length {
        margin-bottom: 15px;
      }

      /* Sidebar styles */
      .sidebar {
        width: 250px;
        position: fixed;
        top: 0;
        left: 0;
        height: 100vh;
        z-index: 1000;
        background: #2c3034;
        transition: transform 0.3s ease-in-out;
      }

      .sidebar.mobile {
        transform: translateX(-100%);
      }

      .sidebar.mobile.active {
        transform: translateX(0);
      }

      .sidebar.collapsed {
        transform: translateX(-250px);
      }

      .sidebar-header {
        padding: 20px;
      }

      .sidebar ul li a {
        padding: 10px;
        font-size: 1.1em;
        display: block;
        color: #f7f7f7;
        text-decoration: none;
      }

      .sidebar ul li a:hover {
        color: #007bff;
        background: #fff;
      }

      /* Content wrapper styles */
      .content-wrapper {
        flex: 1;
        margin-left: 250px;
        transition: margin-left 0.3s ease-in-out;
        overflow-y: auto;
        padding-top: 56px;
      }

      .content-wrapper:not(.no-sidebar) {
        margin-left: 250px;
      }

      .content-wrapper.expanded {
        margin-left: 0;
      }

      .content-wrapper.no-sidebar {
        margin-left: 0 !important;
      }

      /* Style for logged out state */
      body:not(.logged-in) .content-wrapper {
        margin-left: 0;
        margin-top: 70px;
      }

      /* Adjust navbar for logged out state */
      body:not(.logged-in) .navbar {
        width: 100%;
        left: 0;
      }

      /* Adjust logo positioning for logged out state */
      body:not(.logged-in) .navbar-brand {
        margin-left: 15px;
      }

      /* Toggle button styles */
      #sidebarToggle {
        position: relative;
        z-index: 1031;
        margin-right: 15px;
        margin-top: 15px;
      }

      body.sidebar-collapsed #sidebarToggle {
        margin-left: 0;
        margin-top: 15px;
      }


      .content-wrapper.expanded #sidebarToggle {
        margin-left: 0;
      }

      /* Collapsed state */
      body.sidebar-collapsed .sidebar {
        transform: translateX(-250px);
      }

      body.sidebar-collapsed .content-wrapper,
      body.sidebar-collapsed .site-footer {
        margin-left: 0;
      }

      body.sidebar-collapsed .navbar {
        left: 0;
      }

      /* Responsive adjustments */
      @media (max-width: 767.98px) {

        .content-wrapper:not(.no-sidebar),
        .site-footer {
          margin-left: 0 !important;
        }

        .navbar {
          width: 100%;
          margin-left: 0;
        }

        #sidebarToggle {
          margin-left: 0;
        }

        .navbar .container-fluid {
          flex-wrap: wrap;
        }

        .navbar-brand,
        .d-flex {
          flex: 0 0 100%;
          margin-bottom: 0;
        }

        .navbar-toggler {
          margin-left: auto;
        }
      }

      @media (min-width: 992px) {
        #sidebarToggle {
          position: fixed;
          top: 10px;
          left: 10px;
          z-index: 1030;
          margin-right: 1rem;
        }

        .navbar-brand {
          margin-left: 4rem;
        }
      }

      @media (max-width: 991.98px) {
        .navbar .container-fluid {
          flex-wrap: wrap;
        }

        .navbar-brand,
        .d-flex {
          flex: 0 0 100%;
          margin-bottom: 0;
        }

        .navbar-toggler {
          margin-left: auto;
        }
      }

      @media (min-width: 768px) {

        #sidebarToggle {
          margin-left: 250px;
        }

        .content-wrapper.expanded #sidebarToggle {
          margin-left: 0;
        }

        .navbar-brand {
          margin-left: 4rem;
        }
      }

      @media (max-width: 767px) {

        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter {
          text-align: left;
          float: none;
        }

        .sidebar {
          transform: translateX(-250px);
        }

        .content-wrapper,
        .navbar,
        .site-footer {
          margin-left: 0;
        }

        .navbar {
          left: 0;
        }

        body:not(.sidebar-collapsed) .sidebar {
          transform: translateX(0);
        }

        #sidebarToggle {
          left: 10px;
        }
      }
    </style>
    <?= $this->renderSection('styles') ?>
  </head>

  <body class="<?= $this->renderSection('bodyClass') ?> <?= auth()->loggedIn() ? 'logged-in' : '' ?>">
    <div class="wrapper">
      <?php if (auth()->loggedIn()): ?>
        <!-- Sidebar -->
        <div class="sidebar sidebar-dark-primary" id="sidebar">
          <ul class="list-unstyled components">
            <!-- Profile -->
            <li>
              <?php if (auth()->user()->inGroup('user')): ?>
              <li>
                <a href="<?= base_url('profile'); ?>"><i class="fa fa-user-circle"></i> Profile </a>
              </li>
            <?php else: ?>
              <a href="#productSubmenu3" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                <i class="fa fa-user"></i> <?= esc(auth()->user()->username); ?>
              </a>
              <ul class="collapse list-unstyled" id="productSubmenu3">
                <li>
                  <a href="<?= base_url('profile'); ?>"><i class="fa fa-user-circle"></i> Edit Profile </a>
                </li>
                <li>
                  <a href="<?= base_url('edit-company'); ?>"><i class="fas fa-user-tie"></i> Edit Company </a>
                </li>
              </ul>
            <?php endif; ?>
            </li>
            <!-- ./Profile -->

            <!-- Dashboard -->
            <li>
              <a href="<?= base_url('dashboard'); ?>"><i class="fas fa-chart-line"></i> Dashboard</a>
            </li>
            <!-- ./Dashboard -->

            <!-- Product -->
            <li>
              <a href="#productSubmenu" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                <i class="fas fa-box"></i> Product
              </a>
              <ul class="collapse list-unstyled" id="productSubmenu">
                <li>
                  <a href="<?= url_to('productList') ?>">
                    <i class="fa-solid fa-table-list"></i> View Product
                  </a>
                </li>
                <li>
                  <a href="<?= url_to('addProduct') ?>">
                    <i class="fas fa-plus"></i> Add Product
                  </a>
                </li>
              </ul>
            </li>
            <!-- ./Product -->

            <!-- User Management -->
            <?php if (auth()->user()->inGroup('superadmin', 'admin')): ?>
              <li>
                <a href="#productSubmenu2" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                  <i class="fa fa-user"></i> Users Management
                </a>
                <ul class="collapse list-unstyled" id="productSubmenu2">
                  <li>
                    <a href="<?= url_to('viewUser') ?>"><i class="fa fa-list"></i> View Users</a>
                  </li>
                  <li>
                    <a href="<?= url_to('addNewUser') ?>"><i class="fa fa-plus-circle"></i> Add New User</a>
                  </li>
                </ul>
              </li>
            <?php endif; ?>
            <!-- ./User Management -->

            <!-- Company Management -->
            <?php if (auth()->user()->inGroup('superadmin')): ?>
              <li>
                <a href="<?= url_to('viewCompany') ?>"><i class="fa fa-building"></i> Company Management</a>
              </li>
            <?php endif; ?>
            <!-- ./Company Management -->

            <!-- Logout button -->
            <li>
              <a href="<?= url_to('logout'); ?>"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </li>
            <!-- Logout button -->
          </ul>
        </div>
        <!-- ./Sidebar -->
      <?php endif; ?>

      <!-- Content Section -->
      <div class="content-wrapper <?= !auth()->loggedIn() ? 'no-sidebar' : '' ?>">
        <nav class="navbar navbar-expand-lg navbar-dark">
          <div class="container-fluid">
            <?php if (auth()->loggedIn()): ?>
              <button id="sidebarToggle" class="btn btn-dark">
                <i class="fas fa-bars"></i>
              </button>
            <?php endif; ?>
            <!-- Logo -->
            <a class="navbar-brand <?= !auth()->loggedIn() ? 'ms-3' : 'ms-5' ?>" href="<?= base_url(); ?>">
              <img src="images/logo_pusat-racun.png" alt="Logo 1" width="180">
              <img src="images/mytoxhope-white.png" alt="Logo 2" width="100">
            </a>

            <!-- Navbar toggler for mobile view -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
              data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
              aria-label="Toggle navigation">
              <i class="fa fa-caret-down"></i>
            </button>
            <!-- Nav items -->
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                  <a class="nav-link" href="<?= base_url(); ?>"><i class="fa-solid fa-house"></i> Home</a>
                </li>
                <!-- Dashboard link for logged in users -->
                <?php if (auth()->loggedIn()): ?>
                  <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('dashboard'); ?>"><i class="fas fa-chart-line"></i>
                      Dashboard</a>
                  </li>
                <?php endif; ?>
                <li class="nav-item">
                  <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#aboutModal">
                    <i class="fa-solid fa-circle-exclamation"></i> About MyToxHope
                  </a>
                </li>
                <!-- Check if user login -->
                <?php if (auth()->loggedIn()): ?>
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
        <div class="content container-fluid mt-0">
          <?= $this->renderSection('content'); ?>
        </div>
        <!-- Footer section -->
        <footer class="site-footer bg-tertiary text-center">

          <!-- Copyright -->
          <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.05);">
            &copy; 2024
            <a class="text-body custom-link" href="<?= base_url(); ?>" style="text-decoration: none;">MyToxHope </a>
            is powered by
            <a class="text-body custom-link" href="https://ppkt.usm.my/" style="text-decoration: none;">PPKT</a>
            for
            <a class="text-body custom-link" href="https://prn.usm.my/" style="text-decoration: none;">National Poison
              Centre USM</a>
          </div>
          <!-- Copyright -->
        </footer>
      </div>
      <!-- End content section -->
    </div>

    <!-- Modal Structure -->
    <div class="modal fade" id="aboutModal" tabindex="-1" aria-labelledby="aboutModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="aboutModalLabel">About MyToxHope</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="ratio ratio-16x9">
              <iframe id="aboutVideo" src="" title="YouTube video"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                allowfullscreen></iframe>
              allowfullscreen></iframe>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.1/js/responsive.bootstrap5.min.js"></script>
    <script>
      document.addEventListener('DOMContentLoaded', function () {
        const sidebar = document.getElementById('sidebar');
        const contentWrapper = document.querySelector('.content-wrapper');
        const sidebarToggle = document.getElementById('sidebarToggle');
        const navbar = document.querySelector('.navbar');
        const footer = document.querySelector('.site-footer');

        function toggleSidebar() {
          document.body.classList.toggle('sidebar-collapsed');
          localStorage.setItem('sidebarCollapsed', document.body.classList.contains('sidebar-collapsed'));
        }

        if (sidebarToggle) {
          sidebarToggle.addEventListener('click', toggleSidebar);
        }

        // Load sidebar state from localStorage
        const sidebarCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
        if (sidebarCollapsed) {
          document.body.classList.add('sidebar-collapsed');
        }

        // Handle resize
        function handleResize() {
          if (window.innerWidth < 768) {
            document.body.classList.add('sidebar-collapsed');
          } else if (!sidebarCollapsed) {
            document.body.classList.remove('sidebar-collapsed');
          }
        }

        window.addEventListener('resize', handleResize);
        handleResize(); // Call on initial load

        // Initialize Bootstrap components that need JS interaction
        var dropdownToggleList = [].slice.call(document.querySelectorAll('.dropdown-toggle'));
        var dropdownList = dropdownToggleList.map(function (dropdownToggle) {
          return new bootstrap.Dropdown(dropdownToggle);
        });

        // Modal video handling
        $('#aboutModal').on('hidden.bs.modal', function () {
          $('#aboutVideo').attr('src', '');
        });

        $('#aboutModal').on('show.bs.modal', function () {
          $('#aboutVideo').attr('src', 'https://www.youtube.com/embed/9ZNK-bKv5tI?si=t3FSmLKbOQfK4UhL');
        });
      });
    </script>

  </body>

  </html>