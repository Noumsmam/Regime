<?php echo $this->extend('layout'); ?>
<?php echo $this->section('content'); ?>

<div class="container mt-5">
    <?php $parametres = $parametres ?? []; ?>
    <div class="row mb-4">
        <div class="col-md-8">
            <h2>Gestion des paramètres</h2>
        </div>
        <div class="col-md-4 text-right">
            <a href="/parametres/create" class="btn btn-primary">+ Ajouter un paramètre</a>
        </div>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('success'); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('error'); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if (!empty($parametres)): ?>
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Nom</th>
                        <th>Valeur</th>
                        <th>Catégorie</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($parametres as $parametre): ?>
                        <?php
                            $parametreId = (int) ($parametre['id'] ?? 0);
                            $nom = (string) ($parametre['nom'] ?? '');
                            $valeur = (string) ($parametre['valeur'] ?? '');
                            $categorie = (string) ($parametre['categorie'] ?? '—');
                            $isActive = !empty($parametre['is_active']);
                        ?>
                        <tr>
                            <td><strong><?= esc($nom); ?></strong></td>
                            <td><?= esc($valeur); ?></td>
                            <td><?= esc($categorie); ?></td>
                            <td>
                                <?php if ($isActive): ?>
                                    <span class="badge bg-success">Actif</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">Inactif</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="/parametres/<?= $parametreId; ?>/edit" class="btn btn-sm btn-warning">Modifier</a>
                                <a href="/parametres/<?= $parametreId; ?>/delete" class="btn btn-sm btn-danger">Supprimer</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="alert alert-info">
            Aucun paramètre trouvé. <a href="/parametres/create">Créer le premier paramètre</a>
        </div>
    <?php endif; ?>
</div>

<?php echo $this->endSection(); ?>