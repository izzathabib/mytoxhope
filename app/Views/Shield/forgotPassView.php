<?= $this->extend('layouts/app.php'); ?>
<?= $this->section('bodyClass') ?>forgot-page<?= $this->endSection() ?>
<?= $this->section('content') ?>

<div class="forgot-container d-flex align-items-center justify-content-center min-vh-100">
    <div class="card w-100 shadow-sm forgot-card" style="max-width: 400px;">
        <div class="card-body">
            <h4 class="card-title text-center mb-3">Forgot password?</h4>

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
                <div class="form-floating mb-3">
                    <input type="email" class="form-control" id="floatingEmailInput" name="email" autocomplete="email" placeholder="<?= lang('Auth.email') ?>"
                           value="<?= old('email', auth()->user()->email ?? null) ?>" required>
                    <label for="floatingEmailInput"><?= lang('Auth.email') ?></label>
                </div>

                <div class="d-grid col-12 mx-auto mt-4 mb-3">
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
    .forgot-page {
        overflow: hidden;
        background-color: #f8f9fa;
    }
    .forgot-container {
        padding: 20px;
    }
    .forgot-card {
        transform: translateY(-15%);
        margin-bottom: 160px;
    }

    @media (max-height: 600px), (max-width: 450px) {
        .forgot-page {
            overflow-y: auto;
        }
        .forgot-container {
            padding: 30px 20px 80px;
            align-items: flex-start;
        }
        .forgot-card {
            transform: none;
            margin-bottom: 6rem;
        }
    }
</style>
<?= $this->endSection() ?>
