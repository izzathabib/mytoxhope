<?= $this->extend('layouts/app.php'); ?>
<?= $this->section('content'); ?>

<div class="container-fluid p-5">
<h4 class="text-left"><b><?= esc($title) ?></b></h4>

<div class="card w-100 shadow-sm">
  <div class="card-body">

    <!-- Main Product detail -->
    <div class="row">
      <!-- Product Image -->
      <div class="col-md-6">
        <img src="images/product/<?= $productData['product_image'] ?>" alt="Image" class="img-fluid">
      </div>

      <!-- Product Detail -->
      <div class="col-md-6">
      <div class="">
          <h2><?= $productData['product_name']; ?></h2>
          <br>
          <h6>Product Name</h6>
          <p><?= $productData['product_name']; ?></p>

          <h6>Brand Name</h6>
          <p><?= $productData['brand_name']; ?></p>

          <h6>Type of Poison</h6>
          <p><?= $productData['type_poison']; ?></p>

          <h6>Subtype of Household / Consumer Product</h6>
          <p><?= $productData['subtype_household']; ?></p>

          <h6>Active Ingredient(s)</h6>
          <p><?= $productData['active_ing']; ?></p>

          <h6>Inactive Ingredient(s)</h6>
          <p><?= $productData['inactive_ing']; ?></p>

          <h6>Product MSDS</h6>
          <p><?= $productData['msds']; ?></p>

          <h6>Last Update</h6>
          <p><?= date('d-m-Y', strtotime($productData['updated_at'])); ?></p>
      </div>
      </div>
    </div>

    <!-- Button -->
    <div class="row mt-3">
      <div class="col-md-12 text-center">
        <a class="btn btn-primary" href="<?= url_to('productUpdate',$productData['id']) ?>">Update</a>
        <a class="btn btn-secondary" href="#">Discontinued</a>
        <a class="btn btn-danger" href="#">Delete</a>
      </div>
    </div>
  </div>
</div>
  
</div>


<?= $this->endsection(); ?>