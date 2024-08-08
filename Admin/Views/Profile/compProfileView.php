<?= $this->extend('layouts/app.php'); ?>
<?= $this->section('content') ?>

<?php foreach($companyData as $data): ?>
<!-- Display username -->
<div class="container-fluid mt-5 p-3">
  <div class="row">
    <div class="col-1">
      <a role="button" class="btn btn-lg" href="<?= site_url('dashboard'); ?>"><i class="fas fa-arrow-left"></i></a>
    </div>
    <div class="col-2 text-nowrap">
      <h3><?= esc($data->comp_name); ?></h3>
    </div>
  </div>
</div>
<!---->

<div class="container-fluid">
  <div class="row">

    <!-- Company Information -->
    <div class="col-md-7">
        <div class="card h-100 w-100 shadow-sm">
          <div class="text-dark-primary p-3"><strong>Company Information</strong></div>
          <div class="card-body">
          <!-- Alert message -->
          <?php if (session('compInfo') !== null): ?>
            <div class="alert alert-success alert-dismissible fade show">
              <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
              <div><?= session('compInfo') ?></div> 
            </div>
          <?php endif; ?>
          <!-- ! -->
            <form method="post" action="<?= url_to('saveEditCompProfile',$data->comp_id) ?>">
              <div class="form-group">
                <label for="comp_name" class="form-label">Company Name</label>
                <input type="text" class="form-control" id="comp_name" value="<?= $data->comp_name ?>" name="comp_name">
              </div>
              <div class="form-group">
                <label for="comp_reg_no" class="form-label">Company Registration No</label>
                <input type="text" class="form-control" id="comp_reg_no" value="<?= $data->comp_reg_no ?>" name="comp_reg_no">
              </div>
              <button type="submit" class="btn btn-primary">Save Changes</button>
              <a href="<?= site_url('dashboard'); ?>" class="btn btn-secondary" role="button">Cancel</a>
            </form>
          </div>
        </div>
    </div>
    <!--! -->

    <!-- Change company main admin -->
    <div class="col-md-5">
        <div class="card  w-100 shadow-sm">
          <div class="text-dark-primary p-3"><strong>Company Main Administrator</strong></div>
          <div class="card-body">
          <!-- Alert message -->
          <?php if (session('adminChange') !== null): ?>
            <div class="alert alert-success alert-dismissible fade show">
              <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
              <div><i class="fas fa-check-circle"></i>  <?= session('adminChange') ?></div> 
            </div>
          <?php endif; ?>
          <!-- ! -->
            <form method="post" action="<?= url_to('saveMainAdminChanges',$data->comp_id) ?>">
              <div class="form-group">
              <select id="comp_admin" name="comp_admin" class="form-select" required>
                <?php foreach ($userData as $user): ?>
                  <option value="<?= $user->id ?>" <?php echo isset($data->comp_admin) && $data->comp_admin == $user->id ? 'selected' : '' ?> ><?= $user->username ?></option>
                <?php endforeach; ?>
              </select>
              </div>
              
              <button type="submit" class="btn btn-warning">Save Changes</button>
              <a href="<?= site_url('dashboard'); ?>" class="btn btn-secondary" role="button">Cancel</a>
            </form>
          </div>
        </div>
    </div>
    <!-- ! -->
  </div>
</div>
<?php endforeach; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<?= $this->endSection() ?>
