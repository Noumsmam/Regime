<?php echo $this->extend('layout'); ?>
<?php echo $this->section('content'); ?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <h2>Créer une nouvelle activité</h2>
            <hr/>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= session()->getFlashdata('error'); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <form method="post" action="/activities/store">
                <?= csrf_field(); ?>

                <div class="mb-3">
                    <label for="name" class="form-label">Nom de l'activité *</label>
                    <input type="text" class="form-control" id="name" name="name" required value="<?= old('name'); ?>">
                </div>

                <div class="mb-3">
                    <label for="calories_burn_per_hour" class="form-label">Calories brûlées par heure *</label>
                    <input type="number" class="form-control" id="calories_burn_per_hour" name="calories_burn_per_hour" min="1" required value="<?= old('calories_burn_per_hour'); ?>">
                </div>

                <div class="mb-3">
                    <label for="intensity" class="form-label">Intensité *</label>
                    <select class="form-control" id="intensity" name="intensity" required>
                        <option value="">-- Sélectionner --</option>
                        <option value="low" <?= old('intensity') === 'low' ? 'selected' : ''; ?>>Faible</option>
                        <option value="medium" <?= old('intensity') === 'medium' ? 'selected' : ''; ?>>Moyenne</option>
                        <option value="high" <?= old('intensity') === 'high' ? 'selected' : ''; ?>>Élevée</option>
                    </select>
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <a href="/activities" class="btn btn-secondary">Annuler</a>
                    <button type="submit" class="btn btn-primary">Créer l'activité</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php echo $this->endSection(); ?>