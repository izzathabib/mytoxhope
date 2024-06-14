<!-- Import view from folder layouts and file app.php -->
<?= $this->extend('layouts/app.php'); ?>
<?= $this->section('content'); ?>
<h1>Register New Product</h1>

<div class="card">
  <div class="card-body">
  <form action="/action_page.php">

    <div class="row">
      <div class="col">
        <!-- Product Name -->
        <div class="form-group">
          <label for="product_name">Product Name</label>
          <input type="text" id="product_name" name="product_name" class="form-control"><br>
        </div>

        <!-- Product Image -->
        <div class="form-group">
          <label for="product_image">Product Image</label>
          <input type="file" id="product_image" name="product_image" class="form-control"><br>
        </div>

        <!-- Type of Poison -->
        <div class="form-group">
          <label for="poison_type">Type of Poison</label>
          <select id="poison_type" name="poison_type" class="form-control">
            <option value="Please select">Please select</option>
            <option value="List 1">List 1</option>
            <option value="List 2">List 2</option>
            <option value="List 3">List 3</option>
          </select><br>
        </div>

        <!-- Active ingredient -->
        <div class="form-group">
          <label for="active_ingredient">Active Ingredient/ Chemical Name</label>
          <input type="text" id="active_ingredient" name="active_ingredient" class="form-control"><br>
        </div>

        <!-- Inactive ingredient -->
        <div class="form-group">
          <label for="inactive_ingredient">Inactive Ingredients</label>
          <textarea type="textarea" id="inactive_ingredient" name="inactive_ingredient" class="form-control">
          </textarea><br>
        </div>
      </div>

      <div class="col">
        <!-- Brand Name -->
        <div class="form-group">
          <label for="brand_name">Brand Name</label>
          <input type="text" id="brand_name" name="brand_name" class="form-control"><br>
        </div>

        <!-- Product MSDS -->
        <div class="form-group">
          <label for="msds">Product MSDS</label>
          <input type="file" id="msds" name="msds" class="form-control"><br>
        </div>

        <!-- Subtype of Household / Consumer Product -->
        <div class="form-group">
          <label for="type_household">Subtype of Household / Consumer Product</label>
          <select id="type_household" name="type_household" class="form-control">
            <option value="Please select">Please select</option>
            <option value="List 1">List 1</option>
            <option value="List 2">List 2</option>
            <option value="List 3">List 3</option>
          </select><br>
        </div>

        <!-- Submit botton -->
        <div class="form-group">
          <input type="submit" value="Submit" class="btn btn-primary">
        </div>
      </div>
    </div>
  </form>
  </div>
</div>

<?= $this->endsection(); ?>
