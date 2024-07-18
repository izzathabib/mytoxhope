<?= $this->extend('layouts/app.php'); ?>
<?= $this->section('bodyClass') ?>addprod-page<?= $this->endSection() ?>
<?= $this->section('content'); ?>

<div class="addprod-container p-4">
  <h4 class="text-left" style="margin-left: 40px;"><b>Register New Product</b></h4>
  <div class="card shadow-sm addprod-container">
    <div class="card-body">
      <form method="POST" action="<?= url_to('saveProdDetail'); ?>" enctype="multipart/form-data">
        <div class="row">
          <div class="col-md-6">
            <!-- Product Name -->
            <div class="form-group mb-4">
              <label for="product_name">Product Name</label>
              <input type="text" id="product_name" name="product_name" class="form-control">
            </div>

            <!-- Product Image -->
            <div class="form-group mb-4">
              <label for="product_image">Product Image</label>
              <input type="file" id="product_image" name="product_image" class="form-control">
            </div>

            <!-- Type of Poison -->
            <div class="form-group mb-4">
              <label for="type_poison">Type of Poison</label>
              <select id="type_poison" name="type_poison" class="form-control">
                <option value="Please select">Please select</option>
                <option value="List 1">List 1</option>
                <option value="List 2">List 2</option>
                <option value="List 3">List 3</option>
              </select>
            </div>

            <!-- Active ingredient -->
            <!-- Active ingredient -->
            <div class="form-group mb-4">
              <label for="active_ing">Active Ingredient/ Chemical Name</label>
              <div class="tag-input">
                <input type="text" id="active_ing_input" class="form-control"
                  placeholder="Type an ingredient and press Enter">
                <div id="tags-container" class="tags-container"></div>
              </div>
              <input type="hidden" id="active_ing" name="active_ing">
            </div>

            <!-- Inactive ingredient -->
            <div class="form-group mb-4">
              <label for="inactive_ing">Inactive Ingredients</label>
              <textarea id="inactive_ing" name="inactive_ing" class="form-control"></textarea>
            </div>
          </div>

          <div class="col-md-6">
            <!-- Brand Name -->
            <div class="form-group mb-4">
              <label for="brand_name">Brand Name</label>
              <input type="text" id="brand_name" name="brand_name" class="form-control">
            </div>

            <!-- Product MSDS -->
            <div class="form-group mb-4">
              <label for="msds">Product MSDS</label>
              <input type="file" id="msds" name="msds" class="form-control">
            </div>

            <!-- Subtype of Household / Consumer Product -->
            <div class="form-group mb-4">
              <label for="subtype_household">Subtype of Household / Consumer Product</label>
              <select id="subtype_household" name="subtype_household" class="form-control">
                <option value="Please select">Please select</option>
                <option value="agricultural">Agricultural/Garden</option>
                <option value="environment">Environmental Contaminant</option>
                <option value="household">Household/Leisure</option>
                <option value="industrial">Industrial/Commercial</option>
                <option value="agents">Mixture of Agents</option>
                <option value="toxin">Natural Toxin</option>
                <option value="pharmaceutical">Pharmaceutical</option>
                <option value="pesticide">Pesticide</option>
                <option value="substance">Substance of Abuse</option>
                <option value="unknown">Unknown Function</option>
                <option value="other">Other (Please describe)</option>
              </select>
            </div>
            <div id="other_subtype_container" class="form-group mb-4" style="display: none;">
              <label for="other_subtype">Please describe:</label>
              <input type="text" id="other_subtype" name="other_subtype" class="form-control">
            </div>
          </div>
        </div>

        <!-- Submit and Cancel buttons -->
        <div class="row mt-3">
          <div class="col-md-12 text-center">
            <button type="submit" value="Submit" class="btn btn-primary">Add Product</button>
            <a href="<?= site_url('dashboard'); ?>" class="btn btn-secondary">Cancel</a>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const input = document.getElementById('active_ing_input');
    const tagsContainer = document.getElementById('tags-container');
    const hiddenInput = document.getElementById('active_ing');
    let tags = [];

    input.addEventListener('keydown', function (e) {
      if (e.key === 'Enter' && this.value) {
        e.preventDefault();
        addTag(this.value);
        this.value = '';
        updateHiddenInput();
      }
    });

    function addTag(text) {
      const tag = document.createElement('span');
      tag.classList.add('tag');
      tag.textContent = text;

      const closeBtn = document.createElement('span');
      closeBtn.classList.add('tag-close');
      closeBtn.innerHTML = '&times;';
      closeBtn.addEventListener('click', function () {
        tag.remove();
        tags = tags.filter(t => t !== text);
        updateHiddenInput();
      });

      tag.appendChild(closeBtn);
      tagsContainer.appendChild(tag);
      tags.push(text);
    }

    function updateHiddenInput() {
      hiddenInput.value = hiddenInput.value = tags.join(', ');
    }

    const subtypeSelect = document.getElementById('subtype_household');
    const otherSubtypeContainer = document.getElementById('other_subtype_container');

    subtypeSelect.addEventListener('change', function() {
    if (this.value === 'other') {
      otherSubtypeContainer.style.display = 'block';
    } else {
      otherSubtypeContainer.style.display = 'none';
    }
  });
  });
</script>
<?= $this->endSection(); ?>

<?= $this->section('styles') ?>
<style>
    .addprod-page {

        background-color: #f8f9fa;
    }
    .addprod-container {
        padding: 20px;
        width: 95%;
        margin: auto;
    }
    .addprod-card {
        width: 100%;
        max-width: 500px;
        margin: auto;
    }
    .card-body {
        padding: 2rem;
    }

    @media (max-width: 576px) {
      .addprod-page {
        overflow-y: auto;
      }  
      .addprod-container {
        align-items: flex-start;
      }
      .addprod-card {
            max-width: 100%;
            transform: none;
            margin-top: 20px;
        }
        .card-body {
            padding: 1.5rem;
        }
    }
</style>
<?= $this->endSection() ?>

