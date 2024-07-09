<!-- Import view from folder layouts and file app.php -->
<?= $this->extend('layouts/app.php'); ?>
<?= $this->section('content'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h2>Users List</h2>
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
              <h3 class="card-title">Users Information</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">


              <!-- Table data -->
              <div class="table-responsive">
                <table id="userslist" class="table table-bordered table-striped dt-responsive nowrap"
                  style="width:100%">
                  <thead>
                    <tr>
                      <th>Name</th>
                      <th>Company Name</th>
                      <th>Company Registration No</th>
                      <th>E-mail</th>
                      <th>Status</th>
                      <th style="width: 90px;">Action</thdata
                    </tr>
                  </thead>
                  <tbody>
                    <?php if (!empty($companyData)): ?>
                      <?php foreach ($companyData as $data): ?>
                        <tr>
                          <td><?= $data['comp_admin']; ?></td>
                          <td><?= $data['comp_name']; ?></td>
                          <td><?= $data['comp_reg_no']; ?></td>
                          <td><?= $data['comp_email']; ?></td>
                          <td><?= $data['status']; ?></td>
                          <td>
                            <button type="button" class="btn btn-default btn-sm btn-flat border-info wave-effect text-info dropdown-toggle nav-item dropdown" data-bs-toggle="dropdown" aria-expanded="true">
                            Action
                              <div class="dropdown-menu">
                                <a class="dropdown-item" href="javascript:void(0)" data-id="<?php echo $data['id'] ?>">Verify</a>
                                <a class="dropdown-item" href="./index.php?page=edit_user&id=<?php echo $data['id'] ?>">Edit</a>
                                <a class="dropdown-item" href="javascript:void(0)" data-id="<?php echo $data['id'] ?>">Delete</a>
                              </div>
                            </button>
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
                      <th>Company Name</th>
                      <th>Status</th>
                      <th style="width: 120px;">Action</th>
                    </tr>
                  </tfoot>
                </table>
              </div>
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
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

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