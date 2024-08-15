<?= $this->extend('layouts/app.php'); ?>
<?= $this->section('content'); ?>

<!-- Display page title -->
<div class="container-fluid p-2 mt-5">
  <div class="container-fluid">
  <div class="d-flex align-items-center mb-1">
      <a href="<?= base_url('dashboard') ?>" class="btn btn-tertiary btn-lg me-3">
        <i class="fas fa-arrow-left"></i>
      </a>
      <h2 class="mb-0"><b>Product List</b></h2>
    </div>
  </div>
</div>

<!-- Main section -->
<div class="container-fluid">
    <div class="row">

      <div class="col-md-12">

        <div class="card w-100 shadow-sm ">

          <!-- Card header -->
          <div class="card-header">
            <div class="card-tools">
            <a class="btn btn-block btn-sm btn-default btn-flat border-primary" href="<?= url_to('addProduct'); ?>"><i class="fa fa-plus"></i> <b>Add Product</b> </a>
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
            <table id="prodlist" class="table table-hover table-bordered table-striped" style="width:100%">
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
                  <th>Status</th>
                  <th>Created</th>
                  <th>Modified</th>
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
                    <?php if($data->prod_status=='Active'): ?>
                      <span class="badge bg-success"><?= $data->prod_status; ?></span>
                    <?php elseif ($data->prod_status=='Discontinued'): ?>
                      <span class="badge bg-secondary"><?= $data->prod_status; ?></span>
                    <?php elseif ($data->prod_status=='To Be Deleted'): ?>
                      <?php if (auth()->user()->inGroup('superadmin')): ?>
                        <div class="row alert alert-danger small text-center p-1 m-1 text-nowrap">
                          <div class="col-12">Delete Request</div>
                        </div>
                        <div class="text-center">
                          <a class="btn btn-outline-danger  btn-sm text-center" href="<?= url_to('approveDelete', $data->id); ?>">
                            <i class="fas fa-check"></i>
                          </a>
                          <a class="btn btn-outline-secondary  btn-sm text-center" href="<?= url_to('rejectDelete', $data->id); ?>">
                            <i class="fas fa-times"></i>
                          </a>
                        </div>
                      <?php else: ?>
                        <span class="badge bg-danger"><?= $data->prod_status; ?></span>
                      <?php endif; ?>
                    <?php endif; ?>
                  </td>
                  <td><?= date('d-m-Y', strtotime($data->created_at)); ?></td>
                  <td><?= date('d-m-Y', strtotime($data->updated_at)); ?></td>
                  <td>
                    <?php if($data->prod_status=='Active'): ?>
                      <a class="btn btn-outline-primary btn-sm" href="<?= url_to('displayProdDetail', $data->id); ?>">View</a>
                    <?php else: ?>
                      <a class="btn btn-outline-primary btn-sm" href="<?= url_to('displayDisconDeleteProd', $data->id); ?>">View</a>
                    <?php endif; ?>
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

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const table = document.getElementById('prodlist');
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
