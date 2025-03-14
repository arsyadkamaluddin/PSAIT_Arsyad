<?php
include 'functions.php';

if (isset($_GET['delete'])) {
    $id = $_GET['id'];
    $type = $_GET['type'];

    if ($type === 'category') {
        deleteCategory($id);
    } else {
        deleteProduct($id);
    }

    redirect('index.php');
}

$categories = getCategories();
$products = getProducts();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h1 class="mb-4">Product Management</h1>

        <!-- Pesan -->
        <?php if (isset($_GET['message'])): ?>
            <div class="alert alert-<?= $_GET['type'] ?>"><?= $_GET['message'] ?></div>
        <?php endif; ?>

        <div class="row">
            <!-- Daftar Kategori -->
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Categories</h5>
                        <a href="addCategory.php" class="btn btn-primary btn-sm">Add Category</a>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <tbody>
                                <?php foreach ($categories as $category): ?>
                                    <tr>
                                        <td><?= $category['name'] ?></td>
                                        <td class="text-end">
                                            <a href="editCategory.php?id=<?= $category['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                                            <a href="index.php?delete=1&id=<?= $category['id'] ?>&type=category" class="btn btn-sm btn-danger" onclick="return confirm('Yakin?')">Delete</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Daftar Produk -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Products</h5>
                        <a href="addProduct.php" class="btn btn-primary btn-sm">Add Product</a>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Category</th>
                                    <th>Price</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($product = mysqli_fetch_assoc($products)): ?>
                                    <tr>
                                        <td><?= $product['name'] ?></td>
                                        <td><?= getCategory($product['category_id'])['name'] ?></td>
                                        <td>Rp<?= number_format($product['price'], 0, ',', '.') ?></td>
                                        <td class="text-end">
                                            <a href="editProduct.php?id=<?= $product['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                                            <a href="index.php?delete=1&id=<?= $product['id'] ?>&type=product" class="btn btn-sm btn-danger" onclick="return confirm('Yakin?')">Delete</a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>