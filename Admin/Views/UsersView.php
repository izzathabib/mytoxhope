<!-- Import view from folder layouts and file app.php -->
<?= $this->extend('layouts/app.php'); ?>
<?= $this->section('content'); ?>


<!-- Display page title -->
<div class="container-fluid content-header p-4 mt-2">
  <div class="container-fluid">
    <h2 class="content-header">User List</h2>
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
              <h4><i class="fa fa-info-circle"></i> User Information</h4>
            </div>

            <!-- Create user button -->
            <div class="col-xl-1">
                <a class="btn btn-block btn-sm btn-default btn-flat border-primary" href="<?= url_to('addNewUser'); ?>"><i class="fas fa-plus"></i> <b>Add User</b></a>
            </div>
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
                        <th>Name</th>
                        <th>E-mail</th>
                        <?php if (auth()->user()->inGroup('superadmin')): ?>
                          <th>Company Name</th>
                          <th>Company Registration No</th>
                        <?php endif; ?>
                          <th>Role</th>
                        <?php if (auth()->user()->inGroup('superadmin')): ?>
                          <th>Status</th>
                        <?php endif; ?>
                        <th style="width: 90px;">Action</th>
                      </tr>
                  </thead>
                  <tbody>
                    <?php if (!empty($userData)): ?>
                      <?php foreach ($userData as $data): ?>
                        <tr>
                          <td><?= $data->username; ?></td>
                          <td><?= $data->secret; ?></td>
                          <!-- If current user is Admin PRN & Company Admin -->
                          <?php if (auth()->user()->inGroup('superadmin')): ?>
                            <td><?= $data->comp_name; ?></td>
                            <td><?= $data->comp_reg_no; ?></td>
                          <?php endif; ?>
                          <td>
                            <?php if ($data->group == 'superadmin') : ?>
                              ADMIN PUSAT RACUN 
                            <?php elseif($data->group == 'admin'): ?>
                              Admin
                            <?php else: ?>
                              Staff
                            <?php endif; ?>
                          </td>
                          <?php if (auth()->user()->inGroup('superadmin')): ?>
                            <?php if ($data->status == 'unverified') : ?>
                              <td>
                                <!-- Form section to update status value in users table -->
                                <form method="POST" action="<?= url_to('verifyUser', $data->id); ?>">
                                  <button type="submit" value="Submit" class="btn btn-primary btn-sm">Verify</button>
                                </form>
                              </td>
                            <?php elseif ($data->status == 'verified'): ?>
                              <td><?= 'Verified'; ?></td>
                            <?php endif; ?>
                          <?php endif; ?>
                          <td>
                            <div class="dropdown-toggle btn btn-outline-primary btn-sm" role="button" data-bs-toggle="dropdown">Action</div>
                            <ul class="dropdown-menu">
                              <li><a class="dropdown-item" href="<?= url_to('editUser', $data->id); ?>">Edit</a></li>
                              <li><a class="dropdown-item" href="<?= url_to('deleteUser', $data->id); ?>" data-bs-toggle="modal" data-bs-target="#myModal">Delete</a></li>
                              
                            </ul>
                            <!-- The Modal -->
                              <div class="modal fade" id="myModal">
                                <div class="modal-dialog">
                                  <div class="modal-content">

                                    <!-- Modal Header -->
                                    <div class="modal-header">
                                      <h4 class="modal-title">Confirmation!</h4>
                                    </div>

                                    <!-- Modal body -->
                                    <div class="modal-body">
                                      Are you sure to delete this user?
                                    </div>

                                    <!-- Modal footer -->
                                    <div class="modal-footer">
                                    <form method="POST" action="<?= url_to('deleteUser', $data->id); ?>">
                                      <button type="submit" value="Submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                    <button class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                                    </div>

                                  </div>
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
                  <tfoot>
                    <tr>
                      <th>Name</th>
                      <th>E-mail</th>
                      <?php if (auth()->user()->inGroup('superadmin')): ?>
                        <th>Company Name</th>
                        <th>Company Registration No</th>
                      <?php endif; ?>
                        <th>Role</th>
                      <?php if (auth()->user()->inGroup('superadmin')): ?>
                        <th>Status</th>
                      <?php endif; ?>
                      <th style="width: 90px;">Action</th>
                    </tr>
                  </tfoot>
            </table>
            </div>
            
          </div>
          
        </div>
      </div>
      
    </div>

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

