<!-- Import view from folder layouts and file app.php -->
<?= $this->extend('layouts/app.php'); ?>
<?= $this->section('content'); ?>

<!-- Company Name -->
<?php foreach ($company_detail as $key) :?>
<h1><?= $key['company_name']; ?></h1>
<?php endforeach; ?>
<!--  -->

<?= $this->endsection(); ?>