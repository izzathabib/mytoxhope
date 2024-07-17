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
              <h4>User Information</h4>
            </div>

            <!-- Create user button -->
            <!-- Only for [superadmin,admin] -->
            <?php  if (auth()->user()->inGroup('superadmin')) : ?>
            <div class="col-xl-1">
                <a class="btn btn-block btn-sm btn-default btn-flat border-primary" href="<?= url_to('addNewUser'); ?>">Add User</a>
            </div>
            <?php endif; ?>
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
                        <th>Status</th>
                      <?php endif; ?>
                      <?php if (auth()->user()->inGroup('superadmin','admin')): ?>
                        <th style="width: 90px;">Action</th>
                      <?php endif; ?>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if (!empty($userData)): ?>
                      <?php foreach ($userData as $data): ?>
                        <tr>
                          <td><?= $data->username; ?></td>
                          <td><?php echo 'KIV'; ?></td>
                          <!-- If current user is Admin PRN & Company Admin -->
                          <?php if (auth()->user()->inGroup('superadmin')): ?>
                            <td><?= $data->comp_name; ?></td>
                            <td><?= $data->comp_reg_no; ?></td>
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
                          <!-- Display action button for Admin PRN and Admin company -->
                          <?php if (auth()->user()->inGroup('superadmin','admin')): ?>
                            <td>
                            <button type="button" class="btn btn-default btn-sm btn-flat border-info wave-effect text-info dropdown-toggle nav-item dropdown" data-bs-toggle="dropdown" aria-expanded="true">
                            Action
                              <div class="dropdown-menu">
                                <a class="dropdown-item" href="#">Edit</a>
                                <a class="dropdown-item" href="#">Delete</a>
                              </div>
                            </button>
                            </td>
                          <?php endif; ?>
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
                        <th>Status</th>
                        
                      <?php endif; ?>
                      <?php if (auth()->user()->inGroup('superadmin','admin')): ?>
                        <th style="width: 90px;">Action</th>
                      <?php endif; ?>
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

