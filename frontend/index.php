<?php
require 'functions.php';
if (isset($_GET["id"]) && isset($_GET["delete"]) && isset($_GET["type"])) {
    switch ($_GET["type"]) {
        case 'product':
            deleteProduct($_GET["id"]);
            break;
        case 'category':
            deleteCategory($_GET["id"]);
            break;

        default:
            break;
    }
    header("Location: ./");
}
$products = getProducts();
$categories = getCategories();

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

        <div class="row">
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
                                <?php foreach ($products as $product): ?>
                                    <tr>
                                        <td><?= $product['name'] ?></td>
                                        <td><?= getCategory($product['category_id'])['name'] ?></td>
                                        <td>Rp<?= number_format($product['price'], 0, ',', '.') ?></td>
                                        <td class="text-end">
                                            <a href="editProduct.php?id=<?= $product['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                                            <a href="index.php?delete=1&id=<?= $product['id'] ?>&type=product" class="btn btn-sm btn-danger" onclick="return confirm('Yakin?')">Delete</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
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