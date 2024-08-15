<!-- Import view from folder layouts and file app.php -->
<?= $this->extend('layouts/app.php'); ?>
<?= $this->section('content'); ?>


<!-- Display page title -->
<div class="container-fluid content-header p-3 mt-5">
  <div class="container-fluid">
  <div class="d-flex align-items-center mb-1">
  <a href="<?= base_url('dashboard') ?>" class="btn btn-tertiary btn-lg me-1">
    <i class="fas fa-arrow-left"></i>
  </a>
  <h2 class="mb-0"><b>Company List</b></h2>
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
              <h4><i class="fa fa-info-circle"></i> Company Information</h4>
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
            <table id="userslist" class="table table-hover table-bordered"
                  style="width:100%">
                  <thead>
                    <tr>
                      <th>Company Name</th>
                      <th>Company Registration No</th>
                      <th>Company Main Admin</th>
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
                              <td>
                                <span class="badge rounded-pill bg-danger">Unverified</span>
                              </td>
                            <?php elseif ($data->status == 'verified'): ?>
                              <td>
                                <span class="badge  bg-success">Verified</span>
                              </td>
                            <?php endif; ?>
                          <td>
                            <div class="row">
                              <div class="col-md-12 text-center">
                                <button id="btn-edit" type="button" data-bs-toggle="modal" data-bs-target="#editModal<?= $data->comp_id; ?>" class="btn btn-outline-primary btn-sm" data-bs-toggle="tooltip" title="Edit company">
                                  <i class="fa-solid fa-edit"></i>
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
                  <tfoot>
                  <tr>
                      <th>Company Name</th>
                      <th>Company Registration No</th>
                      <th>Company Main Admin</th>
                      <th>Admin E-mail</th>
                      <th>Status</th>
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
    
    <?php foreach ($companyData as $data): ?>
    <!-- Edit Modal -->
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

    <!-- Delete Modal -->
    <div class="modal fade" id="deleteModal<?= $data->id; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">

          <!-- Modal Header -->
          <div class="modal-header">
            <h4 class="modal-title">Confirmation!</h4>
          </div>

          <!-- Modal body -->
          <div class="modal-body">
            Are you sure you want to delete this company? This will also remove all associated users.
          </div>

          <!-- Modal footer -->
          <div class="modal-footer">
            <form method="POST" action="<?= url_to('deleteCompany', $data->comp_id); ?>">
              <button type="submit" value="Submit" class="btn btn-danger btn-sm">Delete</button>
            </form>
            <button class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
          </div>

        </div>
      </div>
    </div>
    <!-- ! -->
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

