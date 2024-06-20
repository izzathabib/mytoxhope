<?= $this->extend('layouts/app.php'); ?>
<?= $this->section('content'); ?>
<h1><?= esc($title) ?></h1>

<div class="card">
  <h5 class="car-body">
    <h2><?= $product['product_name']; ?></h2>

    <h6>Product Name</h6>
    <p><?= $product['product_name']; ?></p>

    <h6>Brand Name</h6>
    <p><?= $product['brand_name']; ?></p>

    <h6>Type of Poison</h6>
    <p><?= $product['type_poison']; ?></p>

    <h6>Subtype of Household / Consumer Product</h6>
    <p><?= $product['subtype_household']; ?></p>

    <h6>Active Ingredient(s)</h6>
    <p><?= $product['active_ing']; ?></p>

    <h6>Inactive Ingredient(s)</h6>
    <p><?= $product['inactive_ing']; ?></p>

    <h6>Product MSDS</h6>
    <p><?= $product['msds']; ?></p>

    <h6>Last Update</h6>
    <p><?= $product['updated_at']; ?></p>
  </div>
</div>

<?= $this->endsection(); ?>