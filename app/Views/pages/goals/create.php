<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<div class="auth-container">
    <div class="card-auth">
        <header style="margin-bottom: 30px;">
            <p style="text-transform: uppercase; letter-spacing: 0.1em; font-size: 11px; font-weight: 700; color: var(--accent); margin-bottom: 8px;">Planification</p>
            <h1 style="font-family: 'Literata', serif; font-size: 26px; margin-bottom: 8px;">Nouvel objectif</h1>
            <p style="color: var(--muted); font-size: 14px;">Définissez vos cibles pour générer un programme sur mesure.</p>
        </header>

        <!-- Notification d'erreur -->
        <?php if (session()->getFlashdata('error')): ?>
            <div style="background: rgba(231, 76, 60, 0.08); border: 1px solid rgba(231, 76, 60, 0.2); padding: 15px; border-radius: 12px; color: #e74c3c; font-size: 13px; font-weight: 600; margin-bottom: 20px;">
                ⚠️ <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <form action="/goals/store" method="POST" class="form">
            <?= csrf_field() ?>

            <div class="field">
                <label for="type">Type d'objectif *</label>
                <select id="type" name="type" required onchange="updateTargetLabel()">
                    <option value="" disabled selected>-- Choisir un type --</option>
                    <option value="gain" <?= old('type') === 'gain' ? 'selected' : '' ?>>
                        Augmenter mon poids
                    </option>
                    <option value="lose" <?= old('type') === 'lose' ? 'selected' : '' ?>>
                        Réduire mon poids
                    </option>
                    <option value="reach_ideal" <?= old('type') === 'reach_ideal' ? 'selected' : '' ?>>
                        Atteindre mon IMC idéal
                    </option>
                </select>
            </div>

            <div class="field">
                <label for="target_value">
                    <span id="targetLabel">Valeur cible</span> *
                </label>
                <input type="number" 
                       step="0.1" 
                       id="target_value" 
                       name="target_value" 
                       value="<?= old('target_value') ?>"
                       required
                       placeholder="Ex: 75.5">
                <p id="targetHint" style="font-size: 11px; color: var(--muted); margin-top: 5px; font-style: italic;"></p>
            </div>

            <div class="field">
                <label for="duration_days">Durée (jours) *</label>
                <input type="number" 
                       id="duration_days" 
                       name="duration_days" 
                       value="<?= old('duration_days') ?>"
                       required
                       placeholder="Ex: 30">
                <p style="font-size: 11px; color: var(--muted); margin-top: 5px;">
                    Minimum 1 jour. La durée sera calculée en semaines.
                </p>
            </div>

            <div style="background: var(--bg-main); border: 1px solid var(--border); padding: 15px; border-radius: 12px; margin-bottom: 25px;">
                <p style="margin: 0; font-size: 13px; color: var(--ink); line-height: 1.4;">
                    <strong>Note :</strong> Une fois créé, un plan incluant un régime et une activité sportive vous sera suggéré automatiquement.
                </p>
            </div>

            <div style="display: flex; gap: 12px;">
                <a href="/goals" class="button button--ghost" style="flex: 1; text-align: center; text-decoration: none;">Annuler</a>
                <button type="submit" class="button button--primary" style="flex: 2;">Créer l'objectif</button>
            </div>
        </form>

        <div style="margin-top: 25px; padding-top: 20px; border-top: 1px solid var(--border); text-align: center;">
            <p style="font-size: 11px; color: var(--muted); font-family: 'Space Grotesk', sans-serif; opacity: 0.8;">
                FITLIFE GOAL ENGINE v2
            </p>
        </div>
    </div>
</div>

<script>
function updateTargetLabel() {
    const typeSelect = document.getElementById('type');
    const targetLabel = document.getElementById('targetLabel');
    const targetHint = document.getElementById('targetHint');
    const targetValue = document.getElementById('target_value');
    const type = typeSelect.value;

    switch(type) {
        case 'gain':
            targetLabel.textContent = 'Poids cible (kg)';
            targetHint.textContent = 'Poids que vous souhaitez atteindre.';
            targetValue.placeholder = 'Ex: 80';
            break;
        case 'lose':
            targetLabel.textContent = 'Poids cible (kg)';
            targetHint.textContent = 'Poids que vous souhaitez atteindre.';
            targetValue.placeholder = 'Ex: 65';
            break;
        case 'reach_ideal':
            targetLabel.textContent = 'IMC cible';
            targetHint.textContent = 'IMC idéal (recommandé: 22).';
            targetValue.placeholder = 'Ex: 22';
            break;
        default:
            targetLabel.textContent = 'Valeur cible';
            targetHint.textContent = '';
            targetValue.placeholder = '';
    }
}

document.addEventListener('DOMContentLoaded', updateTargetLabel);
</script>

<?= $this->endSection() ?>