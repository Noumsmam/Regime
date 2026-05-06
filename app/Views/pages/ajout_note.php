<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<div class="page-header">
  <div>
    <h2>Ajout note</h2>
    <div class="breadcrumb">Accueil / Notes / <span>Ajout</span></div>
  </div>
  <a href="/notes/semestres" class="btn btn-secondary btn-sm">
    <svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
    Retour
  </a>
</div>

<form onsubmit="return false">

  <div class="form-card section-gap">
    <div class="form-section-title">1. Etudiant</div>
    <div class="form-grid">
      <div>
        <label class="field-label">Etudiant <span class="required">*</span></label>
        <select>
          <option value="">-- Selectionner --</option>
          <option value="ETU-0041">Andry Rakoto (ETU-0041)</option>
          <option value="ETU-0042">Fanja Razafy (ETU-0042)</option>
          <option value="ETU-0043">Hery Ranaivo (ETU-0043)</option>
          <option value="ETU-0044">Lalao Rabenja (ETU-0044)</option>
          <option value="ETU-0045">Miora Tsarafidy (ETU-0045)</option>
        </select>
      </div>
    </div>
  </div>

  <div class="form-card section-gap">
    <div class="form-section-title">2. Matiere et evaluation</div>
    <div id="matiere-rows">
      <div class="matiere-row" data-row-index="0">
        <div class="form-grid cols-3">
          <div>
            <label class="field-label">Semestre <span class="required">*</span></label>
            <select name="matieres[0][semestre]" class="matiere-semestre">
              <option value="">-- Selectionner --</option>
              <option value="S3">S3</option>
              <option value="S4">S4</option>
            </select>
          </div>
          <div>
            <label class="field-label">Matiere <span class="required">*</span></label>
            <select name="matieres[0][matiere]">
              <option value="">-- Selectionner --</option>
              <option>Architecture</option>
              <option>Base de donnees</option>
              <option>Reseaux</option>
              <option>Developpement web</option>
            </select>
          </div>
          <div>
            <label class="field-label">Note /20 <span class="required">*</span></label>
            <input name="matieres[0][note]" type="number" min="0" max="20" step="0.25" placeholder="15.5" />
          </div>
          <div class="option-field" style="display:none">
            <label class="field-label">Option (S4)</label>
            <select name="matieres[0][option]" disabled>
              <option value="">-- Selectionner --</option>
              <option>Developpement</option>
              <option>Base de donnees</option>
              <option>Web &amp; design</option>
            </select>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="form-footer">
    <button type="submit" class="btn btn-primary">
      <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
      Enregistrer la note
    </button>
  </div>

</form>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
  (function () {
    const updateOptionField = (row) => {
      const semesterSelect = row.querySelector('.matiere-semestre');
      const optionField = row.querySelector('.option-field');
      const optionSelect = optionField ? optionField.querySelector('select') : null;

      if (!semesterSelect || !optionField || !optionSelect) {
        return;
      }

      const isS4 = semesterSelect.value === 'S4';
      optionField.style.display = isS4 ? '' : 'none';
      optionSelect.disabled = !isS4;
      if (!isS4) {
        optionSelect.selectedIndex = 0;
      }
    };
    const row = document.querySelector('.matiere-row');
    if (!row) {
      return;
    }

    const semesterSelect = row.querySelector('.matiere-semestre');
    if (!semesterSelect) {
      return;
    }

    semesterSelect.addEventListener('change', () => updateOptionField(row));
    updateOptionField(row);
  })();
</script>
<?= $this->endSection() ?>
