<?php $this->extend('layout'); ?>

<?php $this->section('content'); ?>

<main class="auth-container">
    <section class="card-auth">
        <header style="margin-bottom: 30px;">
            <p style="text-transform: uppercase; letter-spacing: 0.1em; font-size: 11px; font-weight: 700; color: var(--accent); margin-bottom: 8px;">Étape 2 sur 2</p>
            <h1 style="font-family: 'Literata', serif; font-size: 28px; margin-bottom: 8px;">Détails de santé</h1>
            <p style="color: var(--muted); font-size: 14px;">Ces informations nous permettent de calculer votre IMC.</p>
        </header>

        <!-- Messages d'erreurs stylisés -->
        <?php if (session()->has('errors')): ?>
            <div style="background: rgba(231, 76, 60, 0.08); border: 1px solid rgba(231, 76, 60, 0.2); padding: 15px; border-radius: 12px; margin-bottom: 20px;">
                <ul style="padding-left: 20px; margin: 0; color: #e74c3c; font-size: 13px; font-weight: 600; list-style-type: none;">
                    <?php foreach (session('errors') as $error): ?>
                        <li>⚠️ <?= $error ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form class="form" action="/register/step2" method="POST">
            <?= csrf_field() ?>

            <div class="field">
                <label for="taille">Taille (cm)</label>
                <input type="number" id="taille" name="taille" placeholder="Ex: 175" step="1" min="50" max="250" value="<?= old('taille') ?>" required />
            </div>

            <div class="field" style="margin-bottom: 10px;">
                <label for="poids">Poids (kg)</label>
                <input type="number" id="poids" name="poids" placeholder="Ex: 70" step="0.1" min="20" max="300" value="<?= old('poids') ?>" required />
            </div>

            <!-- Groupe de boutons alignés sur le design du bundle -->
            <div style="display: flex; gap: 12px; margin-top: 10px;">
                <a href="/register" class="button button--ghost" style="flex: 1; text-align: center;">Retour</a>
                <button class="button button--primary" type="submit" style="flex: 2;">Finaliser l'inscription</button>
            </div>

            <div style="text-align: center; margin-top: 25px; border-top: 1px solid var(--border); padding-top: 20px;">
                <a href="/login" style="text-decoration: none; color: var(--muted); font-size: 13px; font-weight: 600;">
                    Annuler et revenir à la <span style="color: var(--accent-strong);">connexion</span>
                </a>
            </div>
        </form>
    </section>
</main>

<?php $this->endSection(); ?>