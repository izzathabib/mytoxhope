<!-- Import view from folder layouts and file app.php -->
<?= $this->extend('layouts/app.php'); ?>
<?= $this->section('content'); ?>

<!-- Display company name -->
<div class="container p-4 mt-3">
  <div class="container-fluid">
  <?php foreach($companyData as $data): ?>
    <h1><?= $data->comp_name; ?></h1>
  <?php endforeach; ?>
  </div>
</div>
<!--  -->

<!-- Main card -->
<div class="container">
  <div class="row">
            <!-- Knowledge Base Card -->
            <div class="col-md-4">
                <div class="card text-center h-100 w-100 shadow-sm">
                    <div class="card-body">
                        <div class="card-icon bg-light">
                            <i class="fas fa-book"></i>
                        </div>
                        <h5 class="card-title">Knowledge Base</h5>
                        <p class="card-text">Ouch found swore much dear conductively hid submissively hatchet vexed far inanimately alongside candidly much and jeez</p>
                        <a href="#" class="btn btn-success">Subscribe</a>
                    </div>
                </div>
            </div>
            <!-- Products Card -->
            <div class="col-md-4">
                <div class="card text-center h-100 w-100 shadow-sm">
                    <div class="card-body">
                        <div class="card-icon bg-light">
                        <i class="fas fa-box"></i>
                        </div>
                        <h5 class="card-title">Products</h5>
                        <p class="card-text">Diabolically somberly astride crass one endearingly blatant depending peculiar antelope piquantly popularly adept much</p>
                        <a href="<?= url_to('productList') ?>" class="btn btn-primary">View Product</a>
                    </div>
                </div>
            </div>
            <!-- Support Center Card -->
            <div class="col-md-4">
                <div class="card text-center h-100 w-100 shadow-sm">
                    <div class="card-body">
                        <div class="card-icon bg-light">
                        <i class="fas fa-hands-helping"></i>
                        </div>
                        <h5 class="card-title">Support Center</h5>
                        <p class="card-text">Dear spryly growled much far jeepers vigilantly less and far hideous and some mannishly less jeepers less and and crud</p>
                        <a href="#" class="btn btn-warning">Open a ticket</a>
                    </div>
                </div>
            </div>
  </div>
</div>
<!---->

<?= $this->endsection(); ?>