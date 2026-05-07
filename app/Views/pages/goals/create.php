<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1 class="mb-4">Créer un nouvel objectif</h1>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= session()->getFlashdata('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <form action="/goals/store" method="POST" class="card p-4">
                <?= csrf_field() ?>

                <div class="mb-3">
                    <label for="type" class="form-label">Type d'objectif *</label>
                    <select class="form-select" id="type" name="type" required onchange="updateTargetLabel()">
                        <option value="">-- Choisir un type --</option>
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

                <div class="mb-3">
                    <label for="target_value" class="form-label">
                        <span id="targetLabel">Valeur cible</span> (kg) *
                    </label>
                    <input type="number" 
                           step="0.1" 
                           class="form-control" 
                           id="target_value" 
                           name="target_value" 
                           value="<?= old('target_value') ?>"
                           required
                           placeholder="Ex: 75.5">
                    <small class="form-text text-muted" id="targetHint"></small>
                </div>

                <div class="mb-3">
                    <label for="duration_days" class="form-label">Durée (jours) *</label>
                    <input type="number" 
                           class="form-control" 
                           id="duration_days" 
                           name="duration_days" 
                           value="<?= old('duration_days') ?>"
                           required
                           placeholder="Ex: 30">
                    <small class="form-text text-muted">
                        1 jour minimum. La durée sera convertie ( jours / 7 = semaines).
                    </small>
                </div>

                <div class="mb-3">
                    <p class="alert alert-info">
                        <strong>Note :</strong> Une fois créé, vous pourrez démarrer l'objectif et un plan 
                        incluant un régime et une activité sportive vous sera suggéré selon votre type d'objectif 
                        et la durée.
                    </p>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Créer l'objectif</button>
                    <a href="/goals" class="btn btn-secondary">Annuler</a>
                </div>
            </form>
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
            targetLabel.textContent = 'Poids cible (à atteindre)';
            targetHint.textContent = 'Entrez le poids que vous souhaitez atteindre par rapport à maintenant.';
            targetValue.placeholder = 'Ex: 80';
            break;
        case 'lose':
            targetLabel.textContent = 'Poids cible (à atteindre)';
            targetHint.textContent = 'Entrez le poids que vous souhaitez atteindre par rapport à maintenant.';
            targetValue.placeholder = 'Ex: 65';
            break;
        case 'reach_ideal':
            targetLabel.textContent = 'IMC cible (idéal: 18.5 - 24.9)';
            targetHint.textContent = 'Laissez vide (l\'IMC idéal est fixé à 22) ou entrez votre IMC cible.';
            targetValue.placeholder = 'Ex: 22 (optionnel)';
            break;
        default:
            targetLabel.textContent = 'Valeur cible';
            targetHint.textContent = '';
            targetValue.placeholder = '';
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', updateTargetLabel);
</script>

<?= $this->endSection() ?>
