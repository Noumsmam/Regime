<?php
$goal = $goal ?? [];
$plan = $goal['plan'] ?? [];

$typeLabel = [
    'gain' => 'Augmenter poids',
    'lose' => 'Reduire poids',
    'reach_ideal' => 'Atteindre IMC ideal',
];

$goalType = (string) ($goal['type'] ?? '');
$goalTypeLabel = (string) ($typeLabel[$goalType] ?? ucfirst($goalType));

$objectiveText = 'IMC ideal (18.5 - 24.9)';
if ($goalType !== 'reach_ideal') {
    $objectiveText = (string) ($goal['target_value'] ?? 'N/A') . ' kg';
}

$regimeName = (string) ($plan['regime_name'] ?? 'N/A');
$activityName = (string) ($plan['activity_name'] ?? 'N/A');
$regimeDescription = (string) ($plan['regime_description'] ?? 'Pas de description');

$caloriesPerDay = (int) ($plan['calories_per_day'] ?? 0);
$activityCaloriesHour = (int) ($plan['calories_burn_per_hour'] ?? 0);
$minutesPerDay = (int) ($plan['minutes_per_day'] ?? 0);

$pViande = (float) ($plan['pourcentage_viande'] ?? 0);
$pPoisson = (float) ($plan['pourcentage_poisson'] ?? 0);
$pVolaille = (float) ($plan['pourcentage_volaille'] ?? 0);

$displayPrice = $plan['display_price'] ?? null;
$durationDays = (int) ($plan['plan_duration_days'] ?? ($goal['duration_days'] ?? 0));
$dailyCaloriesBurn = (int) round(($activityCaloriesHour / 60) * $minutesPerDay);

$generatedAt = (string) ($generatedAt ?? date('d/m/Y H:i'));
?>
<style>
    body { font-family: helvetica, sans-serif; font-size: 11px; color: #1f2937; line-height: 1.45; }
    h1 { font-size: 22px; margin: 0 0 2px 0; color: #0f172a; }
    h2 { font-size: 13px; margin: 0 0 8px 0; color: #0f172a; text-transform: uppercase; letter-spacing: 0.5px; }
    p { margin: 3px 0; }
    .header {
        border-bottom: 2px solid #0f766e;
        padding-bottom: 8px;
        margin-bottom: 12px;
    }
    .brand { font-size: 12px; color: #0f766e; font-weight: bold; }
    .subtitle { font-size: 11px; color: #475569; }
    .muted { color: #6b7280; }
    .kpi-row { width: 100%; margin-bottom: 10px; }
    .kpi {
        width: 32.3%;
        display: inline-block;
        vertical-align: top;
        border: 1px solid #dbe7e6;
        background: #f8fbfb;
        padding: 8px;
        box-sizing: border-box;
    }
    .kpi-title { font-size: 10px; color: #64748b; }
    .kpi-value { font-size: 16px; font-weight: bold; color: #0f172a; }
    .block {
        border: 1px solid #d1d5db;
        border-left: 4px solid #0f766e;
        padding: 10px;
        margin-bottom: 12px;
        background: #ffffff;
    }
    .row { width: 100%; }
    .col { width: 49%; display: inline-block; vertical-align: top; }
    .chip { display: inline-block; padding: 3px 8px; background: #e2f4f1; color: #0f766e; border-radius: 12px; font-size: 10px; font-weight: bold; }
    .table { width: 100%; border-collapse: collapse; }
    .table th, .table td { border: 1px solid #d1d5db; padding: 6px; text-align: left; }
    .table th { background: #edf4f3; color: #0f172a; }
    .footer {
        margin-top: 14px;
        border-top: 1px solid #e5e7eb;
        padding-top: 6px;
        font-size: 9px;
        color: #6b7280;
    }
</style>

<div class="header">
    <div class="brand">Regime App</div>
    <h1>Plan Regime Personnalise</h1>
    <div class="subtitle">Genere le <?= esc($generatedAt) ?></div>
</div>

<div class="kpi-row">
    <div class="kpi">
        <div class="kpi-title">Objectif</div>
        <div class="kpi-value"><?= esc($goalTypeLabel) ?></div>
    </div>
    <div class="kpi">
        <div class="kpi-title">Duree</div>
        <div class="kpi-value"><?= (int) ($goal['duration_days'] ?? 0) ?> j</div>
    </div>
    <div class="kpi">
        <div class="kpi-title">Prix total</div>
        <div class="kpi-value">
            <?php if ($displayPrice !== null): ?>
                <?= number_format((float) $displayPrice, 2, ',', ' ') ?> EUR
            <?php else: ?>
                N/A
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="block">
    <h2>Objectif</h2>
    <p><strong>Type:</strong> <?= esc($goalTypeLabel) ?></p>
    <p><strong>Cible:</strong> <?= esc($objectiveText) ?></p>
    <p><strong>Duree:</strong> <?= (int) ($goal['duration_days'] ?? 0) ?> jours</p>
    <p><strong>Statut:</strong> <span class="chip"><?= esc((string) ($goal['status'] ?? 'N/A')) ?></span></p>
</div>

<div class="row">
    <div class="col block">
        <h2>Regime recommande</h2>
        <p><strong>Nom:</strong> <?= esc($regimeName) ?></p>
        <p><strong>Calories par jour:</strong> <?= $caloriesPerDay ?> kcal</p>
        <p><strong>Description:</strong> <?= esc($regimeDescription) ?></p>
        <p><strong>Composition:</strong></p>
        <table class="table">
            <tr><th>Viande</th><th>Poisson</th><th>Volaille</th></tr>
            <tr>
                <td><?= number_format($pViande, 2, ',', ' ') ?>%</td>
                <td><?= number_format($pPoisson, 2, ',', ' ') ?>%</td>
                <td><?= number_format($pVolaille, 2, ',', ' ') ?>%</td>
            </tr>
        </table>
    </div>

    <div class="col block">
        <h2>Activite conseillee</h2>
        <p><strong>Nom:</strong> <?= esc($activityName) ?></p>
        <p><strong>Calories/heure:</strong> <?= $activityCaloriesHour ?> kcal</p>
        <p><strong>Duree quotidienne:</strong> <?= $minutesPerDay ?> min/jour</p>
        <p><strong>Depense estimee/jour:</strong> <?= $dailyCaloriesBurn ?> kcal</p>

        <h2 style="margin-top:10px;">Prix</h2>
        <?php if ($displayPrice !== null): ?>
            <p><strong>Prix du plan:</strong> <?= number_format((float) $displayPrice, 2, ',', ' ') ?> EUR</p>
            <p><strong>Duree facturee:</strong> <?= $durationDays ?> jours</p>
        <?php else: ?>
            <p class="muted">Prix indisponible</p>
        <?php endif; ?>
    </div>
</div>

<div class="footer">
    Document genere automatiquement pour le suivi client. Conserver ce PDF pour reference de plan alimentaire et sportif.
</div>