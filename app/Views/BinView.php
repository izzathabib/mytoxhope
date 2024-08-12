<?= $this->extend('layouts/app.php'); ?>
<?= $this->section('content'); ?>

<!-- Display page title -->
<div class="container-fluid p-2 mt-5">
  <div class="container-fluid">
    <h2>Product List</h2>
  </div>
</div>

<!-- Main section -->
<div class="container-fluid">
    <div class="row">

      <div class="col-md-12">

        <div class="card w-100 shadow-sm ">

          <!-- Card header -->
          <div class="card-header">
            <div class="card-tools">
            <a class="btn btn-block btn-sm btn-default btn-flat border-primary" href="<?= url_to('addProduct'); ?>"><i class="fa fa-plus"></i> <b>Add Product</b> </a>
            </div>
          </div>
          
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
                  <th>Status</th>
                  <th>Created</th>
                  <th>Modified</th>
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
                  <?php if($data->prod_status=='To Be Deleted'): ?>
                    <?php if(auth()->user()->inGroup('superadmin')) : ?>
                      <td>
                        <div class="row alert alert-danger small text-center p-1 m-1">
                          <div class="col-12">Delete Request</div>
                        </div>
                        <div class="row p-1 m-1  text-center">
                          <div class="col-6">
                            <a class="btn btn-danger  btn-sm text-center" href="<?= url_to('approveDelete', $data->id); ?>">Approve</a>
                          </div>
                          <div class="col-6">
                            <a class="btn btn-secondary  btn-sm text-center" href="<?= url_to('rejectDelete', $data->id); ?>">Reject</a>
                          </div>
                        </div>
                      </td>
                    <?php else: ?>
                      <td><?= $data->prod_status; ?></td>
                    <?php endif; ?>
                  <?php else: ?>
                    <td><?= $data->prod_status; ?></td>
                  <?php endif; ?>
                  <td><?= date('d-m-Y', strtotime($data->created_at)); ?></td>
                  <td><?= date('d-m-Y', strtotime($data->updated_at)); ?></td>
                  <td>
                    <?php if($data->prod_status=='Active'): ?>
                      <a class="btn btn-primary btn-sm" href="<?= url_to('displayProdDetail', $data->id); ?>">View</a>
                    <?php else: ?>
                      <a class="btn btn-primary btn-sm" href="<?= url_to('displayDisconDeleteProd', $data->id); ?>">View</a>
                    <?php endif; ?>
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
