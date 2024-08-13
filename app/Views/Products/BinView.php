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
                  <td>
                    <div class="text-center">
                      <!-- Button trigger modal -->
                      <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#reasonDeleteModal<?= $data->id; ?>">
                        View
                      </button>
                    </div>
                  </td>
                  <td><?= date('d-m-Y', strtotime($data->created_at)); ?></td>
                  <td>
                    <div class="row">
                      <div class="col-md-12 text-center">
                        <!--<button id="btn-edit" type="button" data-bs-toggle="modal" data-bs-target="#editModal<?php //$data->comp_id; ?>" class="btn btn-outline-primary btn-sm" data-bs-toggle="tooltip" title="Edit company">
                          <i class="fa fa-eye"></i>
                        </button>-->
                        <?php if (auth()->user()->inGroup('user')): ?>
                          <?php if ($data->user_id==auth()->user()->id): ?>
                            <button class="btn btn-outline-danger btn-sm btn-flat" type="button" data-bs-toggle="modal" data-bs-target="#delPermanentModal<?= $data->id; ?>">
                              <i class="fa-solid fa-trash"></i>
                            </button>
                          <?php else: ?>
                            <button disabled class="btn btn-outline-danger btn-sm btn-flat" type="button" data-bs-toggle="modal" data-bs-target="#delPermanentModal<?= $data->id; ?>">
                              <i class="fa-solid fa-trash"></i>
                            </button>
                          <?php endif; ?>
                        <?php else: ?>
                          <button class="btn btn-outline-danger btn-sm btn-flat" type="button" data-bs-toggle="modal" data-bs-target="#delPermanentModal<?= $data->id; ?>">
                            <i class="fa-solid fa-trash"></i>
                          </button>
                        <?php endif; ?>
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

<?php foreach ($productData as $data): ?>
<!-- reasonDeleteModal -->
<div class="modal fade" id="reasonDeleteModal<?= $data->id; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Reason Deletion</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <?= $data->reason_deletion; ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- ! -->

<!-- delPermanentModal -->
<div class="modal fade" id="delPermanentModal<?= $data->id; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Confirmation!</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        This record will be permanently deleted
      </div>
      <div class="modal-footer">
        <form method="POST" action="<?= url_to('delProdPermanent', $data->id) ?>">
          <button type="submit" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal">Continue</button>
        </form>
        <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- ! -->
<?php endforeach; ?>

<?= $this->endsection(); ?>