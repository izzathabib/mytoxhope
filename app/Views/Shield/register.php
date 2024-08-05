<?= $this->extend('layouts/app.php'); ?>

<?= $this->section('bodyClass') ?>register-page<?= $this->endSection() ?>

<?= $this->section('content') ?>

    <div class="register-container d-flex align-items-center justify-content-center min-vh-100">
            <div class="card shadow-sm register-container">
                <div class="card-body">
                    <h3 class="card-title text-center mb-3"><?= lang('Auth.register') ?></h3>
                    <p class="text-center">Enter details to register your account</p>

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

                    <form action="<?= url_to('register') ?>" method="post">
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
                            <label for="floatingEmailInput">Email</label>
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
                            <button type="submit"
                                class="btn btn-primary btn-block"><?= lang('Auth.register') ?></button>
                        </div>

                        <p class="text-center mt-2"><?= lang('Auth.haveAccount') ?> <a
                                href="<?= url_to('login') ?>" style="text-decoration: none;"><?= lang('Auth.login') ?></a></p>

                    </form>
                </div>
            </div>
    </div>

<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<style>
    .register-page {
        background-color: #f8f9fa;
    }
    .register-container {
        padding: 20px;
        width: 80%;
        margin: auto;
    }
    .register-card {
        width: 100%;
        max-width: 500px;
        margin: auto;
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
    @media (max-width: 576px) {
        .register-card {
            max-width: 100%;
        }
        .register-container {
            width: 95%;
            padding: 10px;
        }
        .card-body {
            padding: 1rem;
        }
    }
</style>
<?= $this->endSection() ?>