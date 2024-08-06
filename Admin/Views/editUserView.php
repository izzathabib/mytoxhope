<?= $this->extend('layouts/app.php'); ?>
<?= $this->section('bodyClass') ?>new-user-page<?= $this->endSection() ?>
<?= $this->section('content') ?>

<div class="mt-5">
<div class="new-user-container">
  <div class="row justify-content-center">
    <div class="col-12 col-md-10 col-lg-8">
      <div class="card shadow-sm">
        <div class="card-header">
          <h3 class="text-center"><i class="fa fa-pen-to-square "></i> Edit User</h3>
        </div>
        <div class="card-body">
          <!-- Main Content -->
          <?php foreach($userData as $data): ?>
          <form action="<?= url_to('saveEditUser',$data->id) ?>" method="post">
            <?= csrf_field() ?>
            
            <!-- Company Registration No -->
            <div class="form-floating mb-3 w-100">
            <input type="text" class="form-control" name="comp_reg_no" id="comp_reg_no" 
              value="<?= $data->comp_reg_no ?>" required disabled>
            <input type="hidden" class="form-control" name="comp_reg_no" id="comp_reg_no" 
            value="<?= $data->comp_reg_no ?>" required> 
            </div>
            <!-- -->

            <!-- Company Name -->
            <div class="form-floating mb-3 w-100">
              <input type="text" class="form-control" name="comp_name" 
                value="<?= $data->comp_name ?>" required disabled>
              <input type="hidden" class="form-control" name="comp_name" 
              value="<?= $data->comp_name ?>" required>
            </div>
            <!---->

            <!-- Name -->
            <div class="form-floating mb-3 w-100">
              <input type="text" class="form-control" id="floatingUsernameInput" name="username" inputmode="text"
                autocomplete="username" placeholder="<?= lang('Auth.username') ?>" value="<?= isset($data) && $data->username ? $data->username : old('username') ?>"
                required>
              <label for="floatingUsernameInput">Name</label>
            </div>

            <!-- Email -->
            <div class="form-floating mb-3 w-100">
              <input type="email" class="form-control" id="floatingEmailInput" name="email" inputmode="email"
                autocomplete="email" placeholder="<?= lang('Auth.email') ?>" value="<?= isset($data) && $data->secret ? $data->secret : old('email') ?>" required>
              <label for="floatingEmailInput">Email</label>
            </div>

            <!-- Role -->
            <div class="form-floating mb-3 w-100">
            <select id="role" name="role" class="form-select" required>
              <!--<option value="Please select">Select Role</option>-->
              <?php if (auth()->user()->inGroup('superadmin')): ?>
                <option value="superadmin" <?= isset($data->group) && $data->group == 'superadmin' ? 'selected' : '' ?>>Admin PRN</option>
              <?php endif; ?>
              <option value="admin" <?= isset($data->group) && $data->group == 'admin' ? 'selected' : '' ?>>Admin Company</option>
              <option value="user" <?= isset($data->group) && $data->group == 'user' ? 'selected' : '' ?>>Staff Company</option>
            </select>
            </div>

            <div class="d-grid gap-2 mt-4">
              <button type="submit" class="btn btn-primary btn-block">Save</button>
              <a href="<?= site_url('Admin/users'); ?>" class="btn btn-secondary">Cancel</a>
            </div>


            <?php endforeach; ?>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
</div>

<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<style>
  .new-user-page {
    background-color: #f8f9fa;
  }

  .new-user-container {
    padding: 20px;
    width: 100%;
    max-width: 1200px;
    margin: auto;
  }

  .new-user-card {
    width: 100%;
    max-width: 800px;
    margin: auto;
  }

  .card {
    width: 100%;
  }

  .card-body {
    padding: 2rem;
  }

  .form-floating {
    margin-bottom: 1rem;
  }

  .form-control {
    height: calc(3.5rem + 2px);
    line-height: 1.25;
  }

  .form-floating label {
    padding: 1rem 0.75rem;
  }

  .btn-lg {
    padding: 0.75rem 1rem;
    font-size: 1rem;
  }

  @media (max-width: 768px) {
    .new-user-card {
      max-width: 100%;
    }

    .card-body {
      padding: 1.5rem;
    }
  }
</style>
<?= $this->endSection() ?>