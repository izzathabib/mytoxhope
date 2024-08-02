<?= $this->extend('layouts/app.php'); ?>
<?= $this->section('content'); ?>

<div class="container-fluid p-5">
  <h4 class="text-left"><b>Update Product Details</b></h4>
  <div class="card w-100 shadow-sm">
    <div class="card-body">
      <form method="POST" action="<?= url_to('saveUpdateDetail', $productData['id']); ?>" enctype="multipart/form-data">
        <div class="row">
          <div class="col-md-6">
            <!-- Product Name -->
            <div class="form-group mb-4">
              <label for="product_name">Product Name</label>
              <input type="text" id="product_name" name="product_name" class="form-control"
                value="<?= $productData['product_name'] ?>">
            </div>

            <!-- Product Image -->
            <div class="form-group mb-4">
              <label for="product_image">Product Image</label>
              <input type="file" id="product_image" name="product_image" class="form-control"
                value="<?= $productData['product_image'] ?>">
              <br>
              <a href="images/product/<?= $productData['product_image'] ?>"
                target="_blank"><?= $productData['product_image'] ?? 'No file uploaded' ?></a>
            </div>

            <!-- Type of Poison -->
            <div class="form-group mb-4">
              <label for="type_poison">Type of Poison</label>
              <select id="type_poison" name="type_poison" class="form-control">
                <option value="Please select" <?php echo isset($productData['type_poison']) && $productData['type_poison'] == 'Please select' ? 'selected' : '' ?>>Please select</option>
                <option value="List 1" <?php echo isset($productData['type_poison']) && $productData['type_poison'] == 'List 1' ? 'selected' : '' ?>>List 1</option>
                <option value="List 2" <?php echo isset($productData['type_poison']) && $productData['type_poison'] == 'List 2' ? 'selected' : '' ?>>List 2</option>
                <option value="List 3" <?php echo isset($productData['type_poison']) && $productData['type_poison'] == 'List 3' ? 'selected' : '' ?>>List 3</option>
              </select>
            </div>

            <!-- Active ingredient -->
            <!-- Active ingredient -->
            <div class="form-group mb-4">
              <label for="active_ing">Active Ingredient/ Chemical Name</label>
              <div class="tag-input">
                <input type="text" id="active_ing_input" class="form-control"
                  placeholder="Type an ingredient and press Enter">
                <div id="tags-container" class="tags-container">
                  <?php if ($productData['active_ing_array']): ?>
                    <?php foreach ($productData['active_ing_array'] as $data): ?>
                      <span class="tag">
                        <?= $data ?>
                        <span class="tag-close">&times;</span>
                      </span>
                    <?php endforeach; ?>
                  <?php endif; ?>
                </div>
              </div>
              <input type="hidden" id="active_ing" name="active_ing" value="">
            </div>

            <!-- Inactive ingredient -->
            <div class="form-group mb-4">
              <label for="inactive_ing">Inactive Ingredients</label>
              <textarea id="inactive_ing" name="inactive_ing"
                class="form-control"><?= $productData['inactive_ing'] ?></textarea>
            </div>
          </div>

          <div class="col-md-6">
            <!-- Brand Name -->
            <div class="form-group mb-4">
              <label for="brand_name">Brand Name</label>
              <input type="text" id="brand_name" name="brand_name" class="form-control"
                value="<?= $productData['brand_name'] ?>">
            </div>

            <!-- Product MSDS -->
            <div class="form-group mb-4">
              <label for="msds">Product MSDS</label>
              <input type="file" id="msds" name="msds" class="form-control"><br>
              <a href="documents/<?= $productData['msds'] ?>"
                target="_blank"><?= $productData['msds'] ?? 'No file uploaded' ?></a>
            </div>

            <!-- Subtype of Household / Consumer Product -->
            <div class="form-group mb-4">
              <label for="subtype_household">Subtype of Household / Consumer Product</label>
              <select id="subtype_household" name="subtype_household" class="form-control">
                <option value="Please select" <?php echo isset($productData['subtype_household']) && $productData['subtype_household'] == 'Please select' ? 'selected' : '' ?>>Please select</option>
                <option value="Agricultural/Garden" <?php echo isset($productData['subtype_household']) && $productData['subtype_household'] == 'Agricultural/Garden' ? 'selected' : '' ?>>Agricultural/Garden</option>
                <option value="Environmental Contaminant" <?php echo isset($productData['subtype_household']) && $productData['subtype_household'] == 'Environmental Contaminant' ? 'selected' : '' ?>>Environmental Contaminant
                </option>
                <option value="Household/Leisure" <?php echo isset($productData['subtype_household']) && $productData['subtype_household'] == 'Household/Leisure' ? 'selected' : '' ?>>Household/Leisure</option>
                <option value="Industrial/Commercial" <?php echo isset($productData['subtype_household']) && $productData['subtype_household'] == 'Industrial/Commercial' ? 'selected' : '' ?>>Industrial/Commercial</option>
                <option value="Mixture of Agents" <?php echo isset($productData['subtype_household']) && $productData['subtype_household'] == 'Mixture of Agents' ? 'selected' : '' ?>>Mixture of Agents</option>
                <option value="Natural Toxin" <?php echo isset($productData['subtype_household']) && $productData['subtype_household'] == 'Natural Toxin' ? 'selected' : '' ?>>Natural Toxin</option>
                <option value="Pharmaceutical" <?php echo isset($productData['subtype_household']) && $productData['subtype_household'] == 'Pharmaceutical' ? 'selected' : '' ?>>Pharmaceutical</option>
                <option value="Pesticide" <?php echo isset($productData['subtype_household']) && $productData['subtype_household'] == 'Pesticide' ? 'selected' : '' ?>>Pesticide</option>
                <option value="Substance of Abuse" <?php echo isset($productData['subtype_household']) && $productData['subtype_household'] == 'Substance of Abuse' ? 'selected' : '' ?>>Substance of Abuse</option>
                <option value="Unknown Function" <?php echo isset($productData['subtype_household']) && $productData['subtype_household'] == 'Unknown Function' ? 'selected' : '' ?>>Unknown Function</option>
                <option value="other" <?php echo isset($productData['subtype_household']) && $productData['subtype_household'] == 'other' ? 'selected' : '' ?>>Other (Please describe)</option>
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
            <button type="submit" value="Submit" class="btn btn-primary">Update</button>
            <a href="javascript:history.back()" class="btn btn-secondary">Cancel</a>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<script>
  document.addEventListener('DOMContentLoaded', function () {

    const productData = <?= json_encode($productData) ?>; // Convert to JSON for safety
    const activeIngredients = productData.active_ing_array || [];
    const initialTags = activeIngredients.join(', ');
    let tags = initialTags.split(', ');

    const input = document.getElementById('active_ing_input');
    const tagsContainer = document.getElementById('tags-container');
    const hiddenInput = document.getElementById('active_ing');
    hiddenInput.value = tags;

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
      hiddenInput.value = tags.join(', ');
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