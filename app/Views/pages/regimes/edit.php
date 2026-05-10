<?php echo $this->extend('layout'); ?>
<?php echo $this->section('content'); ?>

<div class="auth-container">
    <div class="card-auth">
        <header style="margin-bottom: 30px;">
            <p style="text-transform: uppercase; letter-spacing: 0.1em; font-size: 11px; font-weight: 700; color: var(--accent); margin-bottom: 8px;">Nutrition</p>
            <h1 style="font-family: 'Literata', serif; font-size: 26px; margin-bottom: 8px;">Modifier le régime</h1>
            <p style="color: var(--muted); font-size: 14px;">Mise à jour du programme : <strong><?= htmlspecialchars($regime['name']); ?></strong></p>
        </header>

        <!-- Notification d'erreur -->
        <?php if (session()->getFlashdata('error')): ?>
            <div style="padding: 12px 16px; background: rgba(231, 76, 60, 0.08); color: #e74c3c; border-radius: 12px; border: 1px solid rgba(231, 76, 60, 0.2); margin-bottom: 20px; font-size: 13px; font-weight: 600;">
                ⚠️ <?= session()->getFlashdata('error'); ?>
            </div>
        <?php endif; ?>

        <form method="post" action="/regimes/<?= $regime['id']; ?>/update" class="form">
            <?= csrf_field(); ?>

            <div class="field">
                <label for="name">Nom du régime *</label>
                <input type="text" id="name" name="name" required value="<?= htmlspecialchars($regime['name']); ?>">
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                <div class="field">
                    <label for="calories_per_day">Calories / jour *</label>
                    <input type="number" id="calories_per_day" name="calories_per_day" min="500" max="5000" required value="<?= $regime['calories_per_day']; ?>">
                </div>

                <div class="field">
                    <label for="difficulty">Difficulté *</label>
                    <select id="difficulty" name="difficulty" required>
                        <option value="easy" <?= $regime['difficulty'] === 'easy' ? 'selected' : ''; ?>>Facile</option>
                        <option value="medium" <?= $regime['difficulty'] === 'medium' ? 'selected' : ''; ?>>Moyen</option>
                        <option value="hard" <?= $regime['difficulty'] === 'hard' ? 'selected' : ''; ?>>Difficile</option>
                    </select>
                </div>
            </div>

            <div class="field">
                <label for="description">Description</label>
                <textarea id="description" name="description" rows="3"><?= htmlspecialchars($regime['description']); ?></textarea>
            </div>

            <!-- Bloc Composition Nutritionnelle -->
            <div style="margin: 20px 0; padding: 20px; background: var(--bg-main); border-radius: 16px; border: 1px solid var(--border);">
                <h3 style="font-family: 'Space Grotesk', sans-serif; font-size: 13px; font-weight: 800; margin-bottom: 15px; text-transform: uppercase; letter-spacing: 0.05em; color: var(--ink);">
                    Répartition des apports (%)
                </h3>
                
                <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px;">
                    <div class="field" style="margin-bottom: 0;">
                        <label style="font-size: 11px;">Viande</label>
                        <input type="number" class="composition-input" id="pourcentage_viande" name="pourcentage_viande" min="0" max="100" step="0.1" value="<?= $regime['pourcentage_viande']; ?>">
                    </div>
                    <div class="field" style="margin-bottom: 0;">
                        <label style="font-size: 11px;">Poisson</label>
                        <input type="number" class="composition-input" id="pourcentage_poisson" name="pourcentage_poisson" min="0" max="100" step="0.1" value="<?= $regime['pourcentage_poisson']; ?>">
                    </div>
                    <div class="field" style="margin-bottom: 0;">
                        <label style="font-size: 11px;">Volaille</label>
                        <input type="number" class="composition-input" id="pourcentage_volaille" name="pourcentage_volaille" min="0" max="100" step="0.1" value="<?= $regime['pourcentage_volaille']; ?>">
                    </div>
                </div>

                <div id="total-container" style="margin-top: 15px; padding: 10px; border-radius: 10px; font-size: 13px; font-weight: 800; text-align: center; transition: all 0.3s ease;">
                    Total : <span id="total-percentage">0</span>%
                </div>
            </div>

            <div style="display: flex; gap: 12px; margin-top: 10px;">
                <a href="/regimes" class="button button--ghost" style="flex: 1; text-align: center; text-decoration: none;">Annuler</a>
                <button type="submit" class="button button--primary" style="flex: 2;">Mettre à jour</button>
            </div>
        </form>
    </div>
</div>

<script>
document.querySelectorAll('.composition-input').forEach(input => {
    input.addEventListener('input', updateTotal);
});

function updateTotal() {
    const viande = parseFloat(document.getElementById('pourcentage_viande').value) || 0;
    const poisson = parseFloat(document.getElementById('pourcentage_poisson').value) || 0;
    const volaille = parseFloat(document.getElementById('pourcentage_volaille').value) || 0;
    const total = viande + poisson + volaille;
    
    const totalSpan = document.getElementById('total-percentage');
    const container = document.getElementById('total-container');
    
    totalSpan.textContent = total.toFixed(1);
    
    if (total > 100) {
        container.style.background = 'rgba(231, 76, 60, 0.1)';
        container.style.color = '#e74c3c';
        container.style.border = '1px solid rgba(231, 76, 60, 0.2)';
    } else {
        container.style.background = 'rgba(39, 174, 96, 0.1)';
        container.style.color = '#27ae60';
        container.style.border = '1px solid rgba(39, 174, 96, 0.2)';
    }
}

// Initialisation au chargement
updateTotal();
</script>

<?php echo $this->endSection(); ?>