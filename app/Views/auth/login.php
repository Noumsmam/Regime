<?php $this->extend('layout'); ?>

<?php $this->section('content'); ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <h2>Connexion</h2>

            <?php if (session()->has('error')): ?>
                <div class="alert alert-danger">
                    <?= session('error') ?>
                </div>
            <?php endif; ?>

            <?php if (session()->has('success')): ?>
                <div class="alert alert-success">
                    <?= session('success') ?>
                </div>
            <?php endif; ?>

            <?php if (session()->has('errors')): ?>
                <div class="alert alert-danger">
                    <ul>
                        <?php foreach (session('errors') as $error): ?>
                            <li><?= $error ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form action="/login" method="POST">
                <?= csrf_field() ?>

                <div class="mb-3">
                    <label for="email" class="form-label">Email*</label>
                    <input type="email" class="form-control" id="email" name="email" 
                           value="<?= old('email') ?>" required autofocus>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Mot de passe *</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>

                <button type="submit" class="btn btn-primary w-100">
                    Se connecter
                </button>
            </form>

            <hr>

            <p class="text-center">
                Vous n'avez pas de compte ? <a href="/register">S'inscrire</a>
            </p>
        </div>
    </div>
</div>

<?php $this->endSection(); ?>
