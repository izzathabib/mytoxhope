<?= $this->extend('layouts/app.php'); ?>
<?= $this->section('content'); ?>

<div class="mt-4">
<div class="container-fluid p-5">
<div class="d-flex align-items-center mb-3" style="margin-left: 0;">
  <a href="javascript:history.back()" class="btn btn-tertiary btn-lg me-3">
    <i class="fas fa-arrow-left"></i>
  </a>
  <h4 class="mb-0"><b><?= esc($title) ?></b></h4>
</div>
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
      <?php if (auth()->user()->inGroup('user')): ?>
        <?php if ($productData['user_id'] == auth()->user()->id): ?>
          <div class="row mt-3">
            <div class="col-md-12 text-center">
              <a class="btn btn-primary" href="<?= url_to('productUpdate', $productData['id']) ?>">Update</a>
              <a class="btn btn-secondary" href="<?= url_to('productDiscontinue', $productData['id']) ?>">Discontinued</a>
              <button type="button" class="btn btn-danger" id="deleteBtn">Delete</button>
            </div>
          </div>
        <?php else: ?>
          <div class="row mt-3">
            <div class="col-md-12 text-center">
              <button disabled class="btn btn-primary" href="<?= url_to('productUpdate', $productData['id']) ?>">Update</button>
              <button disabled class="btn btn-secondary" href="<?= url_to('productDiscontinue', $productData['id']) ?>">Discontinued</button>
              <button disabled type="button" class="btn btn-danger" id="deleteBtn">Delete</button>
            </div>
          </div>
        <?php endif; ?>
      <?php else: ?>
        <div class="row mt-3">
          <div class="col-md-12 text-center">
            <a class="btn btn-primary" href="<?= url_to('productUpdate', $productData['id']) ?>">Update</a>
            <a class="btn btn-secondary" href="<?= url_to('productDiscontinue', $productData['id']) ?>">Discontinued</a>
            <button type="button" class="btn btn-danger" id="deleteBtn">Delete</button>
          </div>
        </div>
      <?php endif; ?>
      <!-- ! -->

      <div id="deleteConfirmation" style="display: none;" class="mt-3">
        <form id="deleteForm" action="<?= url_to('productDelete',$productData['id']); ?>" method="POST">
          <div class="mb-3">
            <label for="deleteReason" class="form-label"><b>Please provide a reason for product deletion:</b></label>
            <textarea class="form-control" id="deleteReason" name="deleteReason" placeholder="Enter reason here..." rows="3" required></textarea>
          </div>
          <div class="text-center">
            <button type="submit" class="btn btn-danger">Delete</button>
            <button type="button" class="btn btn-success" id="cancelDelete">Cancel</button>
          </div>
        </form>
      </div>
    </div>
  </div>

</div>
</div>


<script>
  document.addEventListener('DOMContentLoaded', function () {
    const deleteBtn = document.getElementById('deleteBtn');
    const deleteConfirmation = document.getElementById('deleteConfirmation');
    const cancelDelete = document.getElementById('cancelDelete');
    const deleteReason = document.getElementById('deleteReason');

    deleteBtn.addEventListener('click', function () {
      deleteBtn.style.display = 'none';
      deleteConfirmation.style.display = 'block';
      deleteReason.focus();
    });

    cancelDelete.addEventListener('click', function () {
      deleteConfirmation.style.display = 'none';
      deleteBtn.style.display = 'inline-block';
      deleteReason.value = ''; // Clear the textarea
    });
  });
</script>
<?= $this->endsection(); ?>