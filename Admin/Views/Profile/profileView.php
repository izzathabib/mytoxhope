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

          </div>
        </div>
    </div>
    <!-- ! -->

  </div>
</div>

<?= $this->endSection() ?>