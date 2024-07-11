<?= $this->extend('layouts/app.php'); ?>
<?= $this->section('content'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
<div class="container-fluid">
  <div class="row mb-2">
    <div class="col-sm-6">
      <h2>Product List</h2>
    </div>
  </div>
</div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card w-100">
          <div class="card-header">
          <div class="card-tools">
            <a class="btn btn-block btn-sm btn-default btn-flat border-primary" href="<?= url_to('addProduct'); ?>"><i class="fa fa-plus"></i> Add Product </a>
          </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <!-- Table data -->
            <table class="table table-bordered table-striped dt-responsive nowrap" style="width:100%">
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
                  <td>KIV</td>
                  <td><?= $data->created_at; ?></td>
                  <td><?= $data->updated_at; ?></td>
                  <td>
                    <a class="btn btn-primary btn-sm" href="<?= url_to('displayProdDetail', $data->id); ?>">View</a>
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
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /row -->
  </div>
  <!-- /.container-fluid -->
</section>
  

</div>



<?= $this->endsection(); ?>
<table class="table table-bordered table-striped dt-responsive nowrap" style="width:100%">
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
        <td>KIV</td>
        <td><?= $data->created_at; ?></td>
        <td><?= $data->updated_at; ?></td>
      </tr>
      <?php endforeach; ?>
    <?php else: ?>
      <tr>
        <td colspan="6">No data available</td>
      </tr>
    <?php endif; ?>
    </tbody>
  </table>