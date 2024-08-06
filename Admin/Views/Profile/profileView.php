<?= $this->extend('layouts/app.php'); ?>
<?= $this->section('content') ?>

<!-- Display username -->
<div class="container-fluid p-4">
  <h3><?= esc(auth()->user()->username); ?></h3>
</div>
<!---->

<div class="container-fluid">
  <div class="row">

    <!-- Personal Information -->
    <div class="col-md-7">
        <div class="card h-100 w-100 shadow-sm">
          <div class="card-header">Personal Information</div>
          <div class="card-body">
          <!-- Alert message -->
          <?php if (session('personalInfo') !== null): ?>
            <div class="alert alert-success alert-dismissible fade show">
              <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
              <div><?= session('personalInfo') ?></div> 
            </div>
          <?php elseif (session('password') !== null): ?>
            <div class="alert alert-success alert-dismissible fade show">
              <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
              <div><?= session('password') ?></div> 
            </div>
          <?php endif; ?>
          <!-- ! -->
            <?php foreach($userData as $data): ?>
            <form method="post" action="<?= url_to('saveEditProfile',$data->id) ?>">
              <div class="mb-3 mt-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" value="<?= $data->username ?>" name="username">
              </div>
              <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" value="<?= $data->secret ?>" name="email">
              </div>
              <button type="submit" class="btn btn-primary btn-sm">Save Changes</button>
              <a href="<?= site_url('dashboard'); ?>" class="btn btn-secondary btn-sm">Cancel</a>
            </form>
            <?php endforeach; ?>
          </div>
        </div>
    </div>
    <!--! -->

    <!-- Password -->
    <div class="col-md-5">
        <div class="card h-100 w-100 shadow-sm">
          <div class="card-header">Password</div>
          <div class="card-body">

          <form method="post" action="<?= url_to('updatePassword') ?>">
              <div class="form-group">
                  <label for="current_password">Current Password</label>
                  <input type="password" class="form-control" id="current_password" name="current_password" required>
              </div>
              <div class="form-group">
                  <label for="new_password">New Password</label>
                  <input type="password" class="form-control" id="new_password" name="new_password" required>
              </div>
              <div class="form-group">
                  <label for="confirm_password">Confirm New Password</label>
                  <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
              </div>
              <button type="submit" class="btn btn-primary">Update Password</button>
          </form>

          </div>
        </div>
    </div>
    <!-- ! -->

  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<?= $this->endSection() ?>
