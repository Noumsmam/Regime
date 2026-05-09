<?php $this->extend('layout'); ?>

<?php $this->section('content'); ?>

<link rel="stylesheet" href="/assets/css/app-theme.css">

<main class="page">
    <section class="card">
        <header class="card__header">
            <p class="card__eyebrow">Régime</p>
            <h1>Connexion</h1>
            <p class="card__subtitle">Accédez à votre compte.</p>
        </header>

        <?php if (session()->has('error')): ?>
            <div style="color: #e74c3c; margin-bottom: 1rem; font-size: 0.9rem;">
                <?= session('error') ?>
            </div>
        <?php endif; ?>

        <?php if (session()->has('success')): ?>
            <div style="color: #27ae60; margin-bottom: 1rem; font-size: 0.9rem;">
                <?= session('success') ?>
            </div>
        <?php endif; ?>

        <?php if (session()->has('errors')): ?>
            <div style="color: #e74c3c; margin-bottom: 1rem; font-size: 0.9rem;">
                <ul style="padding-left: 1.5rem; margin: 0;">
                    <?php foreach (session('errors') as $error): ?>
                        <li><?= $error ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form class="form" action="/login" method="POST">
            <?= csrf_field() ?>

            <div class="field">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="vous@email.com" value="<?= old('email') ?>" required autofocus />
            </div>

            <div class="field">
                <label for="password">Mot de passe</label>
                <input type="password" id="password" name="password" placeholder="••••••••" required />
            </div>

            <button class="button" type="submit">Se connecter</button>

            <div class="form-footer">
                <p class="muted-link">
                    Vous n'avez pas de compte ? <a href="/register">S'inscrire</a>
                </p>
            </div>
        </form>
    </section>
</main>

<?php $this->endSection(); ?>