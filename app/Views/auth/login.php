<?php $this->extend('layout'); ?>

<?php $this->section('content'); ?>

<div class="auth-container">
    <section class="card-auth">
        <header class="card__header">
            <p class="card__eyebrow">Régime & Santé</p>
            <h1>Connexion</h1>
            <p class="card__subtitle">Accédez à votre espace personnel FitLife.</p>
        </header>

        <!-- Gestion des messages d'alerte -->
        <?php if (session()->has('error')): ?>
            <div style="background: rgba(231, 76, 60, 0.1); color: #e74c3c; padding: 12px; border-radius: 10px; margin-bottom: 20px; font-size: 0.9rem; border: 1px solid rgba(231, 76, 60, 0.2);">
                <?= session('error') ?>
            </div>
        <?php endif; ?>

        <?php if (session()->has('success')): ?>
            <div style="background: rgba(39, 174, 96, 0.1); color: #27ae60; padding: 12px; border-radius: 10px; margin-bottom: 20px; font-size: 0.9rem; border: 1px solid rgba(39, 174, 96, 0.2);">
                <?= session('success') ?>
            </div>
        <?php endif; ?>

        <?php if (session()->has('errors')): ?>
            <div style="background: rgba(231, 76, 60, 0.1); color: #e74c3c; padding: 12px; border-radius: 10px; margin-bottom: 20px; font-size: 0.9rem; border: 1px solid rgba(231, 76, 60, 0.2);">
                <ul style="padding-left: 1rem; margin: 0; list-style-type: none;">
                    <?php foreach (session('errors') as $error): ?>
                        <li>⚠️ <?= $error ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form class="form" action="/login" method="POST">
            <?= csrf_field() ?>

            <div class="field">
                <label for="email">Adresse Email</label>
                <input type="email" id="email" name="email" placeholder="vous@email.com" value="<?= old('email') ?>" required autofocus />
            </div>

            <div class="field">
                <label for="password">Mot de passe</label>
                <input type="password" id="password" name="password" placeholder="••••••••" required />
            </div>

            <div class="form-actions">
                <button class="button button--primary" type="submit" style="width: 100%;">Se connecter</button>
            </div>

            <div class="form-footer" style="margin-top: 20px; text-align: center; border-top: 1px solid var(--border); padding-top: 20px;">
                <p style="font-size: 14px; color: var(--muted);">
                    Vous n'avez pas de compte ? 
                    <a href="/register" style="color: var(--accent-strong); font-weight: 700; text-decoration: none;">S'inscrire gratuitement</a>
                </p>
            </div>
        </form>
    </section>
</div>

<?php $this->endSection(); ?>