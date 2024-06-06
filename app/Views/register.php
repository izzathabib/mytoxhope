<!-- Import view from folder layouts and file app.php -->
<?= $this->extend('layouts/app.php'); ?>
<?= $this->section('content'); ?>

<h1>Registration</h1>
<form action="" method="post">
  <label for="company_reg_no">Company Registration No.:</label>
  <input type="text" id="company_reg_no" name="company_reg_no" required><br><br>

  <label for="company_name">Company Name:</label>
  <input type="text" id="company_name" name="company_name" required><br><br>

  <label for="name">Name:</label>
  <input type="text" id="name" name="name" required><br><br>

  <label for="email">Email:</label>
  <input type="email" id="email" name="email" required><br><br>

  <label for="password">Password:</label>
  <input type="password" id="password" name="password" required><br><br>

  <label for="repeat_password">Repeat Password:</label>
  <input type="password" id="repeat_password" name="repeat_password" required><br><br>

  <button type="submit">Register</button>
</form>

<?= $this->endsection(); ?>