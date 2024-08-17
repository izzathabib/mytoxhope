<!-- Import view from folder layouts and file app.php -->
<?= $this->extend('layouts/app.php'); ?>
<?= $this->section('content'); ?>


<!-- Display page title -->
<div class="container-fluid p-3 mt-5">
  <div class="container-fluid">
    <div class="d-flex align-items-center mb-1">
      <a href="<?= base_url('dashboard') ?>" class="btn btn-tertiary btn-lg me-3">
        <i class="fas fa-arrow-left"></i>
      </a>
      <h2 class="mb-0"><b>User List</b></h2>
    </div>
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
            <div class="col-md-2 text-center">
              <a class="btn btn-sm btn-outline-primary container-fluid text-nowrap"
                href="<?= url_to('addNewUser'); ?>"><b>Add User</b></a>
            </div>
          </div>

        </div>
        <!-- Card body -->
        <div class="card-body">
          <!-- Table data -->
          <div class="table-responsive">
            <div class="mb-3 d-flex justify-content-end">
              <input type="text" id="globalSearchInput" class="form-control form-control-sm w-25"
                placeholder="Enter search term here...">
            </div>
            <table id="userslist" class="table table-hover table-bordered table-striped" style="width:100%">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>E-mail</th>
                  <?php if (auth()->user()->inGroup('superadmin')): ?>
                    <th>Company Name</th>
                    <th>Company Registration No</th>
                  <?php endif; ?>
                  <?php if (auth()->user()->inGroup('admin')): ?>
                    <th>Role</th>
                  <?php endif; ?>
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
                        <td>
                          <?php if ($data->group == 'superadmin'): ?>
                            <span class="badge bg-primary"><?= $data->comp_name; ?></span>
                          <?php else: ?>
                            <?= $data->comp_name; ?>
                          <?php endif; ?>
                        </td>
                        <td><?= $data->comp_reg_no; ?></td>
                      <?php endif; ?>
                      <?php if (auth()->user()->inGroup('admin')): ?>
                        <td>
                          <?php if ($data->group == 'admin'): ?>
                            <span class="badge rounded-pill bg-success">Admin</span>
                          <?php else: ?>
                            <span class="badge rounded-pill bg-secondary">Staff</span>
                          <?php endif; ?>
                        </td>
                      <?php endif; ?>
                      <?php if (auth()->user()->inGroup('superadmin')): ?>
                        <?php if ($data->status == 'unverified'): ?>
                          <td>
                            <div class="text-center">
                              <div class="badge rounded-pill text-bg-danger"><?= 'Unverified'; ?></div>
                            </div>
                          </td>
                        <?php elseif ($data->status == 'verified'): ?>
                          <td>
                            <div class="text-center">
                              <div class="badge rounded-pill text-bg-success"><?= 'Verified'; ?></div>
                            </div>
                          </td>
                        <?php endif; ?>
                      <?php endif; ?>
                      <td>
                        <div class="dropdown-toggle btn btn-outline-primary btn-sm" role="button" data-bs-toggle="dropdown">
                          Action</div>
                        <ul class="dropdown-menu">
                          <li><a class="dropdown-item" href="<?= url_to('editUser', $data->id); ?>">Edit</a></li>
                          <li><button class="dropdown-item" type="button" data-bs-toggle="modal"
                              data-bs-target="#deleteModal<?= $data->id; ?>">Delete</button></li>
                        </ul>

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
                <tr id="column-filters">
                  <th><input type="text" class="form-control column-search" placeholder="Search Name"></th>
                  <th><input type="text" class="form-control column-search" placeholder="Search E-mail"></th>
                  <?php if (auth()->user()->inGroup('superadmin')): ?>
                    <th><input type="text" class="form-control column-search" placeholder="Search Company Name"></th>
                    <th><input type="text" class="form-control column-search" placeholder="Search Company Reg No"></th>
                  <?php endif; ?>
                  <?php if (auth()->user()->inGroup('admin')): ?>
                    <th><input type="text" class="form-control column-search" placeholder="Search Role"></th>
                  <?php endif; ?>
                  <?php if (auth()->user()->inGroup('superadmin')): ?>
                    <th><input type="text" class="form-control column-search" placeholder="Search Status"></th>
                  <?php endif; ?>
                  <th>Action</th>
                </tr>
              </tfoot>
            </table>
            <nav aria-label="Page navigation">
              <ul class="pagination justify-content-end" id="pagination">
              </ul>
            </nav>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php foreach ($userData as $data): ?>
    <!-- The Modal -->
    <div class="modal fade" id="deleteModal<?= $data->id; ?>" tabindex="-1" aria-labelledby="exampleModalLabel"
      aria-hidden="true">
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
  <?php endforeach; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const table = document.getElementById('userslist');
    const globalSearchInput = document.getElementById('globalSearchInput');
    const columnSearchInputs = document.querySelectorAll('#column-filters .column-search');
    const tbody = table.getElementsByTagName('tbody')[0];
    const rows = Array.from(tbody.getElementsByTagName('tr'));
    const itemsPerPage = 10; // Records to be shown per page
    let currentPage = 1;
    let filteredRows = rows;

    function filterRows() {
      const globalSearchTerm = globalSearchInput.value.toLowerCase().trim();

      filteredRows = rows.filter(row => {
        const cells = Array.from(row.getElementsByTagName('td'));

        // Global search
        const matchesGlobalSearch = globalSearchTerm === '' || cells.some(cell =>
          cell.textContent.toLowerCase().includes(globalSearchTerm)
        );

        // Column-specific search
        const matchesColumnSearch = Array.from(columnSearchInputs).every((input, index) => {
          if (!input.value.trim()) return true;
          const cellText = cells[index].textContent.toLowerCase();
          return cellText.includes(input.value.toLowerCase().trim());
        });

        return matchesGlobalSearch && matchesColumnSearch;
      });

      return filteredRows;
    }

    function showPage(page) {
      const start = (page - 1) * itemsPerPage;
      const end = start + itemsPerPage;

      rows.forEach(row => row.style.display = 'none');
      filteredRows.slice(start, end).forEach(row => row.style.display = '');
    }

    function setupPagination() {
      const pageCount = Math.ceil(filteredRows.length / itemsPerPage);
      const paginationElement = document.getElementById('pagination');
      paginationElement.innerHTML = '';

      // Add "Previous" button
      const prevLi = document.createElement('li');
      prevLi.classList.add('page-item');
      prevLi.classList.toggle('disabled', currentPage === 1);
      const prevA = document.createElement('a');
      prevA.classList.add('page-link');
      prevA.href = '#';
      prevA.textContent = 'Previous';
      prevA.addEventListener('click', function (e) {
        e.preventDefault();
        if (currentPage > 1) {
          currentPage--;
          showPage(currentPage);
          setupPagination();
        }
      });
      prevLi.appendChild(prevA);
      paginationElement.appendChild(prevLi);

      // Add numbered pages
      for (let i = 1; i <= pageCount; i++) {
        const li = document.createElement('li');
        li.classList.add('page-item');
        if (i === currentPage) li.classList.add('active');

        const a = document.createElement('a');
        a.classList.add('page-link');
        a.href = '#';
        a.textContent = i;

        a.addEventListener('click', function (e) {
          e.preventDefault();
          currentPage = i;
          showPage(currentPage);
          setupPagination();
        });

        li.appendChild(a);
        paginationElement.appendChild(li);
      }

      // Add "Next" button
      const nextLi = document.createElement('li');
      nextLi.classList.add('page-item');
      nextLi.classList.toggle('disabled', currentPage === pageCount);
      const nextA = document.createElement('a');
      nextA.classList.add('page-link');
      nextA.href = '#';
      nextA.textContent = 'Next';
      nextA.addEventListener('click', function (e) {
        e.preventDefault();
        if (currentPage < pageCount) {
          currentPage++;
          showPage(currentPage);
          setupPagination();
        }
      });
      nextLi.appendChild(nextA);
      paginationElement.appendChild(nextLi);
    }

    function updateTable() {
      filterRows();
      currentPage = 1;
      setupPagination();
      showPage(currentPage);
    }

    globalSearchInput.addEventListener('input', updateTable);

    columnSearchInputs.forEach(input => {
      input.addEventListener('input', updateTable);
    });

    // Initial setup
    setupPagination();
    showPage(currentPage);

    // SweetAlert for success message
    <?php if (session()->getFlashdata('success')): ?>
      Swal.fire({
        position: 'top-end',
        toast: true,
        backgroundColor: '#28a745',
        titleColor: '#fff',
        title: 'Success!',
        text: '<?= session()->getFlashdata('success') ?>',
        icon: 'success',
        showConfirmButton: false,
        timer: 5000,
        timerProgressBar: true
      });
    <?php endif; ?>
  });
</script>

<?= $this->endsection(); ?>