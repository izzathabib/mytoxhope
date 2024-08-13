<?= $this->extend('layouts/app.php'); ?>
<?= $this->section('content'); ?>

<!-- Display page title -->
<div class="container-fluid p-2 mt-5">
  <div class="container-fluid">
    <h4>Delete Product</h4>
  </div>
</div>

<!-- Main section -->
<div class="container-fluid">
    <div class="row">

      <div class="col-md-12">

        <div class="card w-100 shadow-sm ">

          <!-- Card header -->
          <!--<div class="card-header">
            <div class="card-tools">
            <a class="btn btn-block btn-sm btn-default btn-flat border-primary" href="<?= url_to('addProduct'); ?>"><i class="fa fa-plus"></i> <b>Add Product</b> </a>
            </div>
          </div>-->
          
          <!-- Card body -->
          <div class="card-body">
            <!-- Table data -->
            <div class="table-responsive">
            <table class="table table-hover table-bordered table-striped" style="width:100%">
              <thead>
                <tr>
                  <th>#</th>
                  <?php if(auth()->user()->inGroup('superadmin')): ?>
                    <th>Company</th>
                  <?php endif; ?>
                  <th>Brand</th>
                  <th>Product Name</th>
                  <th>Inactive Ingredients</th>
                  <th>Active Ingredient</th>
                  <th>Reason</th>
                  <th>Deleted Date</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
              <?php if (!empty($productData)): ?>
                <?php $i = 1; ?>
                <?php foreach ($productData as $data): ?>
                <tr>
                  <td><?= $i++; ?></td>
                  <?php if(auth()->user()->inGroup('superadmin')): ?>
                    <td><?= $data->comp_name; ?></td>
                  <?php endif; ?>
                  <td><?= $data->brand_name; ?></td>
                  <td><?= $data->product_name; ?></td>
                  <td><?= $data->inactive_ing; ?></td>
                  <td><?= $data->active_ing; ?></td>
                  <td><?= $data->reason_deletion; ?></td>
                  <td><?= date('d-m-Y', strtotime($data->created_at)); ?></td>
                  <td>
                    <div class="row">
                      <div class="col-md-12 text-center">
                        <button id="btn-edit" type="button" data-bs-toggle="modal" data-bs-target="#editModal<?= $data->comp_id; ?>" class="btn btn-outline-primary btn-sm" data-bs-toggle="tooltip" title="Edit company">
                          <i class="fa fa-eye"></i>
                        </button>

                        <button class="btn btn-outline-danger btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#deleteModal<?= $data->id; ?>">
                          <i class="fa-solid fa-trash"></i>
                        </button>
                      </div>
                    </div>
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
