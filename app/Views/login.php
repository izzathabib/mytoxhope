<!-- Import view from folder layouts and file app.php -->
<?= $this->extend('layouts/app.php'); ?>
<?= $this->section('content'); ?>

<div class="login-form">
  <h1>Login</h1>
  <form action="" method="post">  
    <label for="username">Username:</label>
    <input type="text" id="username" name="username" required><br><br>
    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required><br><br>
    <button type="submit">Login</button>
  </form><br><br>
  <p><a href="<?= url_to('register') ?>">Register new account</ahref></p>
</div>

<?= $this->endsection(); ?>