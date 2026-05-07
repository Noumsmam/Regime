<?php echo $this->extend('layout'); ?>
<?php echo $this->section('content'); ?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <h2>Créer un nouveau régime</h2>
            <hr/>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= session()->getFlashdata('error'); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <form method="post" action="/regimes/store">
                <?= csrf_field(); ?>

                <div class="mb-3">
                    <label for="name" class="form-label">Nom du régime *</label>
                    <input type="text" class="form-control" id="name" name="name" required 
                           value="<?= old('name'); ?>">
                </div>

                <div class="mb-3">
                    <label for="calories_per_day" class="form-label">Calories par jour *</label>
                    <input type="number" class="form-control" id="calories_per_day" name="calories_per_day" 
                           min="500" max="5000" required value="<?= old('calories_per_day'); ?>">
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3"><?= old('description'); ?></textarea>
                </div>

                <div class="mb-3">
                    <label for="difficulty" class="form-label">Difficulté *</label>
                    <select class="form-control" id="difficulty" name="difficulty" required>
                        <option value="">-- Sélectionner --</option>
                        <option value="easy" <?= old('difficulty') === 'easy' ? 'selected' : ''; ?>>Facile</option>
                        <option value="medium" <?= old('difficulty') === 'medium' ? 'selected' : ''; ?>>Moyen</option>
                        <option value="hard" <?= old('difficulty') === 'hard' ? 'selected' : ''; ?>>Difficile</option>
                    </select>
                </div>

                <fieldset class="mb-4">
                    <legend class="fs-5 mb-3">Composition du régime (%)</legend>
                    <p class="text-muted small">La somme ne doit pas dépasser 100%</p>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="pourcentage_viande" class="form-label">% Viande</label>
                                <input type="number" class="form-control composition-input" id="pourcentage_viande" 
                                       name="pourcentage_viande" min="0" max="100" step="0.1" 
                                       value="<?= old('pourcentage_viande', 0); ?>">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="pourcentage_poisson" class="form-label">% Poisson</label>
                                <input type="number" class="form-control composition-input" id="pourcentage_poisson" 
                                       name="pourcentage_poisson" min="0" max="100" step="0.1" 
                                       value="<?= old('pourcentage_poisson', 0); ?>">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="pourcentage_volaille" class="form-label">% Volaille</label>
                                <input type="number" class="form-control composition-input" id="pourcentage_volaille" 
                                       name="pourcentage_volaille" min="0" max="100" step="0.1" 
                                       value="<?= old('pourcentage_volaille', 0); ?>">
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-info mt-2">
                        <strong>Total :</strong> <span id="total-percentage">0</span>%
                    </div>
                </fieldset>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <a href="/regimes" class="btn btn-secondary">Annuler</a>
                    <button type="submit" class="btn btn-primary">Créer le régime</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.querySelectorAll('.composition-input').forEach(input => {
    input.addEventListener('change', updateTotal);
    input.addEventListener('input', updateTotal);
});

function updateTotal() {
    const viande = parseFloat(document.getElementById('pourcentage_viande').value) || 0;
    const poisson = parseFloat(document.getElementById('pourcentage_poisson').value) || 0;
    const volaille = parseFloat(document.getElementById('pourcentage_volaille').value) || 0;
    const total = viande + poisson + volaille;
    
    const totalSpan = document.getElementById('total-percentage');
    totalSpan.textContent = total.toFixed(1);
    
    // Change color if total > 100
    if (total > 100) {
        totalSpan.parentElement.classList.add('bg-danger', 'text-white');
        totalSpan.parentElement.classList.remove('alert-info');
    } else {
        totalSpan.parentElement.classList.remove('bg-danger', 'text-white');
        totalSpan.parentElement.classList.add('alert-info');
    }
}

// Initialize on load
updateTotal();
</script>

<?php echo $this->endSection(); ?>
