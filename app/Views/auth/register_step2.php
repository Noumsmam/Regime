<?php $this->extend('layout'); ?>

<?php $this->section('content'); ?>

<link rel="stylesheet" href="/assets/css/app-theme.css">

<main class="page">
    <section class="card">
        <header class="card__header">
            <p class="card__eyebrow">Régime</p>
            <h1>Inscription (suite)</h1>
            <p class="card__subtitle">Complétez vos informations de santé.</p>
        </header>

        <?php if (session()->has('errors')): ?>
            <div style="color: #e74c3c; margin-bottom: 1rem; font-size: 0.9rem;">
                <ul style="padding-left: 1.5rem; margin: 0;">
                    <?php foreach (session('errors') as $error): ?>
                        <li><?= $error ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form class="form" action="/register/step2" method="POST">
            <?= csrf_field() ?>

            <div class="field">
                <label for="taille">Taille (cm)</label>
                <input type="number" id="taille" name="taille" placeholder="Ex: 170" step="0.01" min="0" value="<?= old('taille') ?>" required />
            </div>

            <div class="field">
                <label for="poids">Poids (kg)</label>
                <input type="number" id="poids" name="poids" placeholder="Ex: 75" step="0.01" min="0" value="<?= old('poids') ?>" required />
            </div>

            <div style="display: flex; gap: 10px; margin-top: 20px;">
                <a class="button" href="/register" style="background: #ccc; text-decoration: none; display: flex; align-items: center; justify-content: center; flex: 1;">Retour</a>
                <button class="button" type="submit" style="flex: 2;">Finaliser l'inscription</button>
            </div>

            <div class="form-footer">
                <a class="muted-link" href="/login">J'ai déjà un compte</a>
            </div>
        </form>
    </section>
</main>

<?php $this->endSection(); ?>