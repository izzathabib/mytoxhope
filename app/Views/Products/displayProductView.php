<?= $this->extend('layouts/app.php'); ?>
<?= $this->section('content'); ?>
<h1><?= esc($title) ?></h1>

<h2><?= $product['product_name']; ?></h2>

<?= $this->endsection(); ?>