<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="layout">
    <!-- SIDEBAR -->
    <aside class="sidebar">
        <div class="brand">
            <a href="/" class="brand__mark">FitLife</a>
            <span class="brand__tag">Wallet</span>
        </div>

        <nav class="menu">
            <a href="/dashboard" class="menu__item">Tableau de bord</a>
            <a href="/regimes" class="menu__item">Régimes & Menus</a>
            <a href="/offres" class="menu__item">Mes Options</a>
            <a href="/wallet" class="menu__item active">Mon Portefeuille</a>
            
            <div class="menu__amount">
                <span>Solde Disponible</span>
                <strong><?= number_format((float) ($wallet['balance'] ?? 0), 2, ',', ' ') ?>€</strong>
            </div>
        </nav>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="content">
        <header class="topbar">
            <div>
                <h1 style="font-family: 'Literata', serif; font-size: 28px; margin: 0;">Mon Portefeuille</h1>
                <p style="color: var(--muted); font-size: 14px; margin-top: 4px;">Gérez vos crédits et activez vos coupons de recharge.</p>
            </div>
        </header>

        <!-- Alertes -->
        <?php if (session()->getFlashdata('success')): ?>
            <div style="background: rgba(39, 174, 96, 0.08); border: 1px solid rgba(39, 174, 96, 0.2); padding: 15px; border-radius: 12px; color: #27ae60; font-size: 14px; font-weight: 600; margin-bottom: 20px;">
                ✅ <?= esc((string) session()->getFlashdata('success')) ?>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div style="background: rgba(231, 76, 60, 0.08); border: 1px solid rgba(231, 76, 60, 0.2); padding: 15px; border-radius: 12px; color: #e74c3c; font-size: 14px; font-weight: 600; margin-bottom: 20px;">
                ⚠️ <?= esc((string) session()->getFlashdata('error')) ?>
            </div>
        <?php endif; ?>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 25px; align-items: start;">
            
            <!-- SECTION SOLDE ET RECHARGE -->
            <section>
                <div class="feature" style="padding: 30px; margin-bottom: 25px; text-align: center; cursor: default;">
                    <p style="text-transform: uppercase; letter-spacing: 0.1em; font-size: 11px; font-weight: 700; color: var(--muted); margin-bottom: 10px;">Solde actuel</p>
                    <div style="font-size: 42px; font-family: 'Space Grotesk', sans-serif; font-weight: 800; color: var(--accent-strong); line-height: 1;">
                        <?= number_format((float) ($wallet['balance'] ?? 0), 2, ',', ' ') ?><span style="font-size: 24px; margin-left: 4px;">€</span>
                    </div>
                </div>

                <div class="card-auth" style="width: 100%; box-sizing: border-box;">
                    <h3 style="font-family: 'Space Grotesk', sans-serif; font-size: 16px; margin-bottom: 20px;">Activer un coupon</h3>
                    <form method="post" action="/wallet/redeem" class="form">
                        <?= csrf_field() ?>
                        <div class="field">
                            <label for="code">Code de recharge</label>
                            <input type="text" id="code" name="code" placeholder="Ex: 500001" inputmode="numeric" pattern="[0-9]*" required 
                                   style="font-family: 'Space Grotesk', sans-serif; letter-spacing: 0.2em; font-weight: 700; text-align: center; font-size: 18px;">
                        </div>
                        <button type="submit" class="button button--primary" style="width: 100%; margin-top: 10px;">
                            Créditer mon compte
                        </button>
                    </form>
                </div>
            </section>

            <!-- SECTION HISTORIQUE -->
            <section class="feature" style="cursor: default; padding: 25px;">
                <h3 style="font-family: 'Space Grotesk', sans-serif; font-size: 16px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
                    <span>📜</span> Dernières transactions
                </h3>

                <?php if (!empty($history)): ?>
                    <div style="display: flex; flex-direction: column; gap: 12px;">
                        <?php foreach ($history as $row): ?>
                            <div style="display: flex; justify-content: space-between; align-items: center; padding: 12px; background: var(--bg-main); border-radius: 10px; border: 1px solid var(--border);">
                                <div>
                                    <p style="margin: 0; font-size: 13px; font-weight: 700; color: var(--ink);">Recharge par coupon</p>
                                    <p style="margin: 2px 0 0; font-size: 11px; color: var(--muted);"><?= esc((string) $row['redeemed_at']) ?></p>
                                </div>
                                <div style="font-family: 'Space Grotesk', sans-serif; font-weight: 700; color: #27ae60;">
                                    +<?= number_format((float) $row['amount'], 2, ',', ' ') ?>€
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div style="text-align: center; padding: 40px 20px; color: var(--muted);">
                        <p style="font-size: 14px;">Aucun coupon utilisé pour le moment.</p>
                    </div>
                <?php endif; ?>
            </section>

        </div>

        <footer style="margin-top: 50px; padding: 20px; border-top: 1px solid var(--border); text-align: center;">
            <p style="font-size: 12px; color: var(--muted);">Transactions sécurisées par FitLife Wallet Services.</p>
        </footer>
    </main>
</div>

<?= $this->endSection() ?>