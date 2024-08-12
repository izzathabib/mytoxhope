<?= $this->extend('layouts/app.php'); ?>
<?= $this->section('content'); ?>

<div class="container-fluid p-5">
<h3 class="text-left"><b><?= esc($title) ?></b></h3>

<div class="card w-100 shadow-sm">
  <div class="card-body">
  <?php foreach($productData as $data): ?>
    <!-- Status text -->
    <div class="row mb-5 text-danger">
      <div class="col-md-12 text-center">
        <h2><?= $data->prod_status ?></h2>
      </div>
    </div>

    <!-- Main Product detail -->
    <div class="row">
      <!-- Product Image -->
      <div class="col-md-6">
        <img src="images/product/<?= $data->product_image ?>" alt="Image" class="img-fluid">
      </div>

      <!-- Product Detail -->
      <div class="col-md-6">
      <div class="">
          <h2><?= $data->product_name; ?></h2>
          <br>
          <h6>Product Name</h6>
          <p><?= $data->product_name; ?></p>

          <h6>Brand Name</h6>
          <p><?= $data->brand_name; ?></p>

          <h6>Type of Poison</h6>
          <p><?= $data->type_poison; ?></p>

          <h6>Subtype of Household / Consumer Product</h6>
          <p><?= $data->subtype_household; ?></p>

          <h6>Active Ingredient(s)</h6>
          <p><?= $data->active_ing; ?></p>

          <h6>Inactive Ingredient(s)</h6>
          <p><?= $data->inactive_ing; ?></p>

          <h6>Product MSDS</h6>
          <p><?= $data->msds; ?></p>

          <h6>Last Update</h6>
          <p><?= date('d-m-Y', strtotime($data->updated_at)); ?></p>
          
          <?php if ($data->prod_status=='To Be Deleted'): ?>
            <h6>Reason to Delete</h6>
            <p class="text-danger"><?= $data->reason_deletion; ?></p>
          <?php endif; ?>
      </div>
      </div>
    </div>
    
    <?php if ($data->prod_status=='Discontinued'): ?>
      <!-- Button -->
      <?php if (auth()->user()->inGroup('user')): ?>
        <?php if ($data->user_id == auth()->user()->id): ?>
          <div class="row mt-3">
            <div class="col-md-12 text-center">
              <button type="button" class="btn btn-danger" id="deleteBtn">Delete</button>
            </div>
          </div>
        <?php else: ?>
          <div class="row mt-3">
            <div class="col-md-12 text-center">
              <button disabled type="button" class="btn btn-danger" id="deleteBtn">Delete</button>
            </div>
          </div>
        <?php endif; ?>
      <?php else: ?>
        <div class="row mt-3">
          <div class="col-md-12 text-center">
            <button type="button" class="btn btn-danger" id="deleteBtn">Delete</button>
          </div>
        </div>
      <?php endif; ?>
      <!-- ! -->
    <?php endif; ?>
    
    <!-- Form to submit reasons for deletion -->
    <div id="deleteConfirmation" style="display: none;" class="mt-3">
        <form id="deleteForm" action="<?= url_to('productDelete',$data->id); ?>" method="POST">
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
    <!-- end -->
    <?php endforeach; ?>
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
