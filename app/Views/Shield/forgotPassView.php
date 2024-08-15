<?= $this->extend('layouts/app.php'); ?>
<?= $this->section('bodyClass') ?>login-page<?= $this->endSection() ?>
<?= $this->section('content') ?>

<div class="container d-flex justify-content-center p-5">
    <div class="card col-12 col-md-5 shadow-sm">
        <div class="card-body">
            <h5 class="card-title mb-5">Forgot password?</h5>

                <?php if (session('error') !== null) : ?>
                    <div class="alert alert-danger" role="alert"><?= session('error') ?></div>
                <?php elseif (session('errors') !== null) : ?>
                    <div class="alert alert-danger" role="alert">
                        <?php if (is_array(session('errors'))) : ?>
                            <?php foreach (session('errors') as $error) : ?>
                                <?= $error ?>
                                <br>
                            <?php endforeach ?>
                        <?php else : ?>
                            <?= session('errors') ?>
                        <?php endif ?>
                    </div>
                <?php endif ?>

            <form action="<?= url_to('sentPasscode') ?>" method="post">
                <?= csrf_field() ?>

                <!-- Email -->
                <div class="form-floating mb-2">
                    <input type="email" class="form-control" id="floatingEmailInput" name="email" autocomplete="email" placeholder="<?= lang('Auth.email') ?>"
                           value="<?= old('email', auth()->user()->email ?? null) ?>" required>
                    <label for="floatingEmailInput"><?= lang('Auth.email') ?></label>
                </div>

                <div class="d-grid col-12 col-md-8 mx-auto m-3">
                    <button type="submit" class="btn btn-primary btn-block">Reset password</button>
                </div>

            </form>

            <p class="text-center"><a href="<?= url_to('login') ?>" style="text-decoration: none;"><?= lang('Auth.backToLogin') ?></a></p>
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
