<?= $this->extend('layouts/app.php'); ?>
<?= $this->section('bodyClass') ?>new-user-page<?= $this->endSection() ?>
<?= $this->section('content') ?>

<div class="new-user-container mt-5">
  <div class="row justify-content-center">
    <div class="col-12 col-md-10 col-lg-8">
      <div class="card shadow-sm">
        <div class="card-header">
          <h3 class="text-center"><i class="fa fa-plus-circle"></i> Add User</h3>
        </div>
        <div class="card-body">

          <!-- Alert message section -->
          <?php if (session('error') !== null): ?>
            <div class="alert alert-danger" role="alert"><?= session('error') ?></div>
          <?php elseif (session('errors') !== null): ?>
            <div class="alert alert-danger" role="alert">
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
          <!-- .Alert message -->

          <!-- Main Content -->
          <form action="<?= url_to('saveUser') ?>" method="post">
            <?= csrf_field() ?>

            <!-- Role -->
            <div class="form-floating mb-3 w-100">
              <select id="role" name="role" class="form-select" required>
                <option value="">Select Role</option>
                <?php if (auth()->user()->inGroup('superadmin')): ?>
                  <option value="superadmin" data-role="admin-prn">Admin PRN</option>
                <?php endif; ?>
                <option value="admin" data-role="admin-company">Admin Company</option>
                <option value="user" data-role="staff-company">Staff Company</option>
              </select>
            </div>
            <!-- ! -->

            <!-- Company Name -->
            <!-- Dropdown input for superadmin -->
            <?php if (auth()->user()->inGroup('superadmin')): ?>
              <div class="form-floating mb-3 w-100">
                <select id="comp_name" name="comp_name" class="form-select" required>
                  <option value="Please select">Company Name</option>
                  <?php foreach ($companyData as $data): ?>
                    <option value="<?= $data['comp_name'] ?>" data-reg-no="<?= $data['comp_reg_no'] ?>"><?= $data['comp_name'] ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <!-- Disabled input for company admin -->
            <?php else: ?>
              <div class="form-floating mb-3 w-100">
                <input type="text" class="form-control" name="comp_name" value="<?= $companyData['comp_name'] ?>" required
                  disabled>
                <input type="hidden" class="form-control" name="comp_name" value="<?= $companyData['comp_name'] ?>"
                  required>
              </div>
            <?php endif; ?>
            <!---->

            <!-- Company Registration No -->
            <!-- Dropdown input for superadmin -->
            <?php if (auth()->user()->inGroup('superadmin')): ?>
              <div class="form-floating mb-3 w-100">
                <select id="comp_reg_no" name="comp_reg_no" class="form-select" required>
                  <option value="Please select">Company Registration No</option>
                  <?php foreach ($companyData as $data): ?>
                    <option value="<?= $data['comp_reg_no'] ?>"><?= $data['comp_reg_no'] ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <!-- Disabled input for company admin -->
            <?php else: ?>
              <div class="form-floating mb-3 w-100">
                <input type="text" class="form-control" name="comp_reg_no" id="comp_reg_no"
                  value="<?= $companyData['comp_reg_no'] ?>" required disabled>
                <input type="hidden" class="form-control" name="comp_reg_no" id="comp_reg_no"
                  value="<?= $companyData['comp_reg_no'] ?>" required>
              </div>
            <?php endif; ?>
            <!-- -->

            <!-- Name -->
            <div class="form-floating mb-3 w-100">
              <input type="text" class="form-control" id="floatingUsernameInput" name="username" inputmode="text"
                autocomplete="username" placeholder="<?= lang('Auth.username') ?>" value="<?= old('username') ?>"
                required>
              <label for="floatingUsernameInput">Name</label>
            </div>
            <!-- ! -->

            <!-- Email -->
            <div class="form-floating mb-3 w-100">
              <input type="email" class="form-control" id="floatingEmailInput" name="email" inputmode="email"
                autocomplete="email" placeholder="<?= lang('Auth.email') ?>" value="<?= old('email') ?>" required
                pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$">
              <label for="floatingEmailInput">Email</label>
              <div class="invalid-feedback">Please enter a valid email address.</div>
            </div>
            <!-- ! -->

            <!-- Submit button -->
            <div class="d-grid gap-2 mt-4">
              <button type="submit" class="btn btn-primary btn-block">Submit</button>
              <a href="<?= site_url('Admin/users'); ?>" class="btn btn-secondary">Cancel</a>
            </div>
            <!-- ! -->

          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const roleSelect = document.getElementById('role');
    const compRegNoSelect = document.getElementById('comp_reg_no');
    const compNameSelect = document.getElementById('comp_name');
    const emailInput = document.getElementById('floatingEmailInput');

    roleSelect.addEventListener('change', function () {
      const selectedOption = this.options[this.selectedIndex];

      if (selectedOption.getAttribute('data-role') === 'admin-prn') {
        // Autofill with the first option (excluding the placeholder)
        if (compRegNoSelect.options.length > 1) {
          compRegNoSelect.selectedIndex = 1;
        }
        if (compNameSelect.options.length > 1) {
          compNameSelect.selectedIndex = 1;
        }
      } else {
        // Reset to placeholder
        compRegNoSelect.selectedIndex = 0;
        compNameSelect.selectedIndex = 0;
      }
    });

    compNameSelect.addEventListener('change', function() {
    console.log('Company name changed:', this.value);
    const selectedRole = roleSelect.options[roleSelect.selectedIndex].getAttribute('data-role');
    console.log('Selected role:', selectedRole);

    if (selectedRole === 'admin-company' || selectedRole === 'staff-company') {
      const selectedOption = this.options[this.selectedIndex];
      const regNo = selectedOption.getAttribute('data-reg-no');
      console.log('Registration number from data attribute:', regNo);

      if (regNo) {
        compRegNoSelect.value = regNo;
        console.log('Set registration number to:', regNo);
      } else {
        console.log('No registration number found for selected company');
      }
    }
  });

    emailInput.addEventListener('input', function () {
      if (emailInput.validity.typeMismatch) {
        emailInput.setCustomValidity('Please enter a valid email address.');
      } else {
        emailInput.setCustomValidity('');
      }
    });

    document.querySelector('form').addEventListener('submit', function (event) {
      if (!emailInput.checkValidity()) {
        event.preventDefault();
        emailInput.classList.add('is-invalid');
      } else {
        emailInput.classList.remove('is-invalid');
      }
    });
  });
</script>

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