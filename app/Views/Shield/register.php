<?= $this->extend('layouts/app.php'); ?>

<?= $this->section('content') ?>

<div class="container-fluid position-relative vh-100">
    <div class="d-flex justify-content-center align-items-center h-100">
            <div class="card w-50 shadow-sm">
                <div class="card-body">
                    <h3 class="card-title text-center mb-3"><?= lang('Auth.register') ?></h3>
                    <p class="text-center">Enter details to register your account</p>
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
                    <form action="<?= url_to('register') ?>" method="post">
                        <?= csrf_field() ?>

                        <!-- Company Registration No -->
                        <div class="form-floating mb-2">
                            <input type="text" class="form-control" name="comp_reg_no" placeholder="Company Register No"
                                value="<?= old('comp_reg_no') ?>" required>
                            <label for="comp_reg_no">Company Registration No</label>
                        </div>
                        <!---->

                        <!-- Company Name -->
                        <div class="form-floating mb-2">
                            <input type="text" class="form-control" name="comp_name" placeholder="Company Name"
                                value="<?= old('comp_name') ?>" required>
                            <label for="comp_name">Company Name</label>
                        </div>
                        <!---->

                        <!-- Name -->
                        <div class="form-floating mb-4">
                            <input type="text" class="form-control" id="floatingUsernameInput" name="username"
                                inputmode="text" autocomplete="username" placeholder="<?= lang('Auth.username') ?>"
                                value="<?= old('username') ?>" required>
                            <label for="floatingUsernameInput">Name</label>
                        </div>

                        <!-- Email -->
                        <div class="form-floating mb-2">
                            <input type="email" class="form-control" id="floatingEmailInput" name="email"
                                inputmode="email" autocomplete="email" placeholder="<?= lang('Auth.email') ?>"
                                value="<?= old('email') ?>" required>
                            <label for="floatingEmailInput">Company Email</label>
                        </div>

                        <!-- Password -->
                        <div class="form-floating mb-2">
                            <input type="password" class="form-control" id="floatingPasswordInput" name="password"
                                inputmode="text" autocomplete="new-password" placeholder="<?= lang('Auth.password') ?>"
                                required>
                            <label for="floatingPasswordInput"><?= lang('Auth.password') ?></label>
                        </div>

                        <!-- Password (Again) -->
                        <div class="form-floating mb-5">
                            <input type="password" class="form-control" id="floatingPasswordConfirmInput"
                                name="password_confirm" inputmode="text" autocomplete="new-password"
                                placeholder="<?= lang('Auth.passwordConfirm') ?>" required>
                            <label for="floatingPasswordConfirmInput"><?= lang('Auth.passwordConfirm') ?></label>
                        </div>


                        <div class="d-grid col-12 mx-auto mt-4 mb-3">
                            <button type="submit"
                                class="btn btn-primary btn-block"><?= lang('Auth.register') ?></button>
                        </div>

                        <p class="text-center"><?= lang('Auth.haveAccount') ?> <a
                                href="<?= url_to('login') ?>" style="text-decoration: none;"><?= lang('Auth.login') ?></a></p>

                    </form>
                </div>
            </div>
    </div>
</div>

<?= $this->endSection() ?>