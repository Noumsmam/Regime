<?php echo $this->extend('layout'); ?>
<?php echo $this->section('content'); ?>

<div class="auth-container"> <!-- Utilisation du container centré pour plus de focus -->
    <div class="card-auth"> <!-- Style de carte unifié avec des ombres douces -->
        <header style="margin-bottom: 30px;">
            <p style="text-transform: uppercase; letter-spacing: 0.1em; font-size: 11px; font-weight: 700; color: var(--accent); margin-bottom: 8px;">Administration</p>
            <h1 style="font-family: 'Literata', serif; font-size: 26px; margin-bottom: 8px;">Nouvelle activité</h1>
            <p style="color: var(--muted); font-size: 14px;">Ajoutez un exercice au catalogue pour le calcul des calories.</p>
        </header>

        <!-- Notification d'erreur -->
        <?php if (session()->getFlashdata('error')): ?>
            <div style="padding: 12px 16px; background: rgba(231, 76, 60, 0.08); color: #e74c3c; border-radius: 12px; border: 1px solid rgba(231, 76, 60, 0.2); margin-bottom: 20px; font-size: 13px; font-weight: 600;">
                ⚠️ <?= session()->getFlashdata('error'); ?>
            </div>
        <?php endif; ?>

        <form method="post" action="/activities/store" class="form">
            <?= csrf_field(); ?>

            <div class="field">
                <label for="name">Nom de l'activité *</label>
                <input type="text" id="name" name="name" placeholder="Ex: Course à pied, Yoga..." required value="<?= old('name'); ?>">
            </div>

            <div class="field">
                <label for="calories_burn_per_hour">Calories brûlées par heure *</label>
                <input type="number" id="calories_burn_per_hour" name="calories_burn_per_hour" min="1" placeholder="Ex: 450" required value="<?= old('calories_burn_per_hour'); ?>">
            </div>

            <div class="field">
                <label for="intensity">Intensité *</label>
                <select id="intensity" name="intensity" required>
                    <option value="" disabled <?= empty(old('intensity')) ? 'selected' : ''; ?>>-- Sélectionner l'effort --</option>
                    <option value="low" <?= old('intensity') === 'low' ? 'selected' : ''; ?>>Faible (Endurance fondamentale)</option>
                    <option value="medium" <?= old('intensity') === 'medium' ? 'selected' : ''; ?>>Moyenne (Effort soutenu)</option>
                    <option value="high" <?= old('intensity') === 'high' ? 'selected' : ''; ?>>Élevée (Haute intensité / HIIT)</option>
                </select>
            </div>

            <!-- Actions du formulaire alignées -->
            <div style="display: flex; gap: 12px; margin-top: 20px;">
                <a href="/activities" class="button button--ghost" style="flex: 1; text-align: center;">Annuler</a>
                <button type="submit" class="button button--primary" style="flex: 2;">Créer l'activité</button>
            </div>
        </form>

        <div style="margin-top: 25px; padding-top: 20px; border-top: 1px solid var(--border); text-align: center;">
            <p style="font-size: 12px; color: var(--muted); font-style: italic;">
                * Les champs marqués d'une astérisque sont obligatoires.
            </p>
        </div>
    </div>
</div>

<?php echo $this->endSection(); ?>