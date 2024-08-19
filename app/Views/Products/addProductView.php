<?= $this->extend('layouts/app.php'); ?>
<?= $this->section('bodyClass') ?>addprod-page<?= $this->endSection() ?>
<?= $this->section('content'); ?>

<div class="mt-5">
<div class="addprod-container p-3">
<div class="d-flex align-items-center mb-3" style="margin-left: 40px;">
  <a href="<?= site_url('list-product'); ?>" class="btn btn-tertiary btn-lg me-3">
    <i class="fas fa-arrow-left"></i>
  </a>
  <h4 class="mb-0"><b>Register New Product</b></h4>
</div>
<div class="card shadow-sm addprod-container">
    <div class="card-body">
      
      <form method="POST" action="<?= url_to('saveProdDetail'); ?>" enctype="multipart/form-data" class="needs-validation">
        <div class="row">
          <div class="col-md-6">

            <!-- Select company option for superadmin -->
            <?php if (auth()->user()->inGroup('superadmin')): ?>
              <div class="form-group mb-4">
              <label for="comp_name" style="margin-bottom: 5px;"><b>Select Company</b></label>
              <select value="<?= old('comp_name') ?>" id="comp_name" name="comp_name" class="form-select">
                <option value="Please select">Please select</option>
                <?php foreach($companyData as $data): ?>
                  <option value="<?= $data['comp_admin'] ?>"><?= $data['comp_name'] ?></option>
                <?php endforeach; ?>
              </select>
              <!-- Error message -->
              <?php if(isset(session('errors')['comp_name'])): ?>
                <div class="invalid-feedback"><?= session('errors')['comp_name'] ?></div>
              <?php endif ?>
              <!-- Error message -->
              </div>
            <?php else: ?>
              <input value="<?= $companyData ?>" type="hidden" name="comp_name">
            <?php endif; ?>

            <!-- Product Name -->
            <div class="form-group mb-4">
              <label for="product_name" style="margin-bottom: 5px;"><b>Product Name</b><span class="required"> *</span></label>
              <input value="<?= old('product_name') ?>" type="text" id="product_name" name="product_name" class="form-control" required>
              <!-- Error message -->
              <?php if(isset(session('errors')['product_name'])): ?>
                <div class="invalid-feedback"><?= session('errors')['product_name'] ?></div>
              <?php endif ?>
              <!-- Error message -->
            </div>

            <!-- Product Image -->
            <div class="form-group mb-4">
              <label for="product_image" style="margin-bottom: 5px;"><b>Product Image</b></label>
              <input value="<?= old('product_image') ?>" type="file" id="product_image" name="product_image" class="form-control">
              <!-- Error message -->
              <?php if (session('image') !== null): ?>
                <div class="invalid-feedback"><?= session('image') ?></div>
              <?php elseif (isset(session('errors')['product_image'])): ?>
                <div class="invalid-feedback"><?= session('errors')['product_image'] ?></div>
              <?php endif ?>
              <!-- Error message -->
            </div>
            
            <!-- Type of Poison -->
            <div class="form-group mb-4">
              <label for="type_poison" style="margin-bottom: 5px;"><b>Type of Poison</b></label>
              <select value="<?= old('type_poison') ?>" id="type_poison" name="type_poison" class="form-select">
                <option value="Please select">Please select</option>
                <option value="List 1">List 1</option>
                <option value="List 2">List 2</option>
                <option value="List 3">List 3</option>
              </select>
              <!-- Error message -->
              <?php if(isset(session('errors')['type_poison'])): ?>
                <div class="invalid-feedback"><?= session('errors')['type_poison'] ?></div>
              <?php endif ?>
              <!-- Error message -->
            </div>

            <!-- Active ingredient -->
            <div class="form-group mb-4 ">
              <label for="active_ing" style="margin-bottom: 5px;"><b>Active Ingredient/ Chemical Name</b><span class="required"> *</span></label>
              <div class="tag-input ">
                <input type="text" id="active_ing_input" class="form-control"
                  placeholder="Type an ingredient and press Enter">
                <!-- Error message -->
                <?php if(isset(session('errors')['active_ing'])): ?>
                  <div class="invalid-feedback"><?= session('errors')['active_ing'] ?></div>
                <?php endif ?>
                <!-- Error message -->
                <div id="tags-container" class="tags-container"></div>
              </div>
              <input value="<?= old('active_ing') ?>" type="hidden" id="active_ing" name="active_ing" required>
            </div>

            <!-- Inactive ingredient -->
            <div class="form-group mb-4">
              <label for="inactive_ing" style="margin-bottom: 5px;"><b>Inactive Ingredients</b></label>
              <textarea value="<?= old('inactive_ing') ?>" id="inactive_ing" name="inactive_ing" class="form-control"></textarea>
              <!-- Error message -->
              <?php if(isset(session('errors')['inactive_ing'])): ?>
                <div class="invalid-feedback"><?= session('errors')['inactive_ing'] ?></div>
              <?php endif ?>
              <!-- Error message -->
            </div>
          </div>

          <div class="col-md-6">
            <!-- Brand Name -->
            <div class="form-group mb-4">
              <label for="brand_name" style="margin-bottom: 5px;"><b>Brand Name</b><span class="required"> *</span></label>
              <input value="<?= old('brand_name') ?>" type="text" id="brand_name" name="brand_name" class="form-control" required>
              <!-- Error message -->
              <?php if(isset(session('errors')['brand_name'])): ?>
                <div class="invalid-feedback"><?= session('errors')['brand_name'] ?></div>
              <?php endif ?>
              <!-- Error message -->
            </div>

            <!-- Product MSDS -->
            <div class="form-group mb-4">
              <label for="msds" style="margin-bottom: 5px;"><b>Product MSDS</b><span class="required"> *</span></label>
              <input value="<?= old('msds') ?>" type="file" id="msds" name="msds" class="form-control" required>
              <!-- Error message -->
              <?php if (session('msds') !== null): ?>
                <div class="invalid-feedback"><?= session('msds') ?></div>
              <?php elseif (isset(session('errors')['msds'])): ?>
                <div class="invalid-feedback"><?= session('errors')['msds'] ?></div>
              <?php endif ?>
              <!-- Error message -->
            </div>

            <!-- Subtype of Household / Consumer Product -->
            <div class="form-group mb-4">
              <label for="subtype_household" style="margin-bottom: 5px;"><b>Subtype of Household / Consumer Product</b></label>
              <select value="<?= old('subtype_household') ?>" id="subtype_household" name="subtype_household" class="form-select">
                <option value="Please select">Please select</option>
                <option value="Agricultural/Garden">Agricultural/Garden</option>
                <option value="Environmental Contaminant">Environmental Contaminant</option>
                <option value="Household/Leisure">Household/Leisure</option>
                <option value="Industrial/Commercial">Industrial/Commercial</option>
                <option value="Mixture of Agents">Mixture of Agents</option>
                <option value="Natural Toxin">Natural Toxin</option>
                <option value="Pharmaceutical">Pharmaceutical</option>
                <option value="Pesticide">Pesticide</option>
                <option value="Substance of Abuse">Substance of Abuse</option>
                <option value="Unknown Function">Unknown Function</option>
                <option value="other">Other (Please describe)</option>
              </select>
              <!-- Error message -->
              <?php if(isset(session('errors')['subtype_household'])): ?>
                <div class="invalid-feedback"><?= session('errors')['subtype_household'] ?></div>
              <?php endif ?>
              <!-- Error message -->
            </div>
            <div id="other_subtype_container" class="form-group mb-4" style="display: none;">
              <label for="other_subtype">Please describe:</label>
              <input type="text" id="other_subtype" name="other_subtype" class="form-control">
            </div>
            <p aria-hidden="true" id="required-description">
            <span class="required">*</span>Required field</p>
          </div>
        </div>

        <!-- Submit and Cancel buttons -->
        <div class="row mt-3">
          <div class="col-md-12 text-center">
            <button type="submit" value="Submit" class="btn btn-primary">Add Product</button>
            <a href="<?= site_url('list-product'); ?>" class="btn btn-secondary">Cancel</a>
          </div>
        </div>
      </form>
    </div>
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

    subtypeSelect.addEventListener('change', function () {
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

  .required {
    color: red;
  }

  @media (max-width: 576px) {
    .addprod-page {
      overflow-y: auto;
    }

    .addprod-container {
      align-items: flex-start;
      width: 95%;
      padding: 10px;
    }

    .addprod-card {
      max-width: 100%;
      transform: none;
      margin-top: 20px;
    }

    .card-body {
      padding: 1rem;
    }
  }
</style>
<?= $this->endSection() ?>