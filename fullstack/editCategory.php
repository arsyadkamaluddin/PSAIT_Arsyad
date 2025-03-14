<?php
include 'functions.php';

if (!isset($_GET['id'])) redirect('index.php');

$id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    updateCategory($name, $id);
    header('Location: index.php');
}
$category = getCategory($id);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Edit Category</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h2>Edit Kategori</h2>
        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Nama Kategori</label>
                <input value="<?= $category["name"] ?>" type="text" class="form-control" name="name" required>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="index.php" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</body>

</html>