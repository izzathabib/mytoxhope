<?= $this->extend('layouts/app.php'); ?>
<?= $this->section('content'); ?>

<div class="container-fluid p-5">
  <h4 class="text-left"><b>Register New Product</b></h4>
  <div class="card w-100 shadow-sm">
    <div class="card-body">
      <form method="POST" action="<?= url_to('saveProdDetail'); ?>" enctype="multipart/form-data">
        <div class="row">
          <div class="col-md-6">
            <!-- Product Name -->
            <div class="form-group mb-4">
              <label for="product_name">Product Name</label>
              <input type="text" id="product_name" name="product_name" class="form-control">
            </div>

            <!-- Product Image -->
            <div class="form-group mb-4">
              <label for="product_image">Product Image</label>
              <input type="file" id="product_image" name="product_image" class="form-control">
            </div>

            <!-- Type of Poison -->
            <div class="form-group mb-4">
              <label for="type_poison">Type of Poison</label>
              <select id="type_poison" name="type_poison" class="form-control">
                <option value="Please select">Please select</option>
                <option value="List 1">List 1</option>
                <option value="List 2">List 2</option>
                <option value="List 3">List 3</option>
              </select>
            </div>

            <!-- Active ingredient -->
            <div class="form-group mb-4">
              <label for="active_ing">Active Ingredient/ Chemical Name</label>
              <input type="text" id="active_ing" name="active_ing" class="form-control">
            </div>

            <!-- Inactive ingredient -->
            <div class="form-group mb-4">
              <label for="inactive_ing">Inactive Ingredients</label>
              <textarea id="inactive_ing" name="inactive_ing" class="form-control"></textarea>
            </div>
          </div>

          <div class="col-md-6">
            <!-- Brand Name -->
            <div class="form-group mb-4">
              <label for="brand_name">Brand Name</label>
              <input type="text" id="brand_name" name="brand_name" class="form-control">
            </div>

            <!-- Product MSDS -->
            <div class="form-group mb-4">
              <label for="msds">Product MSDS</label>
              <input type="file" id="msds" name="msds" class="form-control">
            </div>

            <!-- Subtype of Household / Consumer Product -->
            <div class="form-group mb-4">
              <label for="subtype_household">Subtype of Household / Consumer Product</label>
              <select id="subtype_household" name="subtype_household" class="form-control">
                <option value="Please select">Please select</option>
                <option value="List 1">List 1</option>
                <option value="List 2">List 2</option>
                <option value="List 3">List 3</option>
              </select>
            </div>
          </div>
        </div>

        <!-- Submit and Cancel buttons -->
        <div class="row mt-3">
          <div class="col-md-12 text-center">
            <button type="submit" value="Submit" class="btn btn-primary">Add Product</button>
            <a href="<?= site_url('dashboard'); ?>" class="btn btn-secondary">Cancel</a>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<?= $this->endSection(); ?>

<style>
  .card-body {
    padding: 2rem;
  }

  .form-group {
    margin-bottom: 1.5rem;
  }

  .form-group.mb-4 {
    margin-bottom: 1.5rem;
  }

  .btn {
    width: 150px;
  }
</style>
