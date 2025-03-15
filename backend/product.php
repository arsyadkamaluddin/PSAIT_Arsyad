<?php

require_once "config.php";
$request_method = $_SERVER["REQUEST_METHOD"];

switch ($request_method) {
    case 'GET':
        if (isset($_GET["id"])) {
            getProduct($_GET["id"]);
        } else {
            getProducts();
        }
        break;

    case 'POST':
        $data = json_decode(file_get_contents("php://input"), true);
        if (isset($_GET["id"])) {
            updateProduct($data, $_GET["id"]);
        } else {
            insertProduct($data);
        }
        break;

    case 'DELETE':
        if (isset($_GET["id"])) {
            deleteProduct($_GET["id"]);
        }
        break;

    default:
        header("HTTP/1.0 405 Method Not Allowed");
        break;
}

function getProducts()
{
    global $conn;
    $result = mysqli_query($conn, "SELECT * FROM products");
    $products = mysqli_fetch_all($result, MYSQLI_ASSOC);
    echo json_encode($products);
}

function getProduct($id)
{
    global $conn;
    $result = mysqli_query($conn, "SELECT * FROM products WHERE id = $id");
    $product = mysqli_fetch_assoc($result);
    echo json_encode($product);
}

function insertProduct($data)
{
    global $conn;
    $query = "INSERT INTO products (name, category_id, description, price) VALUES ('{$data['name']}', {$data['category_id']}, '{$data['description']}', {$data['price']})";
    mysqli_query($conn, $query);
    echo json_encode(["message" => "Product added successfully"]);
}

function updateProduct($data, $id)
{
    global $conn;
    $query = "UPDATE products SET name = '{$data['name']}', category_id = {$data['category_id']}, description = '{$data['description']}', price = {$data['price']} WHERE id = $id";
    mysqli_query($conn, $query);
    echo json_encode(["message" => "Product updated successfully"]);
}

function deleteProduct($id)
{
    global $conn;
    mysqli_query($conn, "DELETE FROM products WHERE id = $id");
    echo json_encode(["message" => "Product deleted successfully"]);
}
