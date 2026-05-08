<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
    <h2 class="mb-3">Mon Portefeuille</h2>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= esc((string) session()->getFlashdata('success')) ?></div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= esc((string) session()->getFlashdata('error')) ?></div>
    <?php endif; ?>

    <div class="card mb-4">
        <div class="card-header">
            <strong>Solde actuel</strong>
        </div>
        <div class="card-body">
            <div style="font-size: 2rem; font-weight: 700; color: #0a7d38;">
                <?= number_format((float) ($wallet['balance'] ?? 0), 2, ',', ' ') ?>€
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <strong>Utiliser un coupon</strong>
        </div>
        <div class="card-body">
            <form method="post" action="/wallet/redeem">
                <?= csrf_field() ?>
                <div class="row g-2">
                    <div class="col-md-8">
                        <input type="text" name="code" class="form-control" placeholder="Ex: 500001" inputmode="numeric" pattern="[0-9]*" required>
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary w-100">Appliquer le coupon</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <strong>Historique (10 derniers coupons)</strong>
        </div>
        <div class="card-body">
            <?php if (!empty($history)): ?>
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Montant</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($history as $row): ?>
                            <tr>
                                <td><?= esc((string) $row['redeemed_at']) ?></td>
                                <td>Coupon +<?= number_format((float) $row['amount'], 2, ',', ' ') ?>€</td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p class="mb-0 text-muted">Aucun coupon utilisé pour le moment.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
