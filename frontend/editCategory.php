<?php
require_once "functions.php";
if (!isset($_GET["id"])) {
    header("Location: ./");
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    updateCategory($_GET["id"], $_POST);
    header("Location: ./");
}
$category = getCategory($_GET["id"]);
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
                <input value="<?= $category['name'] ?>" type="text" class="form-control" name="name" required>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="index.php" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</body>

</html>