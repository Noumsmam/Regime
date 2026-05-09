<?php echo $this->extend('layout'); ?>
<?php echo $this->section('content'); ?>

<div class="container mt-5">
    <?php $parametre = $parametre ?? []; ?>
    <?php
        $parametreId = (int) ($parametre['id'] ?? 0);
        $nom = (string) ($parametre['nom'] ?? '');
        $valeur = (string) ($parametre['valeur'] ?? '');
        $categorie = (string) ($parametre['categorie'] ?? '');
        $description = (string) ($parametre['description'] ?? '');
        $isActive = !empty($parametre['is_active']);
    ?>
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <h2>Modifier le paramètre : <?= esc($nom); ?></h2>
            <hr/>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= session()->getFlashdata('error'); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <form method="post" action="/parametres/<?= $parametreId; ?>/update">
                <?= csrf_field(); ?>

                <div class="mb-3">
                    <label for="nom" class="form-label">Nom *</label>
                    <input type="text" class="form-control" id="nom" name="nom" required value="<?= old('nom', $nom); ?>">
                </div>

                <div class="mb-3">
                    <label for="valeur" class="form-label">Valeur *</label>
                    <input type="text" class="form-control" id="valeur" name="valeur" required value="<?= old('valeur', $valeur); ?>">
                </div>

                <div class="mb-3">
                    <label for="categorie" class="form-label">Catégorie</label>
                    <input type="text" class="form-control" id="categorie" name="categorie" value="<?= old('categorie', $categorie); ?>">
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3"><?= old('description', $description); ?></textarea>
                </div>

                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" <?= old('is_active', $isActive ? 1 : 0) ? 'checked' : ''; ?>>
                    <label class="form-check-label" for="is_active">Actif</label>
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <a href="/parametres" class="btn btn-secondary">Annuler</a>
                    <button type="submit" class="btn btn-primary">Mettre à jour</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php echo $this->endSection(); ?>