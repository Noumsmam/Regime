<?php echo $this->extend('layout'); ?>

<?php echo $this->section('content'); ?>
<div class="auth-container">
    <div class="card-auth">
        <header style="margin-bottom: 30px;">
            <p style="text-transform: uppercase; letter-spacing: 0.1em; font-size: 11px; font-weight: 700; color: var(--accent); margin-bottom: 8px;">Administration</p>
            <h1 style="font-family: 'Literata', serif; font-size: 26px; margin-bottom: 8px;">Modifier l'activité</h1>
            <p style="color: var(--muted); font-size: 14px;">Mettez à jour les paramètres de l'exercice pour la base de données.</p>
        </header>

        <?php 
            $activityName = (string) ($activity['name'] ?? '');
            $activityId = (int) ($activity['id'] ?? 0);
            $caloriesBurnPerHour = (int) ($activity['calories_burn_per_hour'] ?? 0);
            $intensity = (string) ($activity['intensity'] ?? 'medium');
        ?>

        <!-- Alerte d'erreur stylisée -->
        <?php if (session()->getFlashdata('error')): ?>
            <div style="padding: 12px 16px; background: rgba(231, 76, 60, 0.08); color: #e74c3c; border-radius: 12px; border: 1px solid rgba(231, 76, 60, 0.2); margin-bottom: 20px; font-size: 13px; font-weight: 600;">
                ⚠️ <?= session()->getFlashdata('error'); ?>
            </div>
        <?php endif; ?>

        <form method="post" action="/activities/<?= $activityId; ?>/update" class="form">
            <?= csrf_field(); ?>

            <div class="field">
                <label for="name">Nom de l'activité *</label>
                <input type="text" id="name" name="name" placeholder="Ex: Course à pied..." required value="<?= old('name', $activityName); ?>">
            </div>

            <div class="field">
                <label for="calories_burn_per_hour">Calories brûlées par heure *</label>
                <input type="number" id="calories_burn_per_hour" name="calories_burn_per_hour" min="1" placeholder="Ex: 450" required value="<?= old('calories_burn_per_hour', (string) $caloriesBurnPerHour); ?>">
            </div>

            <div class="field">
                <label for="intensity">Intensité *</label>
                <select id="intensity" name="intensity" required>
                    <option value="" disabled>-- Sélectionner --</option>
                    <option value="low" <?= old('intensity', $intensity) === 'low' ? 'selected' : ''; ?>>Faible (Endurance fondamentale)</option>
                    <option value="medium" <?= old('intensity', $intensity) === 'medium' ? 'selected' : ''; ?>>Moyenne (Effort soutenu)</option>
                    <option value="high" <?= old('intensity', $intensity) === 'high' ? 'selected' : ''; ?>>Élevée (Haute intensité / HIIT)</option>
                </select>
            </div>

            <!-- Actions alignées sur le design de l'étape d'inscription -->
            <div style="display: flex; gap: 12px; margin-top: 10px;">
                <a href="/activities" class="button button--ghost" style="flex: 1; text-align: center; text-decoration: none;">
                    Annuler
                </a>
                <button type="submit" class="button button--primary" style="flex: 2;">
                    Enregistrer les modifications
                </button>
            </div>
        </form>

        <div style="margin-top: 25px; padding-top: 20px; border-top: 1px solid var(--border); text-align: center;">
            <p style="font-size: 11px; color: var(--muted); font-family: 'Space Grotesk', sans-serif; opacity: 0.8;">
                ID_REF: #<?= $activityId ?>
            </p>
        </div>
    </div>
</div>
<?php echo $this->endSection(); ?>