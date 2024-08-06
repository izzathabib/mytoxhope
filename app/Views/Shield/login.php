<?= $this->extend('layouts/app.php'); ?>

<?= $this->section('title') ?><?= lang('Auth.login') ?> <?= $this->endSection() ?>

<?= $this->section('bodyClass') ?>login-page<?= $this->endSection() ?>

<?= $this->section('content') ?>

        <div class="login-container d-flex align-items-center justify-content-center min-vh-100">
            <div class="card w-100 shadow-sm login-card" style="max-width: 400px;">
                <div class="card-body">
                    <h3 class="card-title text-center mb-3"><?= lang('Auth.login') ?></h3>
                    <p class="text-center">Enter your credentials to login</p>

                    <!-- Alert message section -->
                    <?php if (session('error') !== null): ?>
                        <div class="alert alert-danger" role="alert"><?= session('error') ?></div>
                    <?php elseif (session('success') !== null): ?>
                        <div class="alert alert-success" role="alert"><?= session('success') ?></div>
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
                    <?php elseif (session('password') !== null): ?>
                        <div class="alert alert-success" role="alert">
                            <div><i class="fas fa-check-circle"></i>  <?= session('password') ?></div>
                        </div>
                    <?php endif ?>

                    <?php if (session('message') !== null): ?>
                        <div class="alert alert-success" role="alert"><?= session('message') ?></div>
                    <?php endif ?>
                    <!-- .Alert message -->

                    <form action="<?= url_to('login') ?>" method="post">
                        <?= csrf_field() ?>

                        <!-- Email -->
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control" id="floatingEmailInput" name="email"
                                inputmode="email" autocomplete="email" placeholder="<?= lang('Auth.email') ?>"
                                value="<?= old('email') ?>" required>
                            <label for="floatingEmailInput"><?= lang('Auth.email') ?></label>
                        </div>

                        <!-- Password -->
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" id="floatingPasswordInput" name="password"
                                inputmode="text" autocomplete="current-password"
                                placeholder="<?= lang('Auth.password') ?>" required>
                            <label for="floatingPasswordInput"><?= lang('Auth.password') ?></label>
                        </div>

                        <!-- Remember me -->
                        <?php if (setting('Auth.sessionConfig')['allowRemembering']): ?>
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input type="checkbox" name="remember" class="form-check-input" <?php if (old('remember')): ?> checked<?php endif ?>>
                                    <?= lang('Auth.rememberMe') ?>
                                </label>
                            </div>
                        <?php endif; ?>

                        <!-- Login button -->
                        <div class="d-grid col-12 mx-auto mt-4 mb-3">
                            <button type="submit" class="btn btn-primary btn-block"><?= lang('Auth.login') ?></button>
                        </div>

                        <!-- Forgot password -->
                        <?php if (setting('Auth.allowMagicLinkLogins')): ?>
                            <p class="text-center"><?= lang('Auth.forgotPassword') ?> <a
                                    href="<?= url_to('magic-link') ?>" style="text-decoration: none;"><?= lang('Auth.useMagicLink') ?></a></p>
                        <?php endif ?>

                        <!-- Register account -->
                        <?php if (setting('Auth.allowRegistration')): ?>
                            <p class="text-center"><?= lang('Auth.needAccount') ?> <a
                                    href="<?= url_to('register') ?>" style="text-decoration: none;"><?= lang('Auth.register') ?></a></p>
                        <?php endif ?>

                    </form>
                </div>
            </div>
        </div>
<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<style>
    .login-page {
        overflow: hidden;
        background-color: #f8f9fa;
    }
    .login-container {
        padding: 20px;
    }
    .login-card {
        transform: translateY(-15%);
    }

    @media (max-height: 600px), (max-width: 450px) {
        .login-page {
            overflow-y: auto;
        }
        .login-container {
            padding: 30px 20px 80px;
            align-items: flex-start;
        }
        .login-card {
            transform: none;
            margin-bottom: 6rem;
        }
    }
</style>
<?= $this->endSection() ?>