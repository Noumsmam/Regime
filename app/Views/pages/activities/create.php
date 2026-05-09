<?php echo $this->extend('layout'); ?>
<?php echo $this->section('content'); ?>

<div class="page">
    <div class="card">
        <div class="card__header">
            <p class="card__eyebrow">Administration</p>
            <h1>Nouvelle activité</h1>
            <p class="card__subtitle">Ajoutez un nouvel exercice au catalogue pour permettre aux utilisateurs de calculer leurs dépenses caloriques.</p>
        </div>

        <?php if (session()->getFlashdata('error')): ?>
            <div style="padding: 12px 16px; background: rgba(231, 76, 60, 0.1); color: #e74c3c; border-radius: 12px; border: 1px solid rgba(231, 76, 60, 0.2); margin-bottom: 20px; font-size: 14px; font-weight: 600;">
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

            <div class="form-actions">
                <a href="/activities" class="button button--ghost" style="text-decoration: none; text-align: center;">Annuler</a>
                <button type="submit" class="button">Créer l'activité</button>
            </div>
        </form>

        <div class="form-footer">
            <p style="font-size: 13px; color: var(--muted);">* Les champs marqués d'une astérisque sont obligatoires.</p>
        </div>
    </div>
</div>

<?php echo $this->endSection(); ?>