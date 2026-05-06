<?php $this->extend('layout'); ?>

<?php $this->section('content'); ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h2>Inscription - Étape 2/2</h2>
            <p class="text-muted">Vos informations de santé</p>

            <?php if (session()->has('errors')): ?>
                <div class="alert alert-danger">
                    <ul>
                        <?php foreach (session('errors') as $error): ?>
                            <li><?= $error ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form action="/register/step2" method="POST">
                <?= csrf_field() ?>

                <div class="alert alert-info">
                    <strong>Rappel :</strong> Ces informations sont utilisées pour calculer votre IMC 
                    et vous proposer les régimes adaptés.
                </div>

                <div class="mb-3">
                    <label for="taille" class="form-label">Taille (cm) *</label>
                    <input type="number" class="form-control" id="taille" name="taille" 
                           step="0.01" min="0" value="<?= old('taille') ?>" required>
                    <small class="form-text text-muted">Exemple: 170</small>
                </div>

                <div class="mb-3">
                    <label for="poids" class="form-label">Poids (kg) *</label>
                    <input type="number" class="form-control" id="poids" name="poids" 
                           step="0.01" min="0" value="<?= old('poids') ?>" required>
                    <small class="form-text text-muted">Exemple: 75</small>
                </div>

                <button type="submit" class="btn btn-success w-100">
                    Finaliser l'inscription
                </button>
            </form>

            <p class="text-center mt-3">
                <a href="/register">Retour à l'étape 1</a>
            </p>
        </div>
    </div>
</div>

<?php $this->endSection(); ?>
