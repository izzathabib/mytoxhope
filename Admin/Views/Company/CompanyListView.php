<!-- Import view from folder layouts and file app.php -->
<?= $this->extend('layouts/app.php'); ?>
<?= $this->section('content'); ?>


<!-- Display page title -->
<div class="container-fluid content-header p-4 mt-2">
  <div class="container-fluid">
    <h2 class="content-header">Company List</h2>
  </div>
</div>

<!-- Main section -->
<div class="container-fluid">
    <div class="row">

      <div class="col-lg-12">
        <div class="card w-100 shadow-sm ">
          <!-- Card header -->
          <div class="card-header">
          <div class="row">

            <div class="col">
              <h4><i class="fa fa-info-circle"></i> Company Information</h4>
            </div>

            <!-- Create user button -->
            <!--
            <div class="col-xl-1">
              a class="btn btn-block btn-sm btn-default btn-flat border-primary" href="<?= url_to('addNewUser'); ?>"><i class="fas fa-plus"></i> <b>Add User</b></a>
            </div>
            -->
          </div>
          
          </div>
          
          <!-- Card body -->
          <div class="card-body">
            <!-- Table data -->
            <div class="table-responsive">
            <table id="userslist" class="table table-hover table-bordered"
                  style="width:100%">
                  <thead>
                    <tr>
                      <th>Company Name</th>
                      <th>Company Registration No</th>
                      <th>Company Admin</th>
                      <th>Admin E-mail</th>
                      <th>Status</th>
                      <th style="width: 90px;">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if (!empty($companyData)): ?>
                      <?php foreach ($companyData as $data): ?>
                        <tr>
                            <td><?= $data->comp_name; ?></td>
                            <td><?= $data->comp_reg_no; ?></td>
                            <td><?= $data->username; ?></td>
                            <td><?= $data->secret; ?></td>
                            <?php if ($data->status == 'unverified') : ?>
                              <td><?= 'Unverified'; ?></td>
                            <?php elseif ($data->status == 'verified'): ?>
                              <td><?= 'Verified'; ?></td>
                            <?php endif; ?>
                          <td>
                            <!-- Edit button -->
                            <div class="text-center">
                              <button id="btn-edit" type="button" data-bs-toggle="modal" data-bs-target="#editModal<?= $data->comp_id; ?>" class="btn btn-outline-primary text-center" data-bs-toggle="tooltip" title="Edit company">
                              <i class="fa-solid fa-edit"></i>
                              </button>
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
    
    <?php foreach ($companyData as $data): ?>
    <!-- The Modal -->
    <div class="modal fade" id="editModal<?= $data->comp_id; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <form method="POST" action="<?= url_to('saveEditCompany', $data->comp_id) ?>">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Update Company Details</h4>
        </div>

        <!-- Modal body -->
        <div class="modal-body">

        

        <div class="form-group">
          <label for="comp_nama">Company Name</label>
          <input type="text" class="form-control" id="comp_name" name="comp_name" value="<?= $data->comp_name ?>">
        </div>

        <div class="form-group">
          <label for="comp_reg_nom">Company Registration No</label>
          <input type="text" class="form-control" id="comp_reg_no" name="comp_reg_no" value="<?= $data->comp_reg_no ?>">
        </div>
        
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Update</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>

        </div>

      </div>
      </form>
    </div>
    </div>
    <!-- / -->
    <?php endforeach; ?>
</div>


<!-- Initialize DataTables -->
<script>
  $(document).ready(function () {
    $('#userslist').DataTable({
      responsive: true,
      autoWidth: false,
      lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
      language: {
        lengthMenu: "Show _MENU_ entries",
        search: "Search:",
        searchPlaceholder: "Enter search term"
      },
      dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>' +
        '<"row"<"col-sm-12"tr>>' +
        '<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>'
    });
    
  });
</script>

<?= $this->endsection(); ?>

