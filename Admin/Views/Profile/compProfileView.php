<?= $this->extend('layouts/app.php'); ?>
<?= $this->section('content') ?>

<!-- Display username -->
<div class="container-fluid p-4">
  <div class="row">
    <div class="col-1">
      <a role="button" class="btn btn-lg" href="<?= site_url('dashboard'); ?>"><i class="fas fa-arrow-left"></i></a>
    </div>
    <div class="col-2 text-nowrap">
      <h3><?= esc(auth()->user()->username); ?></h3>
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
          <?php if (session('personalInfo') !== null): ?>
            <div class="alert alert-success alert-dismissible fade show">
              <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
              <div><?= session('personalInfo') ?></div> 
            </div>
          <?php endif; ?>
          <!-- ! -->
            <?php //foreach($userData as $data): ?>
            <form method="post" action="<?= url_to('saveEditProfile',$data->id) ?>">
              <div class="form-group">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" value="" name="username">
              </div>
              <div class="form-group">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" value="" name="email">
              </div>
              <button type="submit" class="btn btn-primary">Save Changes</button>
              <a href="<?= site_url('dashboard'); ?>" class="btn btn-secondary" role="button">Cancel</a>
            </form>
            <?php //endforeach; ?>
          </div>
        </div>
    </div>
    <!--! -->
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<?= $this->endSection() ?>
