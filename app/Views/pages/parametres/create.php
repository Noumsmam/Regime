<?php echo $this->extend('layout'); ?>
<?php echo $this->section('content'); ?>

<div class="auth-container">
    <div class="card-auth">
        <header style="margin-bottom: 30px;">
            <p style="text-transform: uppercase; letter-spacing: 0.1em; font-size: 11px; font-weight: 700; color: var(--accent); margin-bottom: 8px;">Configuration Système</p>
            <h1 style="font-family: 'Literata', serif; font-size: 26px; margin-bottom: 8px;">Nouveau paramètre</h1>
            <p style="color: var(--muted); font-size: 14px;">Définissez une nouvelle variable globale pour l'application.</p>
        </header>

        <!-- Notification d'erreur -->
        <?php if (session()->getFlashdata('error')): ?>
            <div style="background: rgba(231, 76, 60, 0.08); border: 1px solid rgba(231, 76, 60, 0.2); padding: 15px; border-radius: 12px; color: #e74c3c; font-size: 13px; font-weight: 600; margin-bottom: 20px;">
                ⚠️ <?= session()->getFlashdata('error'); ?>
            </div>
        <?php endif; ?>

        <form method="post" action="/parametres/store" class="form">
            <?= csrf_field(); ?>

            <div class="field">
                <label for="nom">Clé du paramètre *</label>
                <input type="text" id="nom" name="nom" placeholder="Ex: TVA_REDUITE" required value="<?= old('nom'); ?>">
            </div>

            <div class="field">
                <label for="valeur">Valeur *</label>
                <input type="text" id="valeur" name="valeur" placeholder="Ex: 5.5" required value="<?= old('valeur'); ?>">
            </div>

            <div class="field">
                <label for="categorie">Catégorie</label>
                <input type="text" id="categorie" name="categorie" placeholder="Ex: Facturation" value="<?= old('categorie'); ?>">
            </div>

            <div class="field">
                <label for="description">Description</label>
                <textarea id="description" name="description" rows="3" placeholder="À quoi sert ce paramètre ?"><?= old('description'); ?></textarea>
            </div>

            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 25px; padding-left: 5px;">
                <input type="checkbox" id="is_active" name="is_active" value="1" <?= old('is_active', 1) ? 'checked' : ''; ?> style="width: 18px; height: 18px; accent-color: var(--accent);">
                <label for="is_active" style="font-size: 14px; font-weight: 600; color: var(--ink); cursor: pointer;">Paramètre actif</label>
            </div>

            <!-- Boutons d'action -->
            <div style="display: flex; gap: 12px;">
                <a href="/parametres" class="button button--ghost" style="flex: 1; text-align: center; text-decoration: none;">Annuler</a>
                <button type="submit" class="button button--primary" style="flex: 2;">Créer le paramètre</button>
            </div>
        </form>

        <div style="margin-top: 25px; padding-top: 20px; border-top: 1px solid var(--border); text-align: center;">
            <p style="font-size: 12px; color: var(--muted); font-style: italic;">
                * Les clés de paramètres doivent être uniques.
            </p>
        </div>
    </div>
</div>

<?php echo $this->endSection(); ?>