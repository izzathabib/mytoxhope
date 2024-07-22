<?= $this->extend('layouts/app.php'); ?>
<?= $this->section('bodyClass') ?>new-user-page<?= $this->endSection() ?>
<?= $this->section('content') ?>

<!-- Page title -->
<div class="new-user-container">
  <div class="row justify-content-center">
    <div class="col-12 col-md-10 col-lg-8">
      <div class="card shadow-sm">
        <div class="card-header">
          <h3 class="text-center"><i class="fa fa-plus-circle"></i> Add User</h3>
        </div>
        <div class="card-body">
          <!-- Main Content -->
          <form action="<?= url_to('saveUser') ?>" method="post">
            <?= csrf_field() ?>

            <!-- Company Registration No -->
            <!-- Dropdown input for superadmin -->
            <?php if (auth()->user()->inGroup('superadmin')): ?>
              <div class="form-group mb-4">
              <select id="type_poison" name="comp_reg_no" class="form-control">
                <option value="Please select">Company Registration No</option>
                <?php foreach($companyData as $data): ?>
                  <option value="<?= $data['comp_reg_no'] ?>"><?= $data['comp_reg_no'] ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <!-- Disabled input for company admin -->
            <?php else: ?>
              <div class="form-floating mb-3 w-100">
              <input type="text" class="form-control" name="comp_reg_no"
                value="<?= $companyData['comp_reg_no'] ?>" required disabled>
            </div>
            <?php endif; ?>
            <!-- -->

            <!-- Company Name -->
            <!-- Dropdown input for superadmin -->
            <?php if (auth()->user()->inGroup('superadmin')): ?>
              <div class="form-group mb-4">
              <select id="comp_name" name="comp_name" class="form-control">
                <option value="Please select">Company Name</option>
                <?php foreach($companyData as $data): ?>
                  <option value="<?= $data['comp_name'] ?>"><?= $data['comp_name'] ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <!-- Disabled input for company admin -->
            <?php else: ?>
              <div class="form-floating mb-3 w-100">
              <input type="text" class="form-control" name="comp_name" 
                value="<?= $companyData['comp_name'] ?>" required disabled>
            </div>
            <?php endif; ?>
            <!---->

            <!-- Name -->
            <div class="form-floating mb-3 w-100">
              <input type="text" class="form-control" id="floatingUsernameInput" name="username" inputmode="text"
                autocomplete="username" placeholder="<?= lang('Auth.username') ?>" value="<?= old('username') ?>"
                required>
              <label for="floatingUsernameInput">Name</label>
            </div>

            <!-- Email -->
            <div class="form-floating mb-3 w-100">
              <input type="email" class="form-control" id="floatingEmailInput" name="email" inputmode="email"
                autocomplete="email" placeholder="<?= lang('Auth.email') ?>" value="<?= old('email') ?>" required>
              <label for="floatingEmailInput">Email</label>
            </div>

            <!-- Password -->
            <div class="form-floating mb-3 w-100">
              <input type="password" class="form-control" id="floatingPasswordInput" name="password" inputmode="text"
                autocomplete="new-password" placeholder="<?= lang('Auth.password') ?>" required>
              <label for="floatingPasswordInput"><?= lang('Auth.password') ?></label>
            </div>

            <!-- Password (Again) -->
            <div class="form-floating mb-3 w-100">
              <input type="password" class="form-control" id="floatingPasswordConfirmInput" name="password_confirm"
                inputmode="text" autocomplete="new-password" placeholder="<?= lang('Auth.passwordConfirm') ?>" required>
              <label for="floatingPasswordConfirmInput"><?= lang('Auth.passwordConfirm') ?></label>
            </div>


            <div class="d-grid gap-2 mt-4">
              <button type="submit" class="btn btn-primary btn-block">Submit</button>
              <a href="<?= site_url('Admin/users'); ?>" class="btn btn-secondary">Cancel</a>
            </div>



          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<!---->



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