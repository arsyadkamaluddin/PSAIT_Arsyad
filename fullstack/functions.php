<?php
require_once 'conn.php';

function redirect($url, $message = null)
{
    if ($message) {
        $_SESSION['message'] = $message;
    }
    header("Location: $url");
    exit();
}
function updateCategory($name, $id)
{
    global $conn;
    mysqli_query($conn, "UPDATE categories SET name = '$name' WHERE id = $id");
}
function updateProduct($data, $id)
{
    global $conn;
    mysqli_query($conn, "UPDATE products SET name = '{$data['name']}', category_id = {$data['category_id']}, description = '{$data['description']}', price = {$data['price']} WHERE id = {$id}");
}

function insertProduct($data)
{
    global $conn;
    mysqli_query($conn, "INSERT INTO products (name, category_id, description, price) VALUES (
        '{$data['name']}',
        {$data['category_id']},
        '{$data['description']}',
        {$data['price']}
    )");
}
function insertCategory($name)
{
    global $conn;
    mysqli_query($conn, "INSERT INTO categories (name) VALUES ('$name')");
}
function deleteCategory($id)
{
    global $conn;
    $check = mysqli_query($conn, "SELECT * FROM products WHERE category_id = $id");
    if (mysqli_num_rows($check) > 0) {
        redirect('index.php', ['danger' => 'Kategori tidak bisa dihapus karena masih memiliki produk']);
    }
    mysqli_query($conn, "DELETE FROM categories WHERE id = $id");
}
function deleteProduct($id)
{
    global $conn;
    mysqli_query($conn, "DELETE FROM products WHERE id = $id");
}

function getCategories()
{
    global $conn;
    $result = mysqli_query($conn, "SELECT * FROM categories");
    return $result;
}
function getProducts()
{
    global $conn;
    $result = mysqli_query($conn, "SELECT * FROM products");
    return $result;
}

function getProduct($id)
{
    global $conn;
    $result = mysqli_query($conn, "SELECT * FROM products WHERE id = $id");
    $row = mysqli_fetch_assoc($result);
    return $row;
}
function getCategory($id)
{
    global $conn;
    $result = mysqli_query($conn, "SELECT * FROM categories WHERE id = $id");
    $row = mysqli_fetch_assoc($result);
    return $row;
}
