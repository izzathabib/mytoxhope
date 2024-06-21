<!-- Import view from folder layouts and file app.php -->
<?= $this->extend('layouts/app.php'); ?>
<?= $this->section('content'); ?>

<table>
  <thead>
  <tr>
    <th>User Name</th>
    <th>Active</th>
  </tr>
  </thead>
  <tbody>
  <?php foreach($users as $user): ?>
  <tr>
    <td><?= $user->name; ?></td>
    <td><?= $user->active; ?></td>
  </tr>
  <?php endforeach; ?>
  </tbody>
</table>

<?= $this->endsection(); ?>
