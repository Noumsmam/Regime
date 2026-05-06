<?php $this->extend('layout'); ?>

<?php $this->section('content'); ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h2>Inscription - Étape 1/2</h2>
            <p class="text-muted">Vos informations personnelles</p>

            <?php if (session()->has('errors')): ?>
                <div class="alert alert-danger">
                    <ul>
                        <?php foreach (session('errors') as $error): ?>
                            <li><?= $error ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form action="/register" method="POST">
                <?= csrf_field() ?>

                <div class="mb-3">
                    <label for="nom" class="form-label">Nom complet *</label>
                    <input type="text" class="form-control" id="nom" name="nom" 
                           value="<?= old('nom') ?>" required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email *</label>
                    <input type="email" class="form-control" id="email" name="email" 
                           value="<?= old('email') ?>" required>
                </div>

                <div class="mb-3">
                    <label for="genre" class="form-label">Genre *</label>
                    <select class="form-control" id="genre" name="genre" required>
                        <option value="">Sélectionnez votre genre</option>
                        <option value="M" <?= old('genre') === 'M' ? 'selected' : '' ?>>Homme</option>
                        <option value="F" <?= old('genre') === 'F' ? 'selected' : '' ?>>Femme</option>
                        <option value="Autre" <?= old('genre') === 'Autre' ? 'selected' : '' ?>>Autre</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Mot de passe *</label>
                    <input type="password" class="form-control" id="password" name="password" 
                           required minlength="6">
                    <small class="form-text text-muted">Minimum 6 caractères</small>
                </div>

                <div class="mb-3">
                    <label for="password_confirm" class="form-label">Confirmer le mot de passe *</label>
                    <input type="password" class="form-control" id="password_confirm" 
                           name="password_confirm" required minlength="6">
                </div>

                <button type="submit" class="btn btn-primary w-100">Continuer vers l'étape 2</button>
            </form>

            <p class="text-center mt-3">
                Vous avez déjà un compte ? <a href="/login">Se connecter</a>
            </p>
        </div>
    </div>
</div>

<?php $this->endSection(); ?>
