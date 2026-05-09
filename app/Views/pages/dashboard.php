<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<div class="layout">
    <aside class="sidebar">
        <div class="brand">
            <a href="/" class="brand__mark">FitLife</a>
            <span class="brand__tag">v2.4</span>
        </div>

        <nav class="menu">
            <a href="/dashboard" class="menu__item">Tableau de bord</a>
            <a href="/goals" class="menu__item">Mes Objectifs</a>
            <a href="/regimes" class="menu__item">Régimes</a>
            
            <div class="menu__amount">
                <span>Mon Solde</span>
                <strong><?= number_format((float)($walletBalance ?? 0), 2, ',', ' ') ?>€</strong>
            </div>
        </nav>
    </aside>

    <main class="content">
        <header class="topbar">
            <div class="topbar__links">
                <span class="topbar__link">Accueil / <strong>Dashboard</strong></span>
            </div>
            <a href="/logout" class="button button--ghost">Se déconnecter</a>
        </header>

        <section class="hero">
            <div class="hero__card" style="border-left: 6px solid <?= esc($imcStatus['color'] ?? 'var(--accent)') ?>;">
                <h1>Bonjour, <?= esc($user['username'] ?? $user['nom'] ?? 'Utilisateur') ?></h1>
                <p>Voici un récapitulatif de votre profil santé et de vos activités récentes.</p>
                
                <?php if (!empty($user)): ?>
                <div class="dashboard-stats" style="padding: 0; margin-top: 20px;">
                    <div class="stat-card">
                        <span>IMC Actuel</span>
                        <strong><?= number_format((float)($imc ?? 0), 2, ',', ' ') ?></strong>
                    </div>
                    <div class="stat-card">
                        <span>Catégorie</span>
                        <strong><?= esc($imcStatus['status'] ?? 'Inconnu') ?></strong>
                    </div>
                    <div class="stat-card">
                        <span>Taille</span>
                        <strong><?= esc($user['taille'] ?? 0) ?> cm</strong>
                    </div>
                    <div class="stat-card">
                        <span>Poids</span>
                        <strong><?= esc($user['poids'] ?? 0) ?> kg</strong>
                    </div>
                </div>
                <?php endif; ?>

                <div style="margin-top: 24px; display: flex; gap: 12px;">
                    <a href="/goals" class="button">Nouveau Programme</a>
                    <button class="button button--ghost">Exporter les données</button>
                </div>
            </div>
        </section>

        <section class="features">
            <div class="feature">
                <h3>Utilisateurs</h3>
                <p>1 284 actifs</p>
                <small style="color: #2ecc71;">+12.5% ce mois</small>
            </div>
            <div class="feature">
                <h3>Transactions</h3>
                <p>8 430 total</p>
                <small style="color: #2ecc71;">+7.3% ce mois</small>
            </div>
            <div class="feature">
                <h3>SLA</h3>
                <p>99.8%</p>
                <small style="color: #2ecc71;">Disponibilité OK</small>
            </div>
        </section>

        <div class="dashboard-charts" style="padding: 0;">
            <div class="chart-card">
                <h3 class="chart-title">Activité mensuelle</h3>
                <div style="height: 180px; display: flex; align-items: flex-end; gap: 8px; border-bottom: 1px solid var(--border);">
                    <div style="flex: 1; background: var(--accent); height: 60%; border-radius: 4px 4px 0 0;"></div>
                    <div style="flex: 1; background: var(--muted); height: 45%; border-radius: 4px 4px 0 0;"></div>
                    <div style="flex: 1; background: var(--accent); height: 80%; border-radius: 4px 4px 0 0;"></div>
                    <div style="flex: 1; background: var(--muted); height: 55%; border-radius: 4px 4px 0 0;"></div>
                    <div style="flex: 1; background: var(--accent); height: 70%; border-radius: 4px 4px 0 0;"></div>
                    <div style="flex: 1; background: var(--muted); height: 50%; border-radius: 4px 4px 0 0;"></div>
                </div>
            </div>

            <div class="chart-card">
                <h3 class="chart-title">Progression Objectifs</h3>
                <div style="display: grid; gap: 16px;">
                    <div>
                        <div style="display: flex; justify-content: space-between; font-size: 14px; margin-bottom: 4px;">
                            <span>Perte de poids</span><strong>82%</strong>
                        </div>
                        <div style="width: 100%; background: var(--bg-2); height: 8px; border-radius: 10px;">
                            <div style="width: 82%; background: var(--accent-strong); height: 100%; border-radius: 10px;"></div>
                        </div>
                    </div>
                    <div>
                        <div style="display: flex; justify-content: space-between; font-size: 14px; margin-bottom: 4px;">
                            <span>Stabilisation</span><strong>67%</strong>
                        </div>
                        <div style="width: 100%; background: var(--bg-2); height: 8px; border-radius: 10px;">
                            <div style="width: 67%; background: var(--accent); height: 100%; border-radius: 10px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <section class="gold">
            <div class="gold__card">
                <div>
                    <h2>🌟 Option Gold</h2>
                    <p>Bénéficiez de -15% sur tous les régimes FitLife.</p>
                </div>
                <a href="/gold" class="button">Devenir Membre Gold</a>
            </div>
        </section>

        <footer class="footer">
            © 2026 FitLife — Projet S4 — Gestion Santé & Bien-être
        </footer>
    </main>
</div>
<?= $this->endSection() ?>