<!-- Import view from folder layouts and file app.php -->
<?= $this->extend('layouts/app.php'); ?>
<?= $this->section('content'); ?>

<!-- Display company name -->
<div class="container p-4">
  <div class="container-fluid">
  <?php if(auth()->loggedIn()) :?>
  <h1><?= esc(auth()->user()->comp_name) ?></h1>
  <?php endif; ?>
  </div>
</div>
<!--  -->

<!-- Main card -->
<div class="container card">
  <div class="row card-body">
    <div class="col">
      <div class="card">
        <div class="card-body">
          <img>
          <h4 class="card-title">Knowledge Base</h4>
          <p class="card-text">Description goes here</p>
          <a href="#" class="btn btn-primary">Go somewhere</a>
        </div>
      </div>
    </div>
    <div class="col">
      <div class="card">
        <div class="card-body">
          <img>
          <h4 class="card-title">Products</h4>
          <p class="card-text">Description goes here</p>
          <a href="<?= url_to('addProduct') ?>" class="btn btn-primary">Add Product</a>
        </div>
      </div>
    </div>
    <div class="col">
      <div class="card">
        <div class="card-body">
          <img>
          <h4 class="card-title">Knowledge Base</h4>
          <p class="card-text">Description goes here</p>
          <a href="#" class="btn btn-primary">Go somewhere</a>
        </div>
      </div>
    </div>
  </div>
</div>
<!---->

<?= $this->endsection(); ?>