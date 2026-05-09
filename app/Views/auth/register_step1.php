<?php $this->extend('layout'); ?>

<?php $this->section('content'); ?>

<link rel="stylesheet" href="/assets/css/app-theme.css">

<main class="page">
    <section class="card">
        <header class="card__header">
            <p class="card__eyebrow">Régime</p>
            <h1>Inscription</h1>
            <p class="card__subtitle">Créez votre compte en quelques secondes.</p>
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

        <form class="form" action="/register" method="POST">
            <?= csrf_field() ?>

            <div class="field">
                <label for="nom">Nom complet</label>
                <input type="text" id="nom" name="nom" placeholder="Votre nom" value="<?= old('nom') ?>" required />
            </div>

            <div class="field">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="vous@email.com" value="<?= old('email') ?>" required />
            </div>

            <div class="field">
                <label for="genre">Genre</label>
                <select id="genre" name="genre" required>
                    <option value="">-- Sélectionnez --</option>
                    <option value="M" <?= old('genre') === 'M' ? 'selected' : '' ?>>Homme</option>
                    <option value="F" <?= old('genre') === 'F' ? 'selected' : '' ?>>Femme</option>
                    <option value="Autre" <?= old('genre') === 'Autre' ? 'selected' : '' ?>>Autre</option>
                </select>
            </div>

            <div class="field">
                <label for="password">Mot de passe</label>
                <input type="password" id="password" name="password" placeholder="••••••••" required />
            </div>

            <div class="field">
                <label for="password_confirm">Confirmer le mot de passe</label>
                <input type="password" id="password_confirm" name="password_confirm" placeholder="••••••••" required />
            </div>

            <button class="button" type="submit">Continuer vers l'étape 2</button>

            <div class="form-footer">
                <a class="muted-link" href="/login">J'ai déjà un compte</a>
            </div>
        </form>
    </section>
</main>

<?php $this->endSection(); ?>