<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<main class="auth-container">
    <section class="card-auth">
        <header style="margin-bottom: 30px;">
            <p style="text-transform: uppercase; letter-spacing: 0.1em; font-size: 11px; font-weight: 700; color: var(--accent); margin-bottom: 8px;">Rejoindre FitLife</p>
            <h1 style="font-family: 'Literata', serif; font-size: 28px; margin-bottom: 8px;">Inscription</h1>
            <p style="color: var(--muted); font-size: 14px;">Créez votre compte pour commencer votre transformation.</p>
        </header>

        <!-- Gestion des erreurs stylisée -->
        <?php if (session()->has('errors')): ?>
            <div style="background: rgba(231, 76, 60, 0.08); border: 1px solid rgba(231, 76, 60, 0.2); padding: 15px; border-radius: 12px; margin-bottom: 20px;">
                <ul style="padding-left: 20px; margin: 0; color: #e74c3c; font-size: 13px; font-weight: 600;">
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
                <input type="text" id="nom" name="nom" placeholder="Jean Dupont" value="<?= old('nom') ?>" required />
            </div>

            <div class="field">
                <label for="email">Adresse Email</label>
                <input type="email" id="email" name="email" placeholder="jean@exemple.com" value="<?= old('email') ?>" required />
            </div>

            <div class="field">
                <label for="genre">Genre</label>
                <select id="genre" name="genre" required>
                    <option value="" disabled selected>-- Choisir --</option>
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

            <button class="button button--primary" type="submit" style="margin-top: 10px; width: 100%;">
                Continuer vers l'étape 2
            </button>

            <div style="text-align: center; margin-top: 20px;">
                <a href="/login" style="text-decoration: none; color: var(--muted); font-size: 13px; font-weight: 600;">
                    J'ai déjà un compte ? <span style="color: var(--accent-strong);">Se connecter</span>
                </a>
            </div>
        </form>
    </section>
</main>

<?php $this->endSection(); ?>