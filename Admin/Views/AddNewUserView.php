<?= $this->extend('layouts/app.php'); ?>
<?= $this->section('content') ?>

<!-- Page title -->
<div class="container-fluid p-4 mt-3">
    <h2>Add User</h2>
</div>
<!---->

<!-- Main Content -->
<form action="<?= url_to('saveUser') ?>" method="post">
    <?= csrf_field() ?>

    <!-- Company Registration No -->
    <div class="form-floating mb-3 w-100">
        <input type="text" class="form-control" name="comp_reg_no" placeholder="Company Register No"
            value="<?= old('comp_reg_no') ?>" required>
        <label for="comp_reg_no">Company Registration No</label>
    </div>
    <!---->

    <!-- Company Name -->
    <div class="form-floating mb-3 w-100">
        <input type="text" class="form-control" name="comp_name" placeholder="Company Name"
            value="<?= old('comp_name') ?>" required>
        <label for="comp_name">Company Name</label>
    </div>
    <!---->

    <!-- Name -->
    <div class="form-floating mb-3 w-100">
        <input type="text" class="form-control" id="floatingUsernameInput" name="username"
            inputmode="text" autocomplete="username" placeholder="<?= lang('Auth.username') ?>"
            value="<?= old('username') ?>" required>
        <label for="floatingUsernameInput">Name</label>
    </div>

    <!-- Email -->
    <div class="form-floating mb-3 w-100">
        <input type="email" class="form-control" id="floatingEmailInput" name="email"
            inputmode="email" autocomplete="email" placeholder="<?= lang('Auth.email') ?>"
            value="<?= old('email') ?>" required>
        <label for="floatingEmailInput">Staff Email</label>
    </div>

    <!-- Password -->
    <div class="form-floating mb-3 w-100">
        <input type="password" class="form-control" id="floatingPasswordInput" name="password"
            inputmode="text" autocomplete="new-password" placeholder="<?= lang('Auth.password') ?>"
            required>
        <label for="floatingPasswordInput"><?= lang('Auth.password') ?></label>
    </div>

    <!-- Password (Again) -->
    <div class="form-floating mb-3 w-100">
        <input type="password" class="form-control" id="floatingPasswordConfirmInput"
            name="password_confirm" inputmode="text" autocomplete="new-password"
            placeholder="<?= lang('Auth.passwordConfirm') ?>" required>
        <label for="floatingPasswordConfirmInput"><?= lang('Auth.passwordConfirm') ?></label>
    </div>


    <div class="d-grid gap-2 mt-4">
        <button type="submit" class="btn btn-primary btn-block">Save</button>
    </div>

    

</form>

<?= $this->endSection() ?>