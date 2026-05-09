<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<div class="page">
    <div style="width: 100%; max-width: 960px; margin-bottom: 24px; display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h1 style="font-family: 'Literata', serif; font-size: 32px; margin: 0;">Mes Objectifs</h1>
            <p style="color: var(--muted); margin: 4px 0 0;">Suivez votre progression en temps réel.</p>
        </div>
        <a href="/goals/create" class="button" style="text-decoration: none; display: inline-block;">+ Créer un objectif</a>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div style="width: 100%; padding: 14px; background: rgba(46, 204, 113, 0.1); color: #27ae60; border-radius: 12px; border: 1px solid rgba(46, 204, 113, 0.2); margin-bottom: 20px; font-weight: 600;">
            ✔ <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <?php if (empty($goals)): ?>
        <div class="card" style="width: 100%; text-align: center;">
            <div class="card__header">
                <p class="card__eyebrow">Aucune donnée</p>
                <h1>Commencez l'aventure</h1>
                <p class="card__subtitle">Vous n'avez pas encore défini d'objectifs santé.</p>
            </div>
            <a href="/goals/create" class="button" style="text-decoration: none; display: inline-block; margin-top: 10px;">Créer mon premier objectif</a>
        </div>
    <?php else: ?>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 24px; width: 100%;">
            <?php foreach ($goals as $goal): ?>
                <div class="card" style="width: 100%; display: flex; flex-direction: column; animation-delay: <?= $loop_index ?? 0 * 0.1 ?>s;">
                    <div class="card__header">
                        <p class="card__eyebrow">
                            <?php
                                $statusLabel = ['pending' => 'En attente', 'active' => 'En cours', 'completed' => 'Terminé', 'cancelled' => 'Annulé'];
                                echo $statusLabel[$goal['status']] ?? ucfirst($goal['status']);
                            ?>
                        </p>
                        <h1 style="font-size: 24px;">
                            <?php
                                $typeLabel = ['gain' => 'Augmenter poids', 'lose' => 'Réduire poids', 'reach_ideal' => 'IMC idéal'];
                                echo $typeLabel[$goal['type']] ?? ucfirst($goal['type']);
                            ?>
                        </h1>
                    </div>

                    <div style="display: grid; gap: 12px; margin-bottom: 24px; position: relative; z-index: 1;">
                        <div style="display: flex; justify-content: space-between; border-bottom: 1px dashed var(--border); padding-bottom: 8px;">
                            <span style="color: var(--muted); font-size: 14px;">Cible</span>
                            <strong style="font-weight: 600;">
                                <?= ($goal['type'] === 'reach_ideal') ? '18.5 - 24.9 IMC' : $goal['target_value'] . ' kg' ?>
                            </strong>
                        </div>
                        <div style="display: flex; justify-content: space-between; border-bottom: 1px dashed var(--border); padding-bottom: 8px;">
                            <span style="color: var(--muted); font-size: 14px;">Durée</span>
                            <strong style="font-weight: 600;"><?= $goal['duration_days'] ?> jours</strong>
                        </div>
                        <div style="display: flex; justify-content: space-between; border-bottom: 1px dashed var(--border); padding-bottom: 8px;">
                            <span style="color: var(--muted); font-size: 14px;">Actuel</span>
                            <strong style="font-weight: 600;"><?= number_format($goal['current_weight'], 1) ?> kg (<?= number_format($goal['current_imc'], 1) ?> IMC)</strong>
                        </div>
                    </div>

                    <!-- Progress Section -->
                    <div style="position: relative; z-index: 1; margin-bottom: 24px;">
                        <div style="display: flex; justify-content: space-between; margin-bottom: 8px; font-size: 12px; font-weight: 700; text-transform: uppercase; color: var(--accent-strong);">
                            <span>Progression</span>
                            <span><?= number_format($goal['progress'], 0) ?>%</span>
                        </div>
                        <div style="width: 100%; background: var(--bg-2); height: 10px; border-radius: 20px; overflow: hidden;">
                            <div style="width: <?= $goal['progress'] ?>%; background: linear-gradient(90deg, var(--accent), var(--accent-strong)); height: 100%; border-radius: 20px; transition: width 1s ease-out;"></div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div style="position: relative; z-index: 1; margin-top: auto; display: flex; gap: 10px;">
                        <?php if ($goal['status'] === 'pending'): ?>
                            <a href="/goals/<?= $goal['id'] ?>/activate" class="button" style="flex: 1; text-align: center; text-decoration: none;">Démarrer</a>
                        <?php endif; ?>

                        <?php if ($goal['status'] === 'active'): ?>
                            <a href="/goals/<?= $goal['id'] ?>/plan" class="button" style="flex: 1; text-align: center; text-decoration: none;">Plan</a>
                            <a href="/goals/<?= $goal['id'] ?>/complete" class="button button--ghost" style="flex: 1; text-align: center; text-decoration: none;">Terminer</a>
                        <?php endif; ?>
                        
                        <?php if ($goal['status'] === 'completed'): ?>
                            <div style="text-align: center; width: 100%; color: #27ae60; font-weight: 700; padding: 10px; background: rgba(46, 204, 113, 0.1); border-radius: 10px;">🏆 Objectif Atteint</div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>