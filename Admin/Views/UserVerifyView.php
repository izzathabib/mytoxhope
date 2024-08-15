<!-- Import view from folder layouts and file app.php -->
<?= $this->extend('layouts/app.php'); ?>
<?= $this->section('content'); ?>


<!-- Display page title -->
<div class="container-fluid p-3 mt-5">
  <div class="container-fluid">
  <div class="d-flex align-items-center mb-1">
  <a href="<?= base_url('dashboard') ?>" class="btn btn-tertiary btn-lg me-1">
    <i class="fas fa-arrow-left"></i>
  </a>
  <h3 class="mb-0"><b>Verification Request</b></h3>
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

          </div>
          
          </div>
          
          <!-- Card body -->
          <div class="card-body">
            <!-- Table data -->
            <div class="table-responsive">
            <div class="mb-3 d-flex justify-content-end">
              <input type="text" id="searchInput" class="form-control form-control-sm w-25"
                placeholder="Enter search term here...">
            </div>
            <table id="userslist" class="table table-hover table-bordered table-striped"
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
                              <li><button class="dropdown-item" type="button" data-bs-toggle="modal" data-bs-target="#deleteModal<?= $data->id; ?>">Delete</button></li>
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
            <nav aria-label="Page navigation">
              <ul class="pagination justify-content-end" id="pagination">
              </ul>
            </nav>
            </div>
          </div>
        </div>
      </div>
      
    </div>
    
    <?php foreach($userData as $data): ?>
    <!-- The Modal -->
    <div class="modal fade" id="deleteModal<?= $data->id; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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


<!-- Initialize DataTables -->
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const table = document.getElementById('userslist');
    const searchInput = document.getElementById('searchInput');
    const tbody = table.getElementsByTagName('tbody')[0];
    const rows = Array.from(tbody.getElementsByTagName('tr'));
    const itemsPerPage = 10; // Records to be shown per page
    let currentPage = 1;
    let filteredRows = rows;

    function filterRows() {
      const searchTerm = searchInput.value.toLowerCase().trim();
      filteredRows = rows.filter(row => {
        const cells = row.getElementsByTagName('td');
        for (let cell of cells) {
          if (cell.textContent.toLowerCase().includes(searchTerm)) {
            return true;
          }
        }
        return false;
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

    searchInput.addEventListener('input', function () {
      filterRows();
      currentPage = 1; // Reset to first page after search
      setupPagination();
      showPage(currentPage);
    });

    // Initial setup
    setupPagination();
    showPage(currentPage);
  });
</script>

<?= $this->endsection(); ?>

