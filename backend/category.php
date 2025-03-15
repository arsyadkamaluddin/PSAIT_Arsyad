<?php

require_once "config.php";
$request_method = $_SERVER["REQUEST_METHOD"];

switch ($request_method) {
    case 'GET':
        if (isset($_GET["id"])) {
            getCategory($_GET["id"]);
        } else {
            getCategories();
        }
        break;

    case 'POST':
        $data = json_decode(file_get_contents("php://input"), true);
        if (isset($_GET["id"])) {
            updateCategory($data, $_GET["id"]);
        } elseif (isset($_GET["category"])) {
            insertCategory($data);
        }
        break;

    case 'DELETE':
        if (isset($_GET["id"])) {
            deleteCategory($_GET["id"]);
        }
        break;

    default:
        header("HTTP/1.0 405 Method Not Allowed");
        break;
}

function getCategories()
{
    global $conn;
    $result = mysqli_query($conn, "SELECT * FROM categories");
    $category = mysqli_fetch_assoc($result);
    echo json_encode($category);
}
function getCategory($id)
{
    global $conn;
    $result = mysqli_query($conn, "SELECT * FROM categories WHERE id = $id");
    $category = mysqli_fetch_assoc($result);
    echo json_encode($category);
}

function insertCategory($data)
{
    global $conn;
    $query = "INSERT INTO categories (name) VALUES ('{$data['name']}')";
    mysqli_query($conn, $query);
    echo json_encode(["message" => "Category added successfully"]);
}

function deleteCategory($id)
{
    global $conn;
    $check = mysqli_query($conn, "SELECT * FROM products WHERE category_id = $id");
    if (mysqli_num_rows($check) > 0) {
        echo json_encode(["error" => "Category cannot be deleted because it has associated products"]);
        return;
    }
    mysqli_query($conn, "DELETE FROM categories WHERE id = $id");
    echo json_encode(["message" => "Category deleted successfully"]);
}
