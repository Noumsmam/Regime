<?php echo $this->extend('layout'); ?>
<?php echo $this->section('content'); ?>

<div class="auth-container">
    <div class="card-auth">
        <header style="margin-bottom: 30px;">
            <p style="text-transform: uppercase; letter-spacing: 0.1em; font-size: 11px; font-weight: 700; color: var(--accent); margin-bottom: 8px;">Nutrition</p>
            <h1 style="font-family: 'Literata', serif; font-size: 26px; margin-bottom: 8px;">Nouveau régime</h1>
            <p style="color: var(--muted); font-size: 14px;">Définissez les objectifs caloriques et la répartition des apports.</p>
        </header>

        <?php if (session()->getFlashdata('error')): ?>
            <div style="padding: 12px 16px; background: rgba(231, 76, 60, 0.08); color: #e74c3c; border-radius: 12px; border: 1px solid rgba(231, 76, 60, 0.2); margin-bottom: 20px; font-size: 13px; font-weight: 600;">
                ⚠️ <?= session()->getFlashdata('error'); ?>
            </div>
        <?php endif; ?>

        <form method="post" action="/regimes/store" class="form">
            <?= csrf_field(); ?>

            <div class="field">
                <label for="name">Nom du régime *</label>
                <input type="text" id="name" name="name" required placeholder="Ex: Cétogène, Sportif..." value="<?= old('name'); ?>">
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                <div class="field">
                    <label for="calories_per_day">Calories / jour *</label>
                    <input type="number" id="calories_per_day" name="calories_per_day" min="500" max="5000" required placeholder="Ex: 2200" value="<?= old('calories_per_day'); ?>">
                </div>

                <div class="field">
                    <label for="difficulty">Difficulté *</label>
                    <select id="difficulty" name="difficulty" required>
                        <option value="" disabled selected>-- Choisir --</option>
                        <option value="easy" <?= old('difficulty') === 'easy' ? 'selected' : ''; ?>>Facile</option>
                        <option value="medium" <?= old('difficulty') === 'medium' ? 'selected' : ''; ?>>Moyen</option>
                        <option value="hard" <?= old('difficulty') === 'hard' ? 'selected' : ''; ?>>Difficile</option>
                    </select>
                </div>
            </div>

            <div class="field">
                <label for="description">Description</label>
                <textarea id="description" name="description" rows="3" placeholder="Détails du programme alimentaire..."><?= old('description'); ?></textarea>
            </div>

            <div style="margin: 20px 0; padding: 20px; background: var(--bg-main); border-radius: 16px; border: 1px solid var(--border);">
                <h3 style="font-family: 'Space Grotesk', sans-serif; font-size: 14px; font-weight: 700; margin-bottom: 15px; text-transform: uppercase; letter-spacing: 0.05em;">
                    Composition (%)
                </h3>
                
                <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px;">
                    <div class="field" style="margin-bottom: 0;">
                        <label style="font-size: 11px;">Viande</label>
                        <input type="number" class="composition-input" id="pourcentage_viande" name="pourcentage_viande" min="0" max="100" step="0.1" value="<?= old('pourcentage_viande', 0); ?>">
                    </div>
                    <div class="field" style="margin-bottom: 0;">
                        <label style="font-size: 11px;">Poisson</label>
                        <input type="number" class="composition-input" id="pourcentage_poisson" name="pourcentage_poisson" min="0" max="100" step="0.1" value="<?= old('pourcentage_poisson', 0); ?>">
                    </div>
                    <div class="field" style="margin-bottom: 0;">
                        <label style="font-size: 11px;">Volaille</label>
                        <input type="number" class="composition-input" id="pourcentage_volaille" name="pourcentage_volaille" min="0" max="100" step="0.1" value="<?= old('pourcentage_volaille', 0); ?>">
                    </div>
                </div>

                <div id="total-container" style="margin-top: 15px; padding: 10px; border-radius: 8px; font-size: 13px; font-weight: 700; text-align: center; transition: all 0.3s ease;">
                    Total : <span id="total-percentage">0</span>%
                </div>
            </div>

            <div style="display: flex; gap: 12px; margin-top: 10px;">
                <a href="/regimes" class="button button--ghost" style="flex: 1; text-align: center; text-decoration: none;">Annuler</a>
                <button type="submit" class="button button--primary" style="flex: 2;">Créer le régime</button>
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

// Init
updateTotal();
</script>

<?php echo $this->endSection(); ?>