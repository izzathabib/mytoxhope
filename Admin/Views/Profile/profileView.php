<?= $this->extend('layouts/app.php'); ?>
<?= $this->section('content') ?>

<!-- Display username -->
<div class="container-fluid mt-5 p-2">
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

    <!-- Personal Information -->
    <div class="col-md-7">
        <div class="card h-100 w-100 shadow-sm">
          <div class="text-dark-primary p-3"><strong>Personal Information</strong></div>
          <div class="card-body">
          <!-- Alert message -->
          <?php if (session('personalInfo') !== null): ?>
            <div class="alert alert-success alert-dismissible fade show">
              <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
              <div><?= session('personalInfo') ?></div> 
            </div>
          <?php endif; ?>
          <!-- ! -->
            <?php foreach($userData as $data): ?>
            <form method="post" action="<?= url_to('saveEditProfile',$data->id) ?>">
              <div class="form-group">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" value="<?= $data->username ?>" name="username">
              </div>
              <div class="form-group">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" value="<?= $data->secret ?>" name="email">
              </div>
              <button type="submit" class="btn btn-primary">Save Changes</button>
              <a href="<?= site_url('dashboard'); ?>" class="btn btn-secondary" role="button">Cancel</a>
            </form>
            <?php endforeach; ?>
          </div>
        </div>
    </div>
    <!--! -->

    <!-- Password -->
    <div class="col-md-5">
        <div class="card h-100 w-100 shadow-sm">
          <div class="text-dark-primary p-3"><strong>Password</strong></div>
          <div class="card-body">
          <!-- Alert message -->
          <?php if (session('password') !== null): ?>
            <div class="alert alert-success alert-dismissible fade show">
              <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
              <div><?= session('password') ?></div> 
            </div>
          <?php endif; ?> 
          <!--! -->
          <form method="post" action="<?= url_to('updatePassword') ?>" class="needs-validation">
              <div class="form-group">
                  <label for="current_password">Current Password</label>
                  <input type="password" class="form-control <?php if (session('currentPass') !== null):?> is-invalid <?php endif; ?>" id="current_password" name="current_password" required>
                  <?php if (session('currentPass') !== null): ?>
                  <div class="invalid-feedback">
                    <div><?= session('currentPass') ?></div>
                  </div>
                  <?php endif; ?>
              </div>
              <div class="form-group">
                  <label for="new_password">New Password</label>
                  <input type="password" class="form-control <?php if (session('errors') !== null):?> is-invalid <?php endif; ?>" id="new_password" name="new_password" required>
                  <?php if (session('errors') !== null): ?>
                    <div class="invalid-feedback" role="alert">
                        <?php if (is_array(session('errors'))): ?>
                            <?php foreach (session('errors') as $error): ?>
                                <?= $error ?>
                                <br>
                            <?php endforeach ?>
                        <?php else: ?>
                            <?= session('errors') ?>
                        <?php endif ?>
                    </div>
                  <?php endif ?>
              </div>
              <div class="form-group">
                  <label for="confirm_password">Confirm New Password</label>
                  <input type="password" class="form-control <?php if (session('matchPass') !== null):?> is-invalid <?php endif; ?>" id="confirm_password" name="confirm_password" required>
                  <?php if (session('matchPass') !== null): ?>
                  <div class="invalid-feedback">
                    <div><?= session('matchPass') ?></div>
                  </div>
                  <?php endif; ?>
              </div>
              <button type="submit" class="btn btn-primary">Update Password</button>
          </form>

          </div>
        </div>
    </div>
    <!-- ! -->

  </div>
</div>

<?= $this->endSection() ?>
