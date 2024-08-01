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
                            <td><?= $data['comp_name']; ?></td>
                            <td><?= $data['comp_reg_no']; ?></td>
                            <td><?= $data['comp_admin']; ?></td>
                            <td><?= $data['comp_email']; ?></td>
                            <?php if ($data['status'] == 'unverified') : ?>
                              <td>
                                <!-- Form section to update status value in users table -->
                                <form method="POST" action="<?= url_to('verifyUser', $data['comp_id']); ?>">
                                  <button type="submit" value="Submit" class="btn btn-primary btn-sm">Verify</button>
                                </form>
                              </td>
                            <?php elseif ($data['status'] == 'verified'): ?>
                              <td><?= 'Verified'; ?></td>
                            <?php endif; ?>
                          <td>
                            <div class="text-center">
                              <a data-bs-toggle="modal" data-bs-target="#myModal" class="btn btn-outline-primary text-center" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit company"  href="<?= url_to('editUser', $data['comp_id']); ?>"><i class="fa-solid fa-pencil"></i></a>
                            </div>
                              <!--
                              <li><a class="dropdown-item" href="<?php //url_to('deleteUser', $data['comp_id']); ?>" data-bs-toggle="modal" data-bs-target="#myModal">Delete</a></li>
                              -->
                            <!-- The Modal -->
                              <div class="modal fade" id="myModal">
                                <div class="modal-dialog modal-lg">
                                  <div class="modal-content">

                                    <!-- Modal Header -->
                                    <div class="modal-header">
                                      <h4 class="modal-title">Company Details</h4>
                                    </div>

                                    <!-- Modal body -->
                                    <div class="modal-body">
                                    <form method="POST" action="<?= url_to('deleteUser', $data['comp_id']); ?>">
                                      <div class="form-floating mb-3 w-100">
                                        <input type="text" class="form-control" name="comp_name" 
                                          value="<?= $data['comp_name'] ?>" id="floatingCompName"inputmode="text" required>
                                        <label for="floatingCompName">Company Name</label>
                                      </div>
                                      <button type="submit" value="Submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                    </div>

                                    <!-- Modal footer -->
                                    <div class="modal-footer">
                                    <form method="POST" action="<?= url_to('deleteUser', $data['comp_id']); ?>">
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

