<?php echo $this->extend('layout'); ?>
<?php echo $this->section('content'); ?>

<div class="container mt-5">
    <?php $parametre = $parametre ?? []; ?>
    <?php
        $parametreId = (int) ($parametre['id'] ?? 0);
        $nom = (string) ($parametre['nom'] ?? '');
        $valeur = (string) ($parametre['valeur'] ?? '');
        $categorie = (string) ($parametre['categorie'] ?? '—');
    ?>
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card border-danger">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0">Confirmation de suppression</h5>
                </div>
                <div class="card-body">
                    <p class="mb-3">
                        Êtes-vous sûr de vouloir supprimer le paramètre <strong><?= esc($nom); ?></strong> ?
                    </p>
                    <div class="alert alert-warning">
                        <p class="mb-0"><strong>Détails du paramètre :</strong></p>
                        <ul class="mb-0 mt-2">
                            <li>Valeur : <?= esc($valeur); ?></li>
                            <li>Catégorie : <?= esc($categorie); ?></li>
                        </ul>
                    </div>

                    <form method="post" action="/parametres/<?= $parametreId; ?>/destroy" class="d-inline">
                        <?= csrf_field(); ?>
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="/parametres" class="btn btn-secondary">Annuler</a>
                            <button type="submit" class="btn btn-danger">Supprimer définitivement</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php echo $this->endSection(); ?>