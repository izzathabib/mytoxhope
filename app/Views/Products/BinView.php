<?= $this->extend('layouts/app.php'); ?>
<?= $this->section('content'); ?>

<!-- Display page title -->
<div class="container-fluid p-2 mt-5">
  <div class="container-fluid">
  <div class="d-flex align-items-center mb-1">
      <a href="<?= base_url('dashboard') ?>" class="btn btn-tertiary btn-lg me-3">
        <i class="fas fa-arrow-left"></i>
      </a>
      <h2 class="mb-0"><b>Deleted Product</b></h2>
    </div>
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
            <div class="mb-3 d-flex justify-content-end">
              <input type="text" id="globalSearchInput" class="form-control form-control-sm w-25"
                placeholder="Enter search term here...">
            </div>
            <table id="delprod" class="table table-hover table-bordered table-striped" style="width:100%">
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
              <tfoot>
              <tr id="column-filters">
                  <th><input type="hidden" class="form-control column-search" placeholder="Search #">#</th>
                  <?php if (auth()->user()->inGroup('superadmin')): ?>
                    <th><input type="text" class="form-control column-search" placeholder="Search Company"></th>
                  <?php endif; ?>
                  <th><input type="text" class="form-control column-search" placeholder="Search Brand"></th>
                  <th><input type="text" class="form-control column-search" placeholder="Search Product Name"></th>
                  <th><input type="text" class="form-control column-search" placeholder="Search Inactive Ingredients">
                  </th>
                  <th><input type="text" class="form-control column-search" placeholder="Search Active Ingredient"></th>
                  <th><input type="hidden" class="form-control column-search" placeholder="Search Reason">Reason</th>
                  <th><input type="text" class="form-control column-search" placeholder="Search Deleted Date"></th>
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
        This record will be deleted. Proceed to deletion?
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

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const table = document.getElementById('delprod');
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
