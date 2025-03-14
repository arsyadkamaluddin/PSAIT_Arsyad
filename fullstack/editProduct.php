<?php
include 'functions.php';

if (!isset($_GET['id'])) redirect('index.php');

$id = $_GET['id'];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'name' => $_POST['name'],
        'category_id' => $_POST['category_id'],
        'description' => $_POST['description'],
        'price' => $_POST['price']
    ];
    updateProduct($data, $id);
    redirect('index.php', ['success' => 'Produk berhasil ditambahkan']);
}

$categories = getCategories();
$product = getProduct($id);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Tambah Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h2>Tambah Produk</h2>
        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Nama Produk</label>
                <input value="<?= $product['name'] ?>" type="text" class="form-control" name="name" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Kategori</label>
                <select class="form-select" name="category_id" required>
                    <?php foreach ($categories as $category): ?>
                        <option <?php
                                if ($product["category_id"] == $category['id']) echo "selected";
                                ?> value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Deskripsi</label>
                <textarea class="form-control" name="description" rows="3"><?= $product['description'] ?></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Harga</label>
                <input type="number" class="form-control" value="<?= $product['price'] ?>" name="price" required>
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="index.php" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</body>

</html>