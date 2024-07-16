<?= $this->extend('layouts/app.php'); ?>
<?= $this->section('content'); ?>

<!-- Display page title -->
<div class="container content-header p-4 mt-2">
  <div class="container-fluid">
    <h2 class="content-header">Product List</h2>
  </div>
</div>

<!-- Main section -->
<div class="container">
    <div class="row">

      <div class="col-md-12">

        <div class="card w-100 shadow-sm ">

          <!-- Card header -->
          <div class="card-header">
            <div class="card-tools">
            <a class="btn btn-block btn-sm btn-default btn-flat border-primary" href="<?= url_to('addProduct'); ?>"><i class="fa fa-plus"></i> Add Product </a>
            </div>
          </div>
          
          <!-- Card body -->
          <div class="card-body">
            <!-- Table data -->
            <div class="table-responsive">
            <table class="table table-hover table-bordered" style="width:100%">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Brand</th>
                  <th>Product Name</th>
                  <th>Inactive Ingredients</th>
                  <th>Active Ingredient</th>
                  <th>Status</th>
                  <th>Created</th>
                  <th>Modified</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
              <?php if (!empty($productData)): ?>
                <?php foreach ($productData as $data): ?>
                <tr>
                  <td>1</td>
                  <td><?= $data->brand_name; ?></td>
                  <td><?= $data->product_name; ?></td>
                  <td><?= $data->inactive_ing; ?></td>
                  <td><?= $data->active_ing; ?></td>

                  <td><?= $data->prod_status; ?></td>
                  <td><?= date('d-m-Y', strtotime($data->created_at)); ?></td>
                  <td><?= date('d-m-Y', strtotime($data->updated_at)); ?></td>
                  <td>
                    <a class="btn btn-primary btn-sm btn-flat" href="<?= url_to('displayProdDetail', $data->id); ?>">View</a>
                  </td>
                </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr>
                  <td colspan="6">No data available</td>
                </tr>
              <?php endif; ?>
              </tbody>
            </table>
            </div>
            
          </div>
          
        </div>
        
      </div>
      
    </div>
</div>

<?= $this->endsection(); ?>
